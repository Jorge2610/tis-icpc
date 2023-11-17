<?php

use App\Http\Controllers\AficheController;
use App\Http\Controllers\PatrocinadorController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecursoController;
use App\Http\Controllers\ActividadController;
use App\Models\Recurso;
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

Route::group(['prefix' => 'admin/tipos-de-evento'], function () {
    Route::get('/', [TipoEventoController::class, 'mostrarVistaTipoEvento'])->name('tipo-evento');
    Route::get('crear-tipo', [TipoEventoController::class, 'mostrarCrearTipo'])->name('crear-tipo');
    Route::get('editar-tipo', [TipoEventoController::class, 'administrarTipoEvento'])->name('editar.tipo-evento');
    Route::get('/editar-tipo-evento/{id}', [TipoEventoController::class, 'cargarTipoEvento'])->name('tipo-evento.cargar');
    Route::get('eliminar-tipo', [TipoEventoController::class, 'eliminarTipoEvento'])->name('eliminar.tipo-evento');
});

Route::group(['prefix' => 'admin/eventos'], function () {
    Route::get('crear-evento', [EventoController::class, 'showEventForm'])->name('crear');
    Route::get('cancelar-evento', [EventoController::class, 'eventosValidos'])->name('cancelar-evento');
    Route::get('afiche', [AficheController::class, 'vistaTablaEventos'])->name('afiche.tablaEventos');
    Route::get('recurso', [RecursoController::class, 'eventosConRecurso'])->name('material.tablaEventos');
});

Route::group(['prefix' => 'eventos'], function () {
    Route::get('/', [EventoController::class, 'cargarEventos']);
    //Route::get('crear-evento', [EventoController::class, 'showEventForm'])->name('crear');
    //Route::get('tipos-de-evento', [TipoEventoController::class, 'mostrarVistaTipoEvento'])->name('tipo-evento');
    //Route::get('crear-tipo', [TipoEventoController::class, 'mostrarCrearTipo'])->name('crear-tipo');
    Route::get('{nombre}', [EventoController::class, 'cargarEvento'])->name('evento.cargarEvento');
    Route::get('editar-evento/{id}', [EventoController::class, 'showEventForm'])->name('evento.editar');
});

Route::group(['prefix' => 'afiche'], function () {
    Route::get('asignar', [AficheController::class, 'vistaTablaEventos'])->name('afiche.tablaEventos');
    Route::get('editar', [AficheController::class, 'editarAfiche'])->name('afiche.editar');
    Route::get('eliminar', [AficheController::class, 'eliminarAficheVista'])->name('afiche.eliminar');
});

Route::group(['prefix' => 'admin/patrocinador'], function () {
    Route::get('/', [PatrocinadorController::class, 'vistaCrearPatrocinador'])->name('patrocinador.crearPatrocinador');
    Route::get('/eliminar', [PatrocinadorController::class, 'vistaEliminarPatrocinador'])->name('patrocinador.eliminarPatrocinador');
    Route::get('/asignar', [PatrocinadorController::class, 'vistaTablaEventos'])->name('patrocinador.tablaEventos');
});

Route::group(['prefix' => 'admin/actividad'], function () {
    Route::get('/', [ActividadController::class, 'vistaTablaActividades'])->name('actividad.crearActividad');
    Route::get('crear-actividad/{id}',[ActividadController::class,'crearActividad'])->name('actividad.formCrearActividad');
});

Route::get('editarEvento', [EventoController::class, 'showEditEventForm']);
