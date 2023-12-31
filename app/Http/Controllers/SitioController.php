<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Sitio;

class SitioController extends Controller
{
    public function index()
    {
        $sitios = Sitio::all();
        return $sitios;
    }


    public function eventosConSitios()
    {
        $eventos = Evento::where('estado', 0)->with(['sitios', 'tipoEvento' => function($q) {
            $q->withTrashed();
        }])->get();
        return view('sitiosInteres.subirSitio', ['eventos' => $eventos]);
    }

    public function eventosConSitiosQuitar()
    {
        $eventos = Evento::where('estado', 0)->with(['sitios', 'tipoEvento' => function($q){
            $q->withTrashed();
        }])->get();
        return view('sitiosInteres.quitarSitio', ['eventos' => $eventos]);
    }

    public function show($id)
    {
        $sitios = Evento::find($id)->sitios;
        return $sitios;
    }

    public function store(Request $request)
    {
        try {
            $sitio = new Sitio();
            $sitio->titulo = $request->input('titulo');
            $sitio->enlace = $request->input('enlace');
            $sitio->id_evento = $request->input('id_evento');
            $sitio->save();
            return response()->json(['mensaje' => 'Sitio asignado correctamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $sitio = Sitio::find($id);
            $sitio->delete();
            return response()->json(['mensaje' => 'Quitado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $sitio = Sitio::find($id);
            $sitio->titulo = $request->input('titulo');
            $sitio->enlace = $request->input('enlace');
            $sitio->id_evento = $request->input('id_evento');
            $sitio->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }
}
