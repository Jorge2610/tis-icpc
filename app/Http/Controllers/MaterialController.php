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
        return view('subirMaterial.eventos', ['eventos' => $eventos]);
    }

    public function show($id)
    {
        $material = Material::find($id);
        return $material;
    }
    
    public function store(Request $request)
    {
        try {
            $material = new Material();
            $material->titulo = $request->input('titulo');
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

    public function update(Request $request, $id)
    {
        try {
            $material = Material::find($id);
            $material->titulo = $request->input('titulo');
            $material->enlace = $request->input('enlace');
            $material->id_evento = $request->input('id_evento');
            $material->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }
}
