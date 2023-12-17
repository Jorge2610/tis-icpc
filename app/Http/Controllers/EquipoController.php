<?php

namespace App\Http\Controllers;


use App\Models\Equipo;
use App\Models\EquipoInscrito;
use App\Models\Integrante;
use App\Models\Participante;
use App\Models\Evento;
use Illuminate\Support\Str;
use Facade\Ignition\QueryRecorder\Query;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;



class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::all();
        return $equipos;
    }

    public function store(Request $request)
    {
        try {
            $equipo = new Equipo();
            $equipo->nombre = $request->nombre;
            $equipo->correo_general = $request->correo_general;
            $equipo->codigo = Str::random(8);
            $equipo->save();
            return $equipo;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }
    public function storeInscribir(Request $request, $id_equipo)
    {
        try {
            $inscrito = new EquipoInscrito();
            $inscrito->id_equipo = $request->id_equipo;
            $inscrito->id_participante = $request->id_equipo;
            return $inscrito;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function addIntegrante(Request $request, $id_equipo)
    {
        try {
            if ($this->existeParticipante($request->ci, $id_equipo)) {
                return ['mensaje' => 'Participante ya inscrito', 'error' => true];
            }
            $integrante = new Integrante();
            $integrante->institucion = $request->institucion;
            $integrante->grado_academico = $request->grado_academico;
            $integrante->genero = $request->genero;
            $integrante->talla = $request->talla;
            $integrante->id_participante = $request->id_participante;
            $integrante->id_equipo = $id_equipo;
            $integrante->save();
            return $integrante;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }


    public function existeParticipante($ci, $id_equipo)
    {
        $integrante = Integrante::wherehas(
            'participante',
            function ($q) use ($ci) {
                $q->where('ci', $ci);
            }
        )->where('id_equipo', $id_equipo)->first();
        return $integrante;
    }

    public function inscribirEquipoEvento(Request $request)
    {
        try {
            if ($request->id_equipo) {
                $this->storeInscribir($request, $request->id_equipo);
                return ['mensaje' => 'Equipo inscrito correctamente.', 'error' => false];
            } else {
                $equipo = $this->store($request);
                $this->storeInscribir($request, $equipo->id);
                return ['mensaje' => 'Equipo inscrito correctamente.', 'error' => false];
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function existeEquipo(Request $request)
    {
        try {
            $equipo = Equipo::where('nombre', $request->nombre)
                ->where('correo_general', $request->correo_general)
                ->where('correo_confirmado', 1)
                ->first();
            if ($equipo) {
                $inscrito = EquipoInscrito::where('id_evento', $request->id_evento)
                    ->where('id_equipo', $equipo->id)
                    ->wherehas('equipo', function ($q) use ($equipo) {
                        $q->where('nombre', $equipo->nombre)
                            ->where('correo_confirmado', 1);
                    })
                    ->first();
            } else {
                $inscrito = null;
            }
            if ($inscrito) {
                return [
                    'inscrito' => true,
                    'mensaje' => 'Equipo ya ha inscrito a este evento',
                    'equipo' => $equipo
                ];
            } else {
                if (!$equipo) {
                    return [
                        'inscrito' => false,
                    ];
                } else {
                    return [
                        'inscrito' => false,
                        'equipo' => $equipo
                    ];
                }
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $equipo = Equipo::find($id);
            $equipo->nombre = $request->nombre;
            $equipo->correo_general = $request->correo_general;
            $equipo->save();
            return $equipo;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function mostrarEquipo($id)
    {
        $equipo = Equipo::find($id)->with('integrantes', 'integrantes.participante', 'equipoInscrito')->first();
        /* $participantes = Integrante::with(['tipoEvento' => function ($query) {
            $query->withTrashed();
        }])->where('estado', 0)->orderBy('updated_at', 'desc')
            ->get();*/
        return view('inscripciones.tablaEquipo', ['equipo' => $equipo]);
    }

    public function enviarCorreo($id_equipo, $id_evento)
    {
        $equipo = Equipo::findorfail($id_equipo);
        $evento = Evento::findorfail($id_evento);
        return $equipo->codigo;
    }

    public function verificarCodigo(Request $request, $id)
    {
    }
}
