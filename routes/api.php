<?php

use App\Http\Controllers\AficheController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\PatrocinadorController;
use App\Http\Controllers\SitioController;
use App\Http\Controllers\ActividadController;
use App\Http\Controllers\ParticipanteController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\NotificacionController;
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

Route::group(
    [
        'prefix' => 'tipo-evento',
        'controller' => TipoEventoController::class
    ],
    function () {
        Route::get('/',  'index')->name('tipo-eventos.index');
        Route::get('{id}', 'show')->name('tipo-eventos.show');
        Route::post('/', 'crear')->name('tipo-eventos.crear');
        Route::post('actualizar/{id}', 'update')->name('tipo-eventos.update');
        Route::delete('{id}', 'destroy')->name('tipo-eventos.destroy');
        Route::post('restaurar/{id}', 'restaurar')->name('tipo-eventos.restaurar');
    }
);

Route::group(
    [
        'prefix' => 'evento',
        'controller' => EventoController::class
    ],
    function () {
        Route::get('/', 'index')->name('eventos.index');
        Route::get('{id}', 'show')->name('eventos.show');
        Route::post('/', 'store')->name('eventos.store');
        Route::post('actualizar/{id}',  'update')->name('eventos.update');
        Route::delete('{id}', 'destroy')->name('eventos.destroy');
        Route::post('/afiche', 'storageAfiche')->name('eventos.storageAfiche');
        Route::post('/afiche/{id}', 'asignarAfiche')->name('eventos.asignarAfiche');
        Route::delete('/afiche/{id}', 'eliminarAfiche')->name('eventos.eliminarAfiche');
        Route::post('/cancelar/{id}', 'cancelar')->name('eventos.cancelar');
        Route::post('/anular/{id}', 'anular')->name('eventos.anular');
        Route::post('/respaldos', 'subirRespaldos')->name('eventos.subirRespaldos');
    }
);

Route::group(
    [
        'prefix' => 'patrocinador',
        'controller' => PatrocinadorController::class
    ],
    function () {
        Route::get('/', 'index')->name('patrocinadores.index');
        Route::get('{id}', 'showPatrocinadorbyEvento')->name('patrocinadores.show');
        Route::get('/show/{id}', 'show')->name('patrocinadores.show');
        Route::get('/evento/{id}', 'showEventoWhithPatrocinadores')->name('eventoPatrocinadores.show');
        Route::post('/', 'store')->name('patrocinadores.store');
        Route::post('/editar/{id}', 'update')->name('patrocinadores.update');
        Route::delete('{id}', 'destroy')->name('patrocinadores.destroy');
        Route::post('/asignar', 'asignarPatrocinador')->name('patrocinadores.asignar');
        Route::delete('/quitar/{id}', 'quitarPatrocinador')->name('patrocinadores.quitar');
        Route::post('/esta-borrado', 'estaBorrado')->name('patrocinadores.estaBorrado');
        Route::post('/restaurar/{id}', 'restaurar')->name('patrocinadores.restore');
    }
);

Route::group(
    [
        'prefix' => 'afiche',
        'controller' => AficheController::class
    ],
    function () {
        Route::post('/imagen', 'storageAfiche')->name('eventos.storageAfiche');
        Route::post('/', 'asignarAfiche')->name('eventos.asignarAfiche');
        Route::post('{id}', 'update')->name('eventos.update');
        Route::delete('{id}', 'eliminarAfiche')->name('eventos.eliminarAfiche');
        Route::get('{id}', 'showPorEventoId')->name('eventos.showPorEventoId');
    }
);

Route::group(
    [
        'prefix' => 'sitio',
        'controller' => SitioController::class
    ],
    function () {
        Route::get('/', 'index')->name('sitio.index');
        Route::get('{id}', 'show')->name('sitio.show');
        Route::post('/', 'store')->name('sitio.store');
        Route::post('{id}', 'update')->name('sitio.update');
        Route::delete('{id}', 'destroy')->name('sitio.destroy');
    }
);


Route::group(
    [
        'prefix' => 'actividad',
        'controller' => ActividadController::class
    ],
    function () {
        Route::get('/', 'index')->name('actividad.index');
        Route::get('{id}', 'show')->name('actividad.show');
        Route::post('/', 'store')->name('actividad.store');
        Route::post('{id}', 'update')->name('actividad.update');
        Route::delete('{id}', 'destroy')->name('actividad.destroy');
        Route::get('/obtener-actividad/{id}', 'obtenerActividades')->name('actividad.obtener-actividad');
        Route::get('{id}', 'actividadPorEventoId')->name('actividad.actividadPorEventoId');
    }
);

Route::group(
    [
        'prefix' => 'participante',
        'controller' => ParticipanteController::class
    ],
    function () {
        Route::any('/existe', 'existeParticipante');
        Route::get('{id}', 'participantesEvento');
        Route::post('/', 'inscribirEvento');
        Route::post('/enviarCodigo/{id}/{id2}', 'enviarCodigoCorreo');
        Route::post('/verificarCodigo/{id}', 'verificarCodigo');
        Route::get('/participantes', 'participantesEvento');
        Route::any('/verificar/{id}', 'verificarParticipante');
    }
);

Route::group(
    [
        'prefix' => 'equipo',
        'controller' => EquipoController::class
    ],
    function () {
        Route::get('/', 'index');
        Route::any('/existe', 'existeEquipo');
        Route::post('/inscribirEquipo', 'inscribirEquipoEvento');
        Route::post('/addIntegrante/{id}', 'addIntegrante');
        Route::get('/{id}', 'mostrarEquipo');
        Route::get('/integrantes/{id}', 'mostrarIntegrantes');
        Route::post('/verificarCodigo/{id}', 'verificarCodigo');
        //Route::post('/enviarCorreo/{id}/{id}', 'enviarCorreo');
    }
);

Route::group(
    [
        'prefix' => 'notificacion',
        'controller' => NotificacionController::class
    ],
    function () {
        Route::post('/archivos', 'storeArchivo');
        Route::get('/{id}', 'getParticipantes');
        Route::post('/', 'notificar');
    }
);
