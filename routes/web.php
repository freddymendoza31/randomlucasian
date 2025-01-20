<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\TransferirController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CuentasBancariasController;
use App\Http\Controllers\AgregarCtaBancariasController;
use App\Http\Controllers\RandomController;


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
    Route::get('/login', [LoginController::class, 'login'])->name('login.index');
    Route::post('/logins', [LoginController::class, 'loginsession']);
});

Route::get('/registro', [RegisterController::class, 'registro'])->name('registro.index');
Route::post('/registros', [RegisterController::class, 'create']);
Route::get('/logout', [LoginController::class, 'destroy'])->name('destroy.index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [LoginController::class, 'home']);
    Route::get('/random', [RandomController::class, 'random'])->name('random.index');
    Route::get('/randomuser', [RandomController::class, 'Consultar_participantes']);
    
});