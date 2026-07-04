<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RandomController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\CuestionarioController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ForgotPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

 Route::get('/', function () {
 return view('home');
 })->middleware('auth');

 Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'login'])->name('login');
    Route::post('/logins', [LoginController::class, 'loginsession']);
});

Route::get('/registro', [RegisterController::class, 'registro'])->name('registro.index');
Route::post('/registros', [RegisterController::class, 'create']);
Route::get('/logout', [LoginController::class, 'destroy'])->name('destroy.index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [LoginController::class, 'home']);
    Route::get('/random', [RandomController::class, 'random'])->name('random.index');
    Route::get('/randomuser', [RandomController::class, 'Consultar_participantes']);
    Route::get('/countuser', [RandomController::class, 'numero_participantes']);
    Route::get('/cuestionario', [CuestionarioController::class, 'Cuestionario'])->name('cuestionario');
    Route::get('/randomcuest', [CuestionarioController::class, 'Randomcuest']);
    Route::post('/update-question-status', [CuestionarioController::class, 'updateQuestionStatus']);
});

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
