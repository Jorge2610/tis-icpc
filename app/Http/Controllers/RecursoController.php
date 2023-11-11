<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Recurso;

use App\Models\Evento;

class RecursoController extends Controller
{
    public function index()
    {
        $recursos = Recurso::all();
        return $recursos;
    }


    public function eventosConRecurso()
    {
        $eventos = Evento::where('estado', 0)->with('recursos')->get();
        return view('eventos.subirMaterial', ['recursos' => $eventos]);
    }

    public function show($id)
    {
        $recurso = Recurso::find($id);
        return $recurso;
    }
    
    public function store(Request $request)
    {
        try {
            $recurso = new Recurso();
            $recurso->titulo = $request->input('titulo');
            $recurso->enlace = $request->input('enlace');
            $recurso->id_evento = $request->input('id_evento');
            $recurso->save();
            return response()->json(['mensaje' => 'Sitio asignado correctamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $recurso = Recurso::find($id);
            $recurso->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $recurso = Recurso::find($id);
            $recurso->titulo = $request->input('titulo');
            $recurso->enlace = $request->input('enlace');
            $recurso->id_evento = $request->input('id_evento');
            $recurso->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }
}
