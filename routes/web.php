<?php

use App\Http\Controllers\AficheController;
use App\Http\Controllers\PatrocinadorController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SitioController;
use App\Http\Controllers\ActividadController;
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
    Route::get('anular-evento', [EventoController::class, 'eventosValidosAnular'])->name('anular-evento');
    Route::get('afiche', [AficheController::class, 'vistaTablaEventos'])->name('afiche.tablaEventos');
    Route::get('patrocinador', [PatrocinadorController::class, 'vistaTablaEventos'])->name('patrocinador.tablaEventos');
    Route::get('patrocinador/eliminar', [PatrocinadorController::class, 'vistaTablaEventosEliminar'])->name('patrocinador.tablaEventosEliminar');
    Route::get('sitio', [SitioController::class, 'eventosConSitios'])->name('sitio.tablaEventos');
    Route::get('sitio/quitar', [SitioController::class, 'eventosConSitiosQuitar'])->name('sitio.tablaEventosizar');
});

Route::group(['prefix' => 'eventos'], function () {
    Route::get('/', [EventoController::class, 'cargarEventos']);
    //Route::get('crear-evento', [EventoController::class, 'showEventForm'])->name('crear');
    //Route::get('tipos-de-evento', [TipoEventoController::class, 'mostrarVistaTipoEvento'])->name('tipo-evento');
    //Route::get('crear-tipo', [TipoEventoController::class, 'mostrarCrearTipo'])->name('crear-tipo');
    Route::get('{nombre}', [EventoController::class, 'cargarEvento'])->name('evento.cargarEvento');
    Route::get('editar-evento/{id}', [EventoController::class, 'showEventForm'])->name('evento.editar');
    Route::get('inscripcion-evento/{id}', [EventoController::class, 'vistaInscripcion'])->name('evento.inscripcion');
});

Route::group(['prefix' => 'afiche'], function () {
    Route::get('asignar', [AficheController::class, 'vistaTablaEventos'])->name('afiche.tablaEventos');
    Route::get('editar', [AficheController::class, 'editarAfiche'])->name('afiche.editar');
    Route::get('eliminar', [AficheController::class, 'eliminarAficheVista'])->name('afiche.eliminar');
});

Route::group(['prefix' => 'admin/patrocinador'], function () {
    Route::get('/', [PatrocinadorController::class, 'vistaCrearPatrocinador'])->name('patrocinador.crearPatrocinador');
    Route::get('/editar', [PatrocinadorController::class, 'vistaEditarPatrocinador'])->name('patrocinador.editarPatrocinador');
    Route::get('/eliminar', [PatrocinadorController::class, 'vistaEliminarPatrocinador'])->name('patrocinador.eliminarPatrocinador');
    Route::get('/asignar', [PatrocinadorController::class, 'vistaAsignarPatrocinador'])->name('patrocinador.asignarPatrocinador');
    Route::get('/quitar', [PatrocinadorController::class, 'vistaQuitarPatrocinador'])->name('patrocinador.quitarPatrocinador');
});

Route::group(['prefix' => 'admin/actividad'], function () {
    Route::get('/', [ActividadController::class, 'vistaTablaActividades'])->name('actividad.crearActividad');
    Route::get('crear-actividad/{id}', [ActividadController::class, 'crearActividad'])->name('actividad.formCrearActividad');
    Route::get('/eliminar', [ActividadController::class, 'listarEventos'])->name('actividad.listar');
    Route::get('/editar-actividad', [ActividadController::class, 'listaEditar'])->name('actividad.listarEditar');
    Route::get('/editar-actividad/{id}', [ActividadController::class, 'editarActividad'])->name('actividad.editarActividad');
});

Route::get('editarEvento', [EventoController::class, 'showEditEventForm']);

Route::group(['prefix' => 'admin/tipos-de-actividad'], function () {
    Route::view('/crear-tipo', 'tipo-actividad.crearTipoActividad')->name('crear-tipo');
});

Route::get('/mailable', function () {
    $invoice = App\Models\Participante::find(1);
    return new App\Mail\ConfirmacionParticipante($invoice);
});