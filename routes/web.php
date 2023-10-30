<?php

use App\Http\Controllers\AficheController;
use App\Http\Controllers\PatrocinadorController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\HomeController;
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

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/', [EventoController::class, 'cargarEventos']);

Route::group(['prefix' => 'eventos'], function () {
    Route::get('/', [EventoController::class, 'cargarEventos']);
    Route::get('crear-evento', [EventoController::class, 'showEventForm'])->name('crear');
    Route::get('tipos-de-evento', [TipoEventoController::class, 'mostrarVistaTipoEvento'])->name('tipo-evento');
    Route::get('{nombre}', [EventoController::class, 'cargarEvento'])->name('evento.cargarEvento');
    Route::get('editar-evento/{id}', [EventoController::class, 'showEventForm'])->name('evento.editar');
});

Route::group(['prefix' => 'afiche'], function () {
    Route::get('asignar', [AficheController::class, 'vistaTablaEventos'])->name('afiche.tablaEventos');
});

Route::group(['prefix' => 'patrocinador'], function () {
    Route::get('asignar', [PatrocinadorController::class, 'vistaTablaEventos'])->name('patrocinador.tablaEventos');
});