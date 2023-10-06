<?php

namespace App\Http\Controllers;

use App\Models\TipoEvento;
use Illuminate\Http\Request;

class TipoEventoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipo_eventos = TipoEvento::all();
        return $tipo_eventos;
    }

    public function store(Request $request)
    {
        $tipo_evento = new TipoEvento();
        $tipo_evento->nombre = $request->nombre;
        $tipo_evento->descripcion = $request->descripcion;
        $tipo_evento->color = $request->color;
        $tipo_evento->save();
        return "Guardado exitosamente";
    }

    public function update(Request $request, $id)
    {
        $tipo_evento = TipoEvento::find($id);
        $tipo_evento->nombre = $request->nombre;
        $tipo_evento->descripcion = $request->descripcion;
        $tipo_evento->color = $request->color;
        $tipo_evento->save();
        return "Actualizado exitosamente";
    }

    public function destroy($id)
    {
        $tipo_evento = TipoEvento::find($id);
        $tipo_evento->delete();
        return "Eliminado exitosamente";
    }

    public function show($id)
    {
        $tipo_evento = TipoEvento::find($id);
        return $tipo_evento;
    }

    public function all()
    {
        
    }
}
