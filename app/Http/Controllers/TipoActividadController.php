<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\tipoActividad;

class TipoActividadController extends Controller
{
    public function index()
    {
        $tipo_actividades = tipoActividad::all();
        return $tipo_actividades;
    }

    public function store(Request $request)
    {
        try {
            $tipo_actividad = new tipoActividad();
            $tipo_actividad->nombre = $request->nombre;
            $tipo_actividad->descripcion = $request->descripcion;
            $tipo_actividad->save();
            return response()->json(['mensaje' => 'Guardado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $tipo_actividad = tipoActividad::find($id);
            $tipo_actividad->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function vistaTipoDeActividad()
    {
        $tipoActividades = tipoActividad::all();
        //return view('tipoActividad', compact('tipoActividades'));
    }
}
