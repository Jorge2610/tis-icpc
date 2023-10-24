<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Evento;
use Illuminate\Support\Facades\Storage;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::with('tipoEvento')->get();
        return $eventos;
    }

    public function cargarEventos()
    {
        $eventos = Evento::with('tipoEvento')
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('eventos.eventos', ['eventos' => $eventos]);
    }

    public function cargarEvento(String $nombre)
    {
        $evento = Evento::where('nombre', $nombre)->first();
        if (!$evento) {
            return abort(404);
        }
        return view('eventos/evento', ['evento' => $evento]);
    }

    public function store(Request $request)
    {
        try {
            $evento = new Evento();
            $evento->nombre             = $request->nombre;
            $evento->descripcion        = $request->descripcion;
            $evento->inicio_inscripcion = $request->inicio_inscripcion;
            $evento->fin_inscripcion    = $request->fin_inscripcion;
            $evento->inicio_evento      = $request->inicio_evento;
            $evento->fin_evento         = $request->fin_evento;
            $evento->institucion        = $request->institucion;
            $evento->region             = $request->region;
            $evento->grado_academico    = $request->grado_academico;
            $evento->evento_equipos     = $request->evento_equipos;
            $evento->requiere_registro  = $request->requiere_registro;
            $evento->edad_minima        = $request->edad_minima;
            $evento->edad_maxima        = $request->edad_maxima;
            $evento->genero             = $request->genero;
            $evento->precio_inscripcion = $request->precio_inscripcion;
            $evento->id_tipo_evento     = $request->id_tipo_evento;
            $evento->save();
            return response()->json(['mensaje' => 'Creado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['mensaje' => 'El evento ya existe', 'error' => true]);
            } else {
                if ($e->errorInfo[1] == 1048) {
                    return response()->json(['mensaje' => 'No hay tipo de evento seleccionado', 'error' => true]);
                } else {
                    return $e->getMessage();
                }
            }
        }
    }

    public function storageAfiche(Request $request)
    {

        try {
            if ($request->hasFile('afiche')) {
                $ruta = $request->file('afiche')->store('public/evento');
                return Storage::url($ruta);
            }
            return "error";
        } catch (\Throwable $th) {
            return response()->json(['error' => true]);
        }
    }

    public function asignarAfiche(Request $request, $id)
    {
        try {
            $evento = Evento::find($id);
            if (!$evento) {
                return response()->json(['error' => true, 'mensaje' => 'Evento no encontrado']);
            }
            if ($request->hasFile('afiche') && $evento->ruta_afiche) {
                Storage::delete($evento->ruta_afiche);
            }
            $ruta = $this->storageAfiche($request);
            $evento->ruta_afiche = $ruta;
            $evento->save();
            return response()->json(['mensaje' => 'Asignado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function eliminarAfiche($id)
    {
        try {
            $evento = Evento::find($id);
            Storage::delete($evento->ruta_afiche);
            $evento->ruta_afiche = "/evento/afiche.jpg";
            $evento->save();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $evento = Evento::find($id);
            $evento->nombre             = $request->nombre;
            $evento->descripcion        = $request->descripcion;
            $evento->inicio_inscripcion = $request->inicio_inscripcion;
            $evento->fin_inscripcion    = $request->fin_inscripcion;
            $evento->inicio_evento      = $request->inicio_evento;
            $evento->fin_evento         = $request->fin_evento;
            $evento->institucion        = $request->institucion;
            $evento->region             = $request->region;
            $evento->grado_academico    = $request->grado_academico;
            $evento->evento_equipos     = $request->evento_equipos;
            $evento->requiere_registro  = $request->requiere_registro;
            $evento->edad_minima        = $request->edad_minima;
            $evento->edad_maxima        = $request->edad_maxima;
            $evento->genero             = $request->genero;
            $evento->precio_inscripcion = $request->precio_inscripcion;
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
            Storage::delete($evento->ruta_afiche);
            $evento->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function show($id)
    {
        $evento = Evento::find($id);
        return $evento;
    }

    public function showEventForm($id = null)
    {
        $datos = [
            'nombreDelEvento' => '',
            'descripcionDelEvento' => '',
            'inicio_inscripcion' => '',
            'fin_inscripcion' => '',
            'inicio_evento' => '',
            'fin_evento' => '',
            'institucion' => '',
            'region' => '',
            'grado_academico' => '',
            'evento_equipos' => '',
            'requiere_registro' => '',
            'edad_minima' => '',
            'edad_maxima' => '',
            'genero' => '',
            'precio_inscripcion' => '',
            'ruta_afiche' => '',
            'id_tipo_evento' => ''

        ];
        if ($id !== null) {
            $evento = $this->show($id);
            $datos = [
                'evento_id' => $evento->id,
                'nombreDelEvento' => $evento->nombre,
                'descripcionDelEvento' => $evento->descripcion,
                'inicio_inscripcion' => ($evento->inicio_inscripcion) ? date('Y-m-d', strtotime($evento->inicio_inscripcion)) : '',
                'fin_inscripcion' => ($evento->fin_inscripcion) ? date('Y-m-d', strtotime($evento->fin_inscripcion)) : '',
                'inicio_evento' => $evento->inicio_evento,
                'fin_evento' => $evento->fin_evento,
                'institucion' => $evento->institucion,
                'region' => $evento->region,
                'grado_academico' =>  $evento->grado_academico,
                'evento_equipos' => $evento->evento_equipos,
                'requiere_registro' => $evento->requiere_registro,
                'edad_minima' => $evento->edad_minima,
                'edad_maxima' => $evento->edad_maxima,
                'genero' => $evento->genero,
                'precio_inscripcion' => $evento->precio_inscripcion,
                'ruta_afiche' => $evento->ruta_afiche,
                'id_tipo_evento' => $evento->id_tipo_evento
            ];
        }
        return view('crear-evento.crearEvento', compact('datos'));
    }

   
}
