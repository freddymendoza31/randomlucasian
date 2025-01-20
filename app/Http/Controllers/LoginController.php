<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\LoginModel;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CuentasBancariasModel;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/home'); // Redirige si el usuario ya está autenticado
        }
    
        return response()
            ->view('auth.login') // Carga la vista del login
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 2000 00:00:00 GMT');
        
    }

    public function home(){
        return redirect('/');
    }

    public function loginsession(Request $request){
       
        if (Auth()->attempt(Request(['email', 'password'])) == false) {

            $result['error'] = true;
            $result['msj'] = 'Contraseña o cédula son incorrectos';
            $result['url'] =  NULL;
            echo json_encode($result);
             return;
        }else{
            $result['error'] = false;
            $result['msj'] = 'Iniciando sistema...';
            $result['url'] =  '/';
        }
        echo json_encode($result);
        LoginController::usuario();
    }

    public function destroy()
    {
        auth()->logout();
        return redirect()->to('/');
    }


    public function usuario(){
        $user = LoginModel::where('id',Auth()->id())->first();
        Session::put(['sessionName' =>  $user->name]);
    }
}
