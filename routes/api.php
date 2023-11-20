<?php

use App\Http\Controllers\AficheController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PatrocinadorController;
use App\Http\Controllers\SitioController;
use App\Http\Controllers\TipoActividadController;
use App\Http\Controllers\ActividadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'tipo-evento'], function () {
    Route::get('/', [TipoEventoController::class, 'index'])->name('tipo-eventos.index');
    Route::get('{id}', [TipoEventoController::class, 'show'])->name('tipo-eventos.show');
    Route::post('/', [TipoEventoController::class, 'store'])->name('tipo-eventos.store');   
    Route::post('actualizar/{id}', [TipoEventoController::class, 'update'])->name('tipo-eventos.update');
    Route::delete('{id}', [TipoEventoController::class, 'destroy'])->name('tipo-eventos.destroy');
});

Route::group(['prefix' => 'evento'], function () {
    Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('{id}', [EventoController::class, 'show'])->name('eventos.show');
    Route::post('', [EventoController::class, 'store'])->name('eventos.store');
    Route::post('actualizar/{id}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    Route::post('/afiche', [EventoController::class, 'storageAfiche'])->name('eventos.storageAfiche');
    Route::post('/afiche/{id}', [EventoController::class, 'asignarAfiche'])->name('eventos.asignarAfiche');
    Route::delete('/afiche/{id}', [EventoController::class, 'eliminarAfiche'])->name('eventos.eliminarAfiche');
    Route::post('/cancelar/{id}', [EventoController::class, 'cancelar'])->name('eventos.cancelar');
    Route::post('/anular/{id}', [EventoController::class, 'anular'])->name('eventos.anular');
    Route::post('/respaldos', [EventoController::class, 'subirRespaldos'])->name('eventos.subirRespaldos');
});

Route::group(['prefix' => 'patrocinador', 'middleware' => 'api'], function () {
    Route::get('/', [PatrocinadorController::class, 'index'])->name('patrocinadores.index');
    Route::get('{id}', [PatrocinadorController::class, 'showPatrocinadorbyEvento'])->name('patrocinadores.show');
    Route::get('/evento/{id}', [PatrocinadorController::class, 'showEventoWhithPatrocinadores'])->name('eventoPatrocinadores.show');
    Route::post('/', [PatrocinadorController::class, 'store'])->name('patrocinadores.store');
    Route::delete('{id}', [PatrocinadorController::class, 'destroy'])->name('patrocinadores.destroy');
    Route::post('/asignar', [PatrocinadorController::class, 'asignarPatrocinador'])->name('patrocinadores.asignar');
    Route::delete('/quitar/{id}', [PatrocinadorController::class, 'quitarPatrocinador'])->name('patrocinadores.quitar');
});

Route::group(['prefix' => 'afiche'], function () {
    Route::post('/imagen', [AficheController::class, 'storageAfiche'])->name('eventos.storageAfiche');
    Route::post('/', [AficheController::class, 'asignarAfiche'])->name('eventos.asignarAfiche');
    Route::post('{id}', [AficheController::class, 'update'])->name('eventos.update');
    Route::delete('/{id}', [AficheController::class, 'eliminarAfiche'])->name('eventos.eliminarAfiche');
    Route::get('/{id}', [AficheController::class, 'showPorEventoId'])->name('eventos.showPorEventoId');
});

Route::group(['prefix' => 'sitio'], function () {
    Route::get('', [SitioController::class, 'index'])->name('sitio.index');
    Route::get('{id}', [SitioController::class, 'show'])->name('sitio.show');
    Route::post('', [SitioController::class, 'store'])->name('sitio.store');
    Route::post('{id}', [SitioController::class, 'update'])->name('sitio.update');
    Route::delete('{id}', [SitioController::class, 'destroy'])->name('sitio.destroy');
});


Route::group(['prefix' => 'tipo-actividad'], function () {
    Route::get('', [TipoActividadController::class, 'index'])->name('tipo-actividad.index');
    Route::post('', [TipoActividadController::class, 'store'])->name('tipo-actividad.store');
    Route::post('{id}', [TipoActividadController::class, 'update'])->name('tipo-actividad.update');
    Route::delete('{id}', [TipoActividadController::class, 'destroy'])->name('tipo-actividad.destroy');
});
Route::group(['prefix' => 'actividad'], function () {
    Route::get('', [ActividadController::class, 'index'])->name('actividad.index');
    Route::get('{id}', [ActividadController::class, 'show'])->name('actividad.show');
    Route::post('', [ActividadController::class, 'store'])->name('actividad.store');
    Route::post('{id}', [ActividadController::class, 'update'])->name('actividad.update');
    Route::delete('{id}', [ActividadController::class, 'destroy'])->name('actividad.destroy');
    Route::get('/obtener-actividad/{id}',[ActividadController::class,'obtenerActividades'])->name('actividad.obtener-actividad');
    Route::get('/{id}', [ActividadController::class, 'actividadPorEventoId'])->name('actividad.actividadPorEventoId');
});
