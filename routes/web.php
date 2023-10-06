<?php

use App\Http\Controllers\HelloWorld;
use App\Http\Controllers\TipoEventoController;
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
    return view('welcome');
});

Route::get('/hello', [HelloWorld::class, 'sayHello']);
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//vista eventos
Route::get('/eventos', function () {
    return view('eventos');
});
//modal formulario evento
Route::get('/eventos/crear-evento', function () {
    return view('crearEvento');
});

//modal tipo de evento
Route::post('/eventos/crear-evento', [App\Http\Controllers\ModalTipoEvento::class, 'procesarFormulario'])->name('ModalTipoEvento');