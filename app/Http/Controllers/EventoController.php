<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Notifications\cambiosEnEvento;
use App\Models\Evento;
use App\Models\Anulado;
use App\Models\Cancelado;
use App\Models\Participante;
use App\Models\User;
use App\Models\Inscrito;
use App\Models\Equipo;
use App\Models\EquipoInscrito;
use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Log;

class EventoController extends Controller
{
    public function index()
    {
        $eventos = Evento::where('estado', 0)->with(['tipoEvento' => function ($query) {
            $query->withTrashed();
        }, 'afiches', 'actividades'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return $eventos;
    }

    public function cargarEventos()
    {
        $eventos = Evento::where('estado', 0)->with(['tipoEvento' => function ($query) {
            $query->withTrashed();
        }, 'afiches', 'actividades'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('eventos.eventos', ['eventos' => $eventos]);
    }

    public function cargarEvento(String $nombre)
    {
        $evento = Evento::where('estado', 0)->with(['afiches', 'tipoEvento' => function ($q) {
            $q->withTrashed();
        }, 'eventoPatrocinador.patrocinadores' => function ($q) {
            $q->withTrashed();
        }, 'sitios', 'actividades'])
            ->where('nombre', $nombre)->first();

        $participantes = $this->participantesEvento($evento->id);
        if (!$evento) {
            return abort(404);
        }

        $equipos = $this->equiposEvento($evento->id);
        
        return view('eventos.evento', ['evento' => $evento, 'participantes' => $participantes, 'equipos' => $equipos]);
    }

    public function participantesEvento($id)
    {
        $participantes = Inscrito::where('id_evento', $id)->with(['participante' => function ($q) {
            $q->where('correo_confirmado', 1);
        }])->whereHas('participante', function ($q) {
            $q->where('correo_confirmado', 1);
        })->get();
        return $participantes;
    }

    public function equiposEvento($id)
    {
        $equipos = EquipoInscrito::where('id_evento', $id)->with(['equipos' => function ($q) {
            $q->where('correo_verificado',1);
        }])->whereHas('equipos', function ($q) {
            $q->where('correo_verificado',1);
        })->get();
        return $equipos;
    }

    public function vistaInscripcion($id, $ci)
    {
        $evento = Evento::where('estado', 0)->find($id);
        $participante = Participante::where("ci", $ci)
            ->where('correo_confirmado', 1)
            ->first();
        if ($participante) {
            $dato = $participante;
        } else {
            $dato = (object)[
                'ci' => $ci,
                'nombres' => null,
                'apellidos' => null,
                'correo' => null,
                'fecha_nacimiento' => null,
                'codigo_telefono' => null,
                'telefono' => null,
                'pais' => null,
                'id' => null
            ];
        }
        return view('inscripciones.participante', ['evento' => $evento, 'participante' => $dato]);
    }


    public function store(Request $request)
    {
        try {
            $evento = new Evento();
            $evento->nombre             = $request->nombre;
            $evento->descripcion        = $request->descripcion;
            $evento->inicio_evento      = $request->inicio_evento;
            $evento->fin_evento         = $request->fin_evento;
            $evento->institucion        = $request->institucion;
            $evento->region             = $request->region;
            $evento->grado_academico    = $request->grado_academico;
            $evento->equipo_minimo      = $request->equipo_minimo;
            $evento->equipo_maximo      = $request->equipo_maximo;
            $evento->talla              = $request->talla;
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



    public function update(Request $request, $id)
    {
        try {
            $evento = Evento::findOrFail($id);
            $atributosAntiguos = $evento->getOriginal();
            $evento->nombre             = $request->nombre;
            $evento->descripcion        = $request->descripcion;
            $evento->inicio_evento      = $request->inicio_evento;
            $evento->fin_evento         = $request->fin_evento;
            $evento->institucion        = $request->institucion;
            $evento->region             = $request->region;
            $evento->grado_academico    = $request->grado_academico;
            $evento->equipo_minimo      = $request->equipo_minimo;
            $evento->equipo_maximo      = $request->equipo_maximo;
            $evento->talla              = $request->talla;
            $evento->edad_minima        = $request->edad_minima;
            $evento->edad_maxima        = $request->edad_maxima;
            $evento->genero             = $request->genero;
            $evento->precio_inscripcion = $request->precio_inscripcion;
            $evento->id_tipo_evento = $request->id_tipo_evento;
            $evento->save();
            if ($request->notificacion) {
                $this->notificarCambios($evento, $atributosAntiguos);
            }
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

    protected function notificarCambios($evento, $atributosAntiguos)
    {
        $cambios = array_diff_assoc($evento->getOriginal(), $atributosAntiguos);
        $fecha1 = \Carbon\Carbon::parse($evento->inicio_evento)->setTimezone('UTC');
        $fecha2 = \Carbon\Carbon::parse($atributosAntiguos['inicio_evento'])->setTimezone('UTC');
        $fecha3 = \Carbon\Carbon::parse($evento->fin_evento)->setTimezone('UTC');
        $fecha4 = \Carbon\Carbon::parse($atributosAntiguos['fin_evento'])->setTimezone('UTC');

        if (!$fecha1->equalTo($fecha2)) {
            $cambios['inicio_evento'] = $evento->inicio_evento;
        } else {
            unset($cambios['inicio_evento']);
        }
        if (!$fecha3->equalTo($fecha4)) {
            $cambios['fin_evento'] = $evento->fin_evento;
        } else {
            unset($cambios['fin_evento']);
        }

        $participantes = Participante::whereHas('inscritos', function ($q) use ($evento) {
            $q->where('id_evento', $evento->id);
        })->get();

        if (!empty($cambios)) {
            foreach ($participantes as $usuario) {
                try {
                    $usuario->notify(new CambiosEnEvento($evento, $cambios));
                } catch (\Exception $e) {
                    Log::error('Error al enviar notificación: ' . $e->getMessage());
                    // O lanza una excepción si es necesario para interrumpir la ejecución
                    // throw new \Exception('Error al enviar notificación: ' . $e->getMessage());
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
        $evento = Evento::with(["tipoEvento" => function ($q) {
            $q->withTrashed();
        }])->find($id);
        return $evento;
    }

    public function showEventForm($id = null)
    {
        $datos = [
            'nombreDelEvento' => '',
            'descripcionDelEvento' => '',
            'inicio_evento' => '',
            'fin_evento' => '',
            'institucion' => '',
            'region' => '',
            'grado_academico' => '',
            'equipo_minimo' => '',
            'equipo_maximo' => '',
            'talla' => '',
            'edad_minima' => '',
            'edad_maxima' => '',
            'genero' => '',
            'precio_inscripcion' => '',
            'id_tipo_evento' => '',
            'nombre_tipo_evento' => ''

        ];
        if ($id !== null) {
            $evento = $this->show($id);
            $datos = [
                'evento_id'              => $evento->id,
                'nombreDelEvento'        => $evento->nombre,
                'descripcionDelEvento'   => $evento->descripcion,
                'inicio_evento'          => $evento->inicio_evento,
                'fin_evento'             => $evento->fin_evento,
                'institucion'            => $evento->institucion,
                'region'                 => $evento->region,
                'grado_academico'        => $evento->grado_academico,
                'equipo_minimo'          => $evento->equipo_minimo,
                'equipo_maximo'          => $evento->equipo_maximo,
                'talla'                  => $evento->talla,
                'edad_minima'            => $evento->edad_minima,
                'edad_maxima'            => $evento->edad_maxima,
                'genero'                 => $evento->genero,
                'precio_inscripcion'     => $evento->precio_inscripcion,
                'id_tipo_evento'         => $evento->id_tipo_evento,
                'nombre_tipo_evento'     => $evento->tipoEvento->nombre
            ];
        }
        return view('crear-evento.crearEvento', compact('datos'));
    }

    public function cancelar(Request $request, $id)
    {
        $evento = Evento::find($id);
        $evento->estado = 1;
        $evento->save();
        $cancelado = new Cancelado();
        $cancelado->motivo = $request->motivo;
        $cancelado->id_evento = $id;
        $cancelado->save();
        return response()->json(['mensaje' => 'Cancelado exitosamente', 'error' => false]);
    }

    public function anular(Request $request, $id)
    {
        $evento = Evento::find($id);
        $evento->estado = 2;
        $evento->save();
        $anulado = new Anulado();
        $anulado->motivo = $request->motivo;
        $anulado->descripcion = $request->descripcion;
        $anulado->archivos = $this->subirRespaldo($request);
        $anulado->id_evento = $id;
        $anulado->save();
        return response()->json(['mensaje' => 'Anulado exitosamente', 'error' => false]);
    }

    public function eventosValidos()
    {
        $eventos = Evento::where('estado', 0)->with(['tipoEvento' => function ($query) {
            $query->withTrashed();
        }])->get();
        $anular = false;
        return view('eventos.cancelarEvento', ['eventos' => $eventos, 'anular' => $anular]);
    }

    public function subirRespaldo(Request $request)
    {
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo')->store('/public/respaldos');
            return Storage::url($archivo);
        }
    }

    public function showEditEventForm()
    {
        $eventos = Evento::with(['tipoEvento' => function ($query) {
            $query->withTrashed();
        }])->where('estado', 0)->orderBy('updated_at', 'desc')
            ->get();
        return view('crear-evento.editarEvento', ['eventos' => $eventos]);
    }

    public function eventosValidosAnular()
    {
        $eventos = Evento::where('estado', 0)->with(['tipoEvento' => function ($query) {
            $query->withTrashed();
        }])->get();
        $anular = true;
        return view('eventos.cancelarEvento', ['eventos' => $eventos, 'anular' => $anular]);
    }
    public function vistaInscripcionEquipo($idEquipo, $ci, $idEvento)
    {
        $evento = Evento::find($idEvento);
        $equipo = Equipo::find($idEquipo);
        $participante = Participante::where("ci", $ci)->first();
        if ($participante) {
            $dato = $participante;
        } else {
            $dato = (object)[
                'ci' => $ci,
                'nombres' => null,
                'apellidos' => null,
                'correo' => null,
                'fecha_nacimiento' => null,
                'codigo_telefono' => null,
                'telefono' => null,
                'pais' => null
            ];
        }
        return view('inscripciones.participanteEquipo', ['equipo' => $equipo, 'participante' => $dato, 'evento' => $evento]);
    }
}
