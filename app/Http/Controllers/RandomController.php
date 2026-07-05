<?php

namespace App\Http\Controllers;

use App\Models\RandomModel;
use App\Models\LogsModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RandomController extends Controller
{
     public function random()
    {
        RandomController::Logs();
        return view('random');
    }
    
   public function Consultar_participantes()
    {
         RandomController::Logs();
        $result = RandomModel::where('status', 1)->inRandomOrder()->first();
        if ($result) {
            $result->status = 2; // Actualizar a estado 2
            $result->save();
            echo json_encode($result);
        } else {
          // Cambiar todos los registros a status = 1
            RandomModel::where('status', '=', 2)->update(['status' => 1]);
            return response()->json(['nombres_apellidos' => 'Se reiniciaron los registros, por favor presiona otra vez el botón random']);
        }
    }

    public function numero_participantes(){
        $count = RandomModel::where('status', 1)->count();
        //return response()->json(['total_participantes_activos' => $count]); // genera un array
        return response()->json($count);
    }

    public function listar_participantes()
    {
        $participantes = RandomModel::select('id', 'nombres_apellidos', 'status', 'updated_at')
            ->orderByDesc('status')
            ->orderBy('nombres_apellidos')
            ->get();

        return response()->json($participantes);
    }

    public function actualizar_participantes(Request $request)
    {
        RandomController::Logs();

        $data = $request->validate([
            'participantes' => ['required', 'array'],
            'participantes.*.id' => ['required', 'integer', 'exists:participantes,id'],
            'participantes.*.status' => ['required', 'integer', 'in:1,2'],
        ]);

        $updatedCount = 0;

        DB::transaction(function () use ($data, &$updatedCount) {
            foreach ($data['participantes'] as $item) {
                $participante = RandomModel::find($item['id']);

                if ($participante && (int) $participante->status !== (int) $item['status']) {
                    $participante->status = (int) $item['status'];
                    $participante->save();
                    $updatedCount++;
                }
            }
        });

        return response()->json([
            'success' => true,
            'message' => $updatedCount > 0
                ? 'Los participantes se actualizaron correctamente.'
                : 'No hubo cambios para guardar.',
        ]);
    }

    public function actualizar_estado_participante(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:participantes,id'],
            'status' => ['required', 'integer', 'in:1,2'],
        ]);

        $participante = RandomModel::findOrFail($data['id']);
        $participante->status = (int) $data['status'];
        $participante->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado actualizado correctamente.',
            'participante' => [
                'id' => $participante->id,
                'status' => $participante->status,
                'updated_at' => $participante->updated_at,
            ],
        ]);
    }
    
    public static function Logs(){

        $insert = new LogsModel();
        $insert->iduser = Auth()->user()->id;
        $insert->nombre = Auth()->user()->name;
        $insert->ruta = url()->current();
        $insert->metodo = request()->method();
        $insert->ip = request()->ip();
        $insert->save();

    }
}
