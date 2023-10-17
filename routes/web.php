<?php

use App\Http\Controllers\HelloWorld;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\EventoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [EventoController::class, 'cargarEventos']);

Route::group(['prefix' => 'eventos'], function(){
    Route::get('/', [EventoController::class, 'cargarEventos']);
    Route::get('crear-evento', function () {return view('crear-evento/crearEvento');});
    Route::get('tipos-de-evento', function () {return view('tipos-de-evento/tiposDeEvento');});
    Route::get('{nombre}', [EventoController::class, 'cargarEvento'])->name('evento.cargarEvento');
});