<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Models\User;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ], [
            'email.required' => 'El campo email es obligatorio.',
            'email.email' => 'El correo debe ser válido.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->password = $password; // 🔹 El mutator encripta automáticamente la contraseña
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __('Tu contraseña ha sido restablecida.'));
        } else {
            return back()->withErrors(['email' => __('El token es inválido o ha expirado.')]);
        }
    }
}



