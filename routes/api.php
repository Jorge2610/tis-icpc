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

Route::group(['prefix' => 'tipo-evento'], function () {
    Route::get('/', [TipoEventoController::class, 'index'])->name('tipo-eventos.index');
    Route::get('/{id}', [TipoEventoController::class, 'show'])->name('tipo-eventos.show');
    Route::post('/', [TipoEventoController::class, 'store'])->name('tipo-eventos.store');
    Route::put('/{id}', [TipoEventoController::class, 'update'])->name('tipo-eventos.update');
    Route::delete('/{id}', [TipoEventoController::class, 'destroy'])->name('tipo-eventos.destroy');
});

Route::group(['prefix' => 'eventos'], function () {
    Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
    Route::get('/{id}', [EventoController::class, 'show'])->name('eventos.show');
    Route::post('/', [EventoController::class, 'store'])->name('eventos.store');
    Route::put('/{id}', [EventoController::class, 'update'])->name('eventos.update');
    Route::delete('/{id}', [EventoController::class, 'destroy'])->name('eventos.destroy');
    Route::post('/afiche', [EventoController::class, 'storageAfiche'])->name('eventos.storageAfiche');
    Route::put('/afiche/{id}', [EventoController::class, 'asignarAfiche'])->name('eventos.asignarAfiche');
    Route::delete('/afiche/{id}', [EventoController::class, 'destroyAfiche'])->name('eventos.desasignarAfiche');
});




