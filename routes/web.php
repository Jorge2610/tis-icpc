<?php

use App\Http\Controllers\HelloWorld;
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

Route::get('/', function () {
    return view('eventos/eventos');
});

Route::get('/hello', [HelloWorld::class, 'sayHello']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//vista eventos
Route::get('/eventos', function () {
    return view('eventos/eventos');
});

Route::group(['prefix' => 'eventos'], function(){
    //Crear Evento
    Route::get('crear-evento/',[EventoController::class,'showEventForm'])->name('crear');
    //Ver tipos de evento
    Route::get('tipos-de-evento', function () {
        return view('tipos-de-evento/tiposDeEvento');
    });
    //Ruta para editar evento
    //Editar evento por id
    Route::get('editar-evento/{id}',[EventoController::class,'showEventForm'])->name('editar');
});