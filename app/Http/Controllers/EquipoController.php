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
use Illuminate\Support\Facades\Mail;
use App\Mail\EnviarCodigoEquipo;
use App\Mail\ConfirmacionEquipo;

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
            $inscrito->id_equipo = $id_equipo;
            $inscrito->id_evento = $request->id_evento;
            $inscrito->save();
            return $inscrito;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function addIntegrante(Request $request, $id_equipo)
    {
        try {
            if ($this->existeParticipante($request->ci, $id_equipo, $request->id_evento)) {
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

    public function existeParticipante($ci, $id_equipo, $id_evento)
    {
        $participante = Participante::where('ci', $ci)->first();

        $equipoInscrito = EquipoInscrito::where('id_evento', $id_evento)
            ->where('id_equipo', $id_equipo)
            ->whereHas('equipos', function ($q) use ($ci, $id_evento) {
                $q->whereHas('integrantes', function ($q) use ($ci, $id_evento) {
                    $q->whereHas('participantes', function ($q) use ($ci, $id_evento) {
                        $q->where('ci', $ci);
                        $q->where('id_evento', $id_evento);
                    });
                });
            })
            ->first();
        if ($equipoInscrito) {
            return [
                'error' => true,
                'inscrito' => true,
                'mensaje' => 'Participante ya inscrito'
            ];
        }
        if ($participante) {
            $integrante = Integrante::where('id_participante', $participante->id)->where('id_equipo', $id_equipo)->first();
            if ($integrante) {
                return [
                    'inscrito' => false,
                    'integrante' => true,
                    'mensaje' => 'Participante ya inscrito'
                ];
            } else {
                return [
                    'integrante' => false,
                    'inscrito' => false,
                    'participante' => $participante
                ];
            }
        } else {
            return ['error' => false];
        }
    }

    public function inscribirEquipoEvento(Request $request)
    {
        try {
            $equipo = Equipo::where('correo_verificado', 0)->find($request->id_equipo);
            if ($equipo) {
                $this->update($request, $request->id_equipo);
            }
            if ($request->id_equipo) {
                $this->storeInscribir($request, $request->id_equipo);
                $equipo = Equipo::find($request->id_equipo);
                Mail::to($equipo->correo_general)->send(new EnviarCodigoEquipo($equipo, $request->id_evento));
                return ['mensaje' => 'Equipo inscrito correctamente.', 'error' => false, 'equipo' => $equipo];
            } else {
                $equipo = $this->store($request);
                $this->storeInscribir($request, $equipo->id);
                $evento = Evento::find($request->id_evento);
                Mail::to($equipo->correo_general)->send(new EnviarCodigoEquipo($equipo, $evento));
                return ['mensaje' => 'Equipo inscrito correctamente.', 'error' => false, 'equipo' => $equipo];
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
                ->first();
            $repetido = EquipoInscrito::where('id_evento', $request->id_evento)->with('equipos')
                ->whereHas('equipos', function ($q) use ($request) {
                    $q->where('nombre', $request->nombre)
                        ->where('correo_verificado', 1);
                })->first();

            if ($equipo) {
                $inscrito = EquipoInscrito::where('id_evento', $request->id_evento)
                    ->where('id_equipo', $equipo->id)
                    ->wherehas('equipos', function ($q) use ($equipo) {
                        $q->where('nombre', $equipo->nombre)
                            ->where('correo_verificado', 1);
                    })
                    ->first();
            } else {
                $esRepetido = $repetido ? true : false;
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
                        'Mensaje' => ["mensaje" => $esRepetido ? " Equipo ya inscrito a este evento." : "", "error" => $esRepetido],
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

    public function mostrarEquipo($codigo,$id)
    {
        $equipo = Equipo::with([
            'integrantes',
            'integrantes.participante',
            'equipoInscrito'
        ])
            ->where('codigo',$codigo)
            ->first();
        $evento = Evento::find($id);
        return view('inscripciones.tablaEquipo', ['equipo' => $equipo,'evento'=>$evento]);
    }

    public function enviarCorreo($id_equipo, $id_evento)
    {
        $equipo = Equipo::findorfail($id_equipo);
        $evento = Evento::findorfail($id_evento);
        Mail::to($equipo->correo_general)->locale('es')
            ->send(new EnviarCodigoEquipo($equipo, $evento));
    }

    public function verificarCodigo(Request $request, $id)
    {
        $equipo = Equipo::findorfail($id);
        if ($equipo->codigo == $request->codigo) {
            if ($equipo->correo_verificado == 0) {
                $equipo->correo_verificado = 1;
                $equipo->save();
            }
            return ['error' => false, 'mensaje' => 'Código verificado correctamente.'];
        } else {
            return ['error' => true, 'mensaje' => 'El código de equipo no coincide.'];
        }
    }

    public function verificarCorreo($codigo, $id_evento)
    {
        $equipo = Equipo::where('codigo', $codigo)->first();
        if ($equipo->correo_verificado == 0) {
            $equipo->correo_verificado = 1;
            $equipo->save();
            return ['error' => false, 'mensaje' => 'Correo verificado correctamente.'];
        }
        return ['error' => true, 'mensaje' => 'El correo ya ha sido verificado.'];
    }
}
