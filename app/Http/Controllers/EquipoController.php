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
use App\Mail\EnviarCodigoEquipoParticipante;
use Illuminate\Support\Facades\Log;

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
            $participante = Participante::where('correo_confirmado', 0)
                ->where('ci', $request->ci)
                ->first();
            if ($participante) {
                $participante = $this->updateParticipante($request, $participante->id);
                $this->storeIntegrante($request, $id_equipo, $participante->id);
                $equipo = Equipo::find($id_equipo);
                $evento = Evento::find($request->id_evento);
                Mail::to($request->correo)->send(new ConfirmacionEquipo($equipo, $evento, $participante));
                return ['mensaje' => 'Inscrito correctamente, por favor, verifica tu correo.'];
            }
            if ($request->id_participante) {
                $this->storeIntegrante($request, $id_equipo, $request->id_participante);
                return ['mensaje' => 'Inscrito correctamente.', 'error' => false];
            } else {
                $participante = new Participante();
                $participante->ci = $request->ci;
                $participante->nombres = $request->nombres;
                $participante->apellidos = $request->apellidos;
                $participante->correo = $request->correo;
                $participante->codigo_telefono = $request->codigo_telefono;
                $participante->telefono = $request->telefono;
                $participante->fecha_nacimiento = $request->fecha_nacimiento;
                $participante->pais = $request->pais;
                $participante->codigo = Str::random(8);
                $participante->save();
                $this->storeIntegrante($request, $id_equipo, $participante->id);
                $equipo = Equipo::find($id_equipo);
                $evento = Evento::find($request->id_evento);
                Mail::to($request->correo)->send(new ConfirmacionEquipo($equipo, $evento, $participante));
                return ['mensaje' => 'Inscrito correctamente, por favor, verifica tu correo.'];
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }
    public function storeIntegrante(Request $request, $id_equipo, $id_participante)
    {
        try {
            $integrante = new Integrante();
            $integrante->institucion = $request->institucion;
            $integrante->grado_academico = $request->grado_academico;
            $integrante->genero = $request->genero;
            $integrante->talla = $request->talla;
            $integrante->id_participante = $id_participante;
            $integrante->id_equipo = $id_equipo;
            $integrante->save();
            return $integrante;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function updateParticipante(Request $request, $id)
    {
        try {
            $participante = Participante::find($id);
            $participante->ci                = $request->ci;
            $participante->nombres           = $request->nombres;
            $participante->apellidos         = $request->apellidos;
            $participante->correo            = $request->correo;
            $participante->codigo_telefono   = $request->codigo_telefono;
            $participante->telefono          = $request->telefono;
            $participante->fecha_nacimiento  = $request->fecha_nacimiento;
            $participante->pais              = $request->pais;
            $participante->codigo            = Str::random(8);
            $participante->save();
            return $participante;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }
    public function existeParticipante($ci, $id_equipo, $id_evento)
    {
        $participante = Participante::where('ci', $ci)
            ->where('correo_confirmado', 1)
            ->first();

        $equipoInscrito = EquipoInscrito::where('id_evento', $id_evento)
            ->where('id_equipo', $id_equipo)
            ->whereHas('equipos', function ($q) use ($ci, $id_evento) {
                $q->whereHas('integrantes', function ($q) use ($ci, $id_evento) {
                    $q->whereHas('participantes', function ($q) use ($ci, $id_evento) {
                        $q->where('ci', $ci);
                        $q->where('id_evento', $id_evento);
                        $q->where('correo_confirmado', 1);
                    });
                });
            })
            ->first();
        if ($equipoInscrito) {
            return [
                'error' => true,
                'inscrito' => true,
                'mensaje' => 'El participante ya se encuentra inscrito en este evento.'
            ];
        }
        if ($participante) {
            $integrante = Integrante::where('id_participante', $participante->id)->where('id_equipo', $id_equipo)->first();
            if ($integrante) {
                return [
                    'inscrito' => false,
                    'integrante' => true,
                    'mensaje' => 'Participante ya pertenece a este equipo.'
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
            $mensaje = "Equipo inscrito correctamente.";
            $equipo = Equipo::where('correo_verificado', 0)->find($request->id_equipo);

            if ($equipo) {
                $equipo = $this->update($request, $request->id_equipo);
                $equipoInscrito = EquipoInscrito::where('id_evento', $request->id_evento)
                    ->where('id_equipo', $equipo->id)
                    ->first();
                if (!$equipoInscrito) {
                    $this->storeInscribir($request, $equipo->id);
                }
                $evento = Evento::find($request->id_evento);
                Mail::to($equipo->correo_general)->send(new EnviarCodigoEquipo($equipo, $evento));
                return ['mensaje' => $mensaje, 'error' => false, 'equipo' => $equipo];
            }
            if ($request->id_equipo) {
                $this->storeInscribir($request, $request->id_equipo);
                $equipo = Equipo::find($request->id_equipo);
                $evento = Evento::find($request->id_evento);
                Mail::to($equipo->correo_general)->send(new EnviarCodigoEquipo($equipo, $evento));
                return ['mensaje' => $mensaje, 'error' => false, 'equipo' => $equipo];
            } else {
                $equipo = $this->store($request);
                $this->storeInscribir($request, $equipo->id);
                $evento = Evento::find($request->id_evento);
                Mail::to($equipo->correo_general)->send(new EnviarCodigoEquipo($equipo, $evento));
                return ['mensaje' => $mensaje, 'error' => false, 'equipo' => $equipo];
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
                    'mensaje' => ['mensaje' => 'El equipo ya ha sido inscrito a este evento', 'error' => true],
                    'equipo' => $equipo
                ];
            } else {
                if (!$equipo) {
                    return [
                        'inscrito' => false,
                        'error' => $esRepetido,
                        'Mensaje' => [
                            "mensaje" => $esRepetido ? " El nombre del equipo ya registrado a este evento." : "",
                            "error" => $esRepetido
                        ],
                    ];
                } else {
                    return [
                        'inscrito' => false,
                        'equipo' => $equipo,
                        'Mensaje' => [
                            "mensaje" => $esRepetido ? " El nombre del equipo ya registrado a este evento." : "",
                            "error" => false
                        ]
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

    public function mostrarEquipo($codigo, $id)
    {
        $equipo = Equipo::with([
            'integrantes',
            'integrantes.participantes' => function ($q) {
                $q->where('correo_confirmado', 1);
            },
            'equipoInscrito'
        ])
            ->where('codigo', $codigo)
            ->first();
        $evento = Evento::find($id);
        return view('inscripciones.tablaEquipo', ['equipo' => $equipo, 'evento' => $evento]);
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

    public function enviarCodigoCorreoParticipante($id_participante, $id_equipo, $id_evento)
    {
        try {
            $participante = Participante::find($id_participante);
            $equipo = Equipo::find($id_equipo);
            $evento = Evento::find($id_evento);
            Mail::to($participante->correo)
                ->send(new EnviarCodigoEquipoParticipante($participante, $equipo, $evento));
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }
}
