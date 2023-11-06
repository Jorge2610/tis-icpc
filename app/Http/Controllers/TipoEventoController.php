<?php

namespace App\Http\Controllers;

use App\Models\TipoEvento;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

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
        try {
            $tipo_evento = new TipoEvento();
            $tipo_evento->nombre = $request->nombre;
            $tipo_evento->descripcion = $request->descripcion;
            $tipo_evento->color = $request->color;
            $tipo_evento->save();
            return response()->json(['mensaje' => 'Creado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                $respuesta = response()->json(['mensaje' => 'El tipo de evento ya existe', 'error' => true]);
            } else {
                if ($errorCode == 1406) {
                    $respuesta = response()->json(['mensaje' => 'Campo demasiado grande', 'error' => true]);
                } else {
                    $respuesta = $e->getMessage();
                }
            }
            return $respuesta;
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tipo_evento = TipoEvento::find($id);
            $tipo_evento->nombre = $request->nombre;
            $tipo_evento->descripcion = $request->descripcion;
            $tipo_evento->color = $request->color;
            $tipo_evento->save();
            return redirect()->route('tipo-evento')->with('success', 'Tipo de evento actualizado exitosamente');
            //return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['mensaje' => 'El tipo de evento ya existe', 'error' => true]);
            } else {
                if ($e->errorInfo[1] == 1406) {
                    return response()->json(['mensaje' => 'Campo demasiado grande', 'error' => true]);
                } else {
                    return $e->getMessage();
                }
            }
        }
    }

    public function destroy($id)
    {
        try {
            $tipo_evento = TipoEvento::find($id);
            $tipo_evento->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1451) {
                return response()->json(['mensaje' => 'El tipo de evento tiene eventos asociados', 'error' => true]);
            }
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        $tipo_evento = TipoEvento::find($id);
        return $tipo_evento;
    }

    public function mostrarVistaTipoEvento()
    {
        $tiposDeEventos =  TipoEvento::all();
        return view('tipos-de-evento/tiposDeEvento', ['tiposDeEventos' => $tiposDeEventos]);
    }

    public function mostrarCrearTipo()
    {
        return view('tipos-de-evento/crearTiposDeEvento');
    }

    public function cargarTipoEvento($id)
    {
        $tipoEvento = TipoEvento::find($id);
        return view('tipos-de-evento/editarTiposDeEvento', compact('tipoEvento'));
    }
}
