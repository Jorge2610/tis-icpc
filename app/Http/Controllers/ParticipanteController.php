<?php

namespace App\Http\Controllers;

use App\Models\Inscrito;
use App\Models\Participante;
use App\Models\Evento;

use App\Mail\EnviarCodigo;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;


use App\Mail\ConfirmacionParticipante;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class ParticipanteController extends Controller
{

    public function index()
    {
        $participantes = Participante::all();
        return $participantes;
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

    public function inscribirEvento(Request $request)
    {
        try {
            $participante = Participante::where('correo_confirmado', 0)
                ->where('ci', $request->ci)
                ->first();
            if ($participante) {
                $participante = $this->update($request, $participante->id);
                $inscrito = Inscrito::where("id_evento", $request->id_evento)->where("id_participante", $participante->id)->first();
                if (!$inscrito) {
                    $this->storeInscribir($request, $participante->id);
                }
                $evento = Evento::find($request->id_evento);
                Mail::to($request->correo)->send(new ConfirmacionParticipante($participante, $evento));
                return ['mensaje' => 'Inscrito correctamente, por favor, verifica tu correo.', 'error' => false];
            }
            if ($request->id_participante) {
                $this->storeInscribir($request, $request->id_participante);
                return ['mensaje' => 'Inscrito correctamente.', 'error' => false];
            } else {
                $participante = $this->store($request);
                $this->storeInscribir($request, $participante->id);
                $evento = Evento::find($request->id_evento);
                Mail::to($request->correo)->send(new ConfirmacionParticipante($participante, $evento));
                return ['mensaje' => 'Inscrito correctamente, por favor, verifica tu correo.', 'error' => false];
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    private function storeInscribir(Request $request, $id_participante)
    {
        try {
            $inscribir = new Inscrito();
            $inscribir->id_evento = $request->id_evento;
            $inscribir->id_participante = $id_participante;
            $inscribir->institucion = $request->institucion;
            $inscribir->grado_academico = $request->grado_academico;
            $inscribir->genero = $request->genero;
            $inscribir->talla = $request->talla;
            $inscribir->save();
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    private function store(Request $request)
    {
        try {
            $participante = new Participante();
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

    public function existeParticipante(Request $request)
    {
        try {
            $participante = Participante::where('ci', $request->ci)->where('correo_confirmado', 1)->first();
            $inscrito = Inscrito::where('id_evento', $request->id_evento)
                ->whereHas('participante', function ($q) use ($request) {
                    $q->where('ci', $request->ci)
                        ->where('correo_confirmado', 1);
                })
                ->first();

            if ($inscrito) {
                return [
                    'error' => true,
                    'mensaje' => 'El participante ya se encuentra inscrito en este evento.'
                ];
            } else {
                if (!$participante) {
                    return [
                        'idEvento' => $request->id_evento,
                        'ci' => $request->ci,
                        'error' => false,
                    ];
                } else {
                    return [
                        'participante' => $participante,
                        'inscrito' => false
                    ];
                }
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function verificarCodigo(Request $request, $id)
    {
        $participante = Participante::findorfail($id);
        if ($participante->codigo == $request->codigo) {
            return ['error' => false, 'mensaje' => 'Código verificado correctamente.'];
        } else {
            return ['error' => true, 'mensaje' => 'El código de participante no coincide.'];
        }
    }

    public function verificarCorreo($id_evento, $codigo)
    {
        $participante = Participante::where('codigo', $codigo)->where('correo_confirmado', 0)->first();
        if ($participante) {
            $participante->correo_confirmado = 1;
            $participante->save();
            $this->borrarInscripcionesBasura($participante->id, $id_evento);
            $verificado = (object)['error' => false, 'mensaje' => 'Correo verificado correctamente.'];
        } else {
            $verificado =  (object)['error' => true, 'mensaje' => 'El correo ya ha sido verificado.'];
        }
        return view("inscripciones.confirmacionCorreo", ['verificado' => $verificado]);
    }

    public function borrarInscripcionesBasura($id_participante, $id_evento)
    {
        try {
            $inscrito = Inscrito::where('id_evento', '<>', $id_evento)
                ->where('id_participante', $id_participante)
                ->delete();
            return $inscrito;
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function enviarCodigoCorreo($id_evento, $id_participante)
    {
        try {
            $participante = Participante::findorfail($id_participante);
            $evento = Evento::findorfail($id_evento);
            Mail::to($participante->correo)->locale('es')->send(
                new EnviarCodigo($participante, $evento, null)
            );
            return ['mensaje' => 'Código enviado correctamente.', 'error' => false];
        } catch (QueryException $e) {
            Log::error($e->getMessage());
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function update(Request $request, $id)
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
}
