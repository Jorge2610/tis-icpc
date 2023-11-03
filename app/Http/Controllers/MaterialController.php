<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Material;

use App\Models\Evento;

class MaterialController extends Controller
{
    public function index()
    {
        $materiales = Material::all();
        return $materiales;
    }

    public function eventosConMaterial()
    {
        $eventos = Evento::with('materiales')->get();
        //cambiar tu vista aqui Yanina!!! 
        return view('material.eventos', ['eventos' => $eventos]);
    }

    public function store(Request $request)
    {
        try {
            $material = new Material();
            $material->nombre = $request->input('nombre');
            $material->enlace = $request->input('enlace');
            $material->id_evento = $request->input('id_evento');
            $material->save();
            return response()->json(['mensaje' => 'Material asignado correctamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $material = Material::find($id);
            $material->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }
}
