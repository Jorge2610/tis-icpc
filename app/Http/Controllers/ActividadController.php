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
            /**Antes de guardar debemos revisar si el nombre ya existe**/
            $nombreExistente = Actividad::where('id_evento', $actividad->id_evento)
            ->where('nombre', $actividad->nombre)
            ->first();
            if ($nombreExistente) {
                return response()->json(['mensaje' => 'La actividad ya existe', 'error' => true]);
            }
            $actividad->save();
            return response()->json(['mensaje' => 'Actividad creada correctamente', 'error' => false]);
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
            /**Obtenemos la actividad con ID**/
            $actividad = Actividad::find($id);
            $actividad->nombre = $request->nombre;
            $actividad->inicio_actividad = $request->inicio_evento;
            $actividad->fin_actividad = $request->fin_evento;
            $actividad->descripcion = $request->descripcion;
            $actividad->id_evento = $request->evento_id;
            /**Antes de guardar debemos revisar si el nombre ya existe y que no sea el id del evento
             * Para eso obtenemos el id del evento al que pertenece esta actividad
             **/
            $nombreExistente = Actividad::where('id_evento', $actividad->id_evento)
            ->whereNot('id',$id)
            ->where('nombre', $actividad->nombre)
            ->first();
            if ($nombreExistente) {
                return response()->json(['mensaje' => 'La actividad ya existe', 'error' => true]);
            }
            $actividad->save();
            return response()->json(['mensaje' => 'Actualizada exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }    

    public function crearActividad($id)
    {
        $evento = Evento::where('id',$id)->first();
        return view('actividad.formCrearActividad', ['evento' => $evento]);
    }
    
    public function vistaTablaActividades()
    {
        $actividades =  Evento::where('estado', 0)->with('actividades')->get();
        return view('actividad.crearActividad', ['actividades' => $actividades]);
    }
}