<?php

namespace App\Http\Controllers;

use App\Models\RandomModel;
use App\Models\LogsModel;
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
