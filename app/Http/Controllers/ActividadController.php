<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Evento;

class ActividadController extends Controller
{
    public function index(){
        $actividades = Actividad::all();
        return $actividades;
    }

    public function eventosConActividades(){
        $eventos = Evento::where('estado', 0)->with('actividades')->get();
        return view('eventos.', ['actividades' => $eventos]);
    }

    public function show($id){
        $actividad = Actividad::find($id);
        return $actividad;
    }

    public function store(Request $request)
    {
        try {
            $actividad = new Actividad();
            $actividad->nombre = $request->nombre;
            $actividad->inicio_actividad = $request->inicio_evento;
            $actividad->fin_actividad = $request->fin_evento;
            $actividad->descripcion = $request->descripcion;
            $actividad->id_evento = $request->evento_id;
            $actividad->save();
            return response()->json(['mensaje' => 'Recurso asignado correctamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $actividad = Actividad::find($id);
            $actividad->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $actividad = new Actividad();
            $actividad->nombre = $request->nombre;
            $actividad->inicio_actividad = $request->inicio_evento;
            $actividad->fin_actividad = $request->fin_evento;
            $actividad->descripcion = $request->descripcion;
            $actividad->id_evento = $request->input('id_evento');
            $actividad->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }    

    public function crearActividad($id)
    {
        return view('actividad.formCrearActividad', ['id' => $id]);
    }
    
    public function vistaTablaActividades()
    {
        $actividades =  Evento::where('estado', 0)->with('actividades')->get();
        return view('actividad.crearActividad', ['actividades' => $actividades]);
    }
}
