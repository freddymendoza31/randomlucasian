<?php

namespace App\Http\Controllers;

use App\Models\RandomModel;

use Illuminate\Http\Request;

class RandomController extends Controller
{
    //
    public function random()
    {
        return view('random');
    }

    public function Consultar_participantes()
    {
        
        $result = RandomModel::where('status', 1)->inRandomOrder()->first();
        if ($result) {
            $result->status = 2; // Actualizar el estado a 2
            $result->save();
            echo json_encode($result);
        } else {
            // Cambiar todos los registros a status = 1
            RandomModel::where('status', '!=', 1)->update(['status' => 1]);
            echo json_encode('Se reiniciaron los registros, por favor Presiona otra vez el botón random');
        }
    }
}
