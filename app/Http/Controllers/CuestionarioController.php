<?php

namespace App\Http\Controllers;

use App\Models\LogsModel;
use App\Models\CuestionarioModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CuestionarioController extends Controller
{
    public function Cuestionario()
    {
        RandomController::Logs();
        return view('cuestionario');
    }

public function Randomcuest()
    {
        RandomController::Logs();
        $result = CuestionarioModel::all()->where('status', 1);

        if ($result->isEmpty()) {
            CuestionarioModel::where('status', '=', 2)->update(['status' => 1]);
            return response()->json(['msj' => 'Se reiniciaron los registros, por favor presiona otra vez el botón cuestionario']);
        } else {
            echo json_encode($result);
        }

    }

   public function updateQuestionStatus(Request $request)
    {
        $question = CuestionarioModel::find($request->id);
        $question->status = 2;
        $question->save();
        return response()->json(['success' => 'Status change successfully.']);
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
