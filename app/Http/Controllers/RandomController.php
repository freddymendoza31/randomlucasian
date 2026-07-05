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
            ->orderByRaw('CASE WHEN status = 2 THEN 0 ELSE 1 END')
            ->orderByDesc('updated_at')
            ->orderBy('nombres_apellidos')
            ->get();

        return response()->json($participantes);
    }

    public function guardar_participante(Request $request)
    {
        RandomController::Logs();

        $data = $request->validate([
            'id' => ['nullable', 'integer', 'exists:participantes,id'],
            'nombres_apellidos' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'integer', 'in:1,2'],
        ]);

        $incomingStatus = (int) ($data['status'] ?? 1);
        $incomingName = trim($data['nombres_apellidos']);
        $participante = !empty($data['id'])
            ? RandomModel::findOrFail($data['id'])
            : new RandomModel();
        $isExistingParticipant = $participante->exists;
        $statusChanged = $isExistingParticipant && (int) $participante->status !== $incomingStatus;

        $participante->nombres_apellidos = $incomingName;
        $participante->status = $incomingStatus;

        if ($isExistingParticipant && ! $statusChanged) {
            $participante->timestamps = false;
            $participante->save();
            $participante->timestamps = true;
        } else {
            $participante->save();
        }

        $accion = $isExistingParticipant ? 'actualizar_participante' : 'crear_participante';
        $detalle = $isExistingParticipant
            ? "ID {$participante->id} | Nombre: {$participante->nombres_apellidos} | Estado: {$participante->status}"
            : "Nombre: {$participante->nombres_apellidos} | Estado: {$participante->status}";

        self::registrarAccion($accion, $detalle);

        return response()->json([
            'success' => true,
            'message' => !empty($data['id'])
                ? 'Participante actualizado correctamente.'
                : 'Participante creado correctamente.',
            'participante' => [
                'id' => $participante->id,
                'nombres_apellidos' => $participante->nombres_apellidos,
                'status' => $participante->status,
                'updated_at' => $participante->updated_at,
            ],
        ]);
    }

    public function eliminar_participante(Request $request)
    {
        RandomController::Logs();

        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:participantes,id'],
        ]);

        $participante = RandomModel::findOrFail($data['id']);
        $detalle = "ID {$participante->id} | Nombre: {$participante->nombres_apellidos} | Estado: {$participante->status}";
        $participante->delete();
        self::registrarAccion('eliminar_participante', $detalle);

        return response()->json([
            'success' => true,
            'message' => 'Participante eliminado correctamente.',
        ]);
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

        self::registrarAccion('actualizacion_masiva', "Participantes actualizados: {$updatedCount}");

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
        self::registrarAccion(
            'cambiar_estado_participante',
            "ID {$participante->id} | Nombre: {$participante->nombres_apellidos} | Estado: {$participante->status}"
        );

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

    public static function registrarAccion(string $accion, ?string $detalle = null)
    {
        $insert = new LogsModel();
        $insert->iduser = Auth()->user()->id;
        $insert->nombre = Auth()->user()->name;
        $insert->ruta = url()->current();
        $insert->metodo = request()->method();
        $insert->ip = request()->ip();
        $insert->accion = $accion;
        $insert->detalle = $detalle;
        $insert->save();
    }
}
