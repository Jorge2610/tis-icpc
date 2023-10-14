<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Evento;

class EventoController extends Controller
{


    public function index()
    {
        $eventos = Evento::all();
        return $eventos;
    }

    public function store(Request $request)
    {
        try {
            $evento = new Evento();
            $evento->nombre = $request->nombre;
            $evento->descripcion = $request->descripcion;
            $evento->inicio_inscripcion = $request->inicio_inscripcion;
            $evento->fin_inscripcion = $request->fin_inscripcion;
            $evento->inicio_evento = $request->inicio_evento;
            $evento->fin_evento = $request->fin_evento;
            $evento->institucion = $request->institucion;
            $evento->region = $request->region;
            $evento->grado_academico = $request->grado_academico;
            $evento->evento_pago = $request->evento_pago;
            $evento->evento_equipos = $request->evento_equipos;
            $evento->requiere_registro = $request->requiere_registro;
            $evento->rango_edad = $request->rango_edad;
            $evento->edad_minima = $request->edad_minima;
            $evento->edad_maxima = $request->edad_maxima;
            $evento->evento_genero = $request->evento_genero;
            $evento->genero = $request->genero;
            $evento->evento_pago = $request->evento_pago;
            $evento->costo = $request->costo;
            $evento->ruta_afiche = $request->ruta_afiche;
            $evento->id_tipo_evento = $request->id_tipo_evento;
            $evento->save();
            return response()->json(['mensaje' => 'Creado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['mensaje' => 'El evento ya existe', 'error' => true]);
            } else {
                if ($e->errorInfo[1] == 1406) {
                    return response()->json(['mensaje' => 'Campo demasiado grande', 'error' => true]);
                } else {
                    return $e->getMessage();
                }
            }
        }
    }

    public function storageAfiche(Request $request)
    {
        try {
            $ruta = $request->file('ruta_afiche')->store('evento');
            return $ruta;
        } catch (\Throwable $th) {
            return response()->json(['error' => true]);
        }
    }

    public function asignarAfiche($id){
        try {
            $evento = Evento::find($id);
            $ruta = $evento->storageAfiche();
            $evento->ruta_afiche = $ruta;
            $evento->save();
            return response()->json(['mensaje' => 'Subido exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id){
        try {
            $evento = Evento::find($id);
            $evento->nombre = $request->nombre;
            $evento->descripcion = $request->descripcion;
            $evento->inicio_inscripcion = $request->inicio_inscripcion;
            $evento->fin_inscripcion = $request->fin_inscripcion;
            $evento->inicio_evento = $request->inicio_evento;
            $evento->fin_evento = $request->fin_evento;
            $evento->institucion = $request->institucion;
            $evento->region = $request->region;
            $evento->grado_academico = $request->grado_academico;
            $evento->evento_pago = $request->evento_pago;
            $evento->evento_equipos = $request->evento_equipos;
            $evento->requiere_registro = $request->requiere_registro;
            $evento->rango_edad = $request->rango_edad;
            $evento->edad_minima = $request->edad_minima;
            $evento->edad_maxima = $request->edad_maxima;
            $evento->evento_genero = $request->evento_genero;
            $evento->genero = $request->genero;
            $evento->evento_pago = $request->evento_pago;
            $evento->costo = $request->costo;
            $evento->ruta_afiche = $request->ruta_afiche;
            $evento->id_tipo_evento = $request->id_tipo_evento;
            $evento->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['mensaje' => 'El evento ya existe', 'error' => true]);
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
            $evento = Evento::find($id);
            $evento->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function show($id){
        $evento = Evento::find($id);
        return $evento;
    }
}
