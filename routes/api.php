<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipoEventoController;
use App\Http\Controllers\EventoController;

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

// Ruta para crear tipos de eventos
Route::post('/tipo-evento', [TipoEventoController::class, 'store'])->name('tipo-eventos.store');
// Ruta para mostrar tipos de eventos
Route::get('/tipo-eventos', [TipoEventoController::class, 'index']);
// Ruta para crear eventos
Route::post('/evento', [EventoController::class, 'store'])->name('eventos.store');
