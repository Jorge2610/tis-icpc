<?php

use App\Http\Controllers\AficheController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PatrocinadorController;
use App\Http\Controllers\RecursoController;

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
    Route::post('/', [PatrocinadorController::class, 'store'])->name('patrocinadores.store');
    Route::delete('{id}', [PatrocinadorController::class, 'destroy'])->name('patrocinadores.destroy');
    Route::post('/asignar/{id}', [PatrocinadorController::class, 'asignarPatrocinador'])->name('patrocinadores.asignar');
    Route::delete('/quitar/{id}', [PatrocinadorController::class, 'quitarPatrocinador'])->name('patrocinadores.quitar');
});

Route::group(['prefix' => 'afiche'], function () {
    Route::post('/imagen', [AficheController::class, 'storageAfiche'])->name('eventos.storageAfiche');
    Route::post('/', [AficheController::class, 'asignarAfiche'])->name('eventos.asignarAfiche');
    Route::post('{id}', [AficheController::class, 'update'])->name('eventos.update');
    Route::delete('/{id}', [AficheController::class, 'eliminarAfiche'])->name('eventos.eliminarAfiche');
    Route::get('/{id}', [AficheController::class, 'showPorEventoId'])->name('eventos.showPorEventoId');
});

Route::group(['prefix' => 'recurso'], function () {
    Route::get('', [RecursoController::class, 'index'])->name('recurso.index');
    Route::get('{id}', [RecursoController::class, 'show'])->name('recurso.show');
    Route::post('', [RecursoController::class, 'store'])->name('recurso.store');
    Route::post('{id}', [RecursoController::class, 'update'])->name('recurso.update');
    Route::delete('{id}', [RecursoController::class, 'destroy'])->name('recurso.destroy');
});
