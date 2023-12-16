<?php

namespace App\Http\Controllers;

use App\Models\Inscrito;
use App\Models\Participante;
use App\Models\Evento;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

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
        }])->get();
        return $participantes;
    }

    public function inscribirEvento(Request $request)
    {
        try {
            if ($request->id_participante) {
                //$participante = $this->update($request, $request->id_participante);
                $this->storeInscribir($request, $request->id_participante);
                return ['mensaje' => 'Participante inscrito correctamente.', 'error' => false];
            } else {
                $participante = $this->store($request);
                $this->storeInscribir($request, $participante->id);
                return ['mensaje' => 'Participante inscrito correctamente.', 'error' => false];
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    private function storeInscribir(Request $request, $id_participante)
    {
        $inscribir = new Inscrito();
        $inscribir->id_evento = $request->id_evento;
        $inscribir->id_participante = $id_participante;
        $inscribir->institucion = $request->institucion;
        $inscribir->grado_academico = $request->grado_academico;
        $inscribir->genero = $request->genero;
        $inscribir->talla = $request->talla;
        $inscribir->save();
    }

    private function store(Request $request)
    {
        try {
            $participante = new Participante();
            $participante->ci                = $request->ci;
            $participante->nombres           = $request->nombres;
            $participante->apellidos         = $request->apellidos;
            $participante->correo            = $request->correo;
            $participante->celular           = $request->celular;
            $participante->fecha_nacimiento  = $request->fecha_nacimiento;
            $participante->codigo            = Str::random(20);
            $participante->save();
            return $participante;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function existeParticipante(Request $request)
    {
        try {
            $participante = Participante::where('ci', $request->ci)->first();
            $inscrito = Inscrito::where('id_evento', $request->id_evento)
                ->whereHas('participante', function ($q) use ($request) {
                    $q->where('ci', $request->ci);
                })
                ->first();

            if ($inscrito) {
                return [
                    'error' => true,
                    'mensaje' => 'El participante ya se encuentra inscrito en este evento.'
                ];
            } else {
                if (!$participante) {
                    // return view('inscripciones.participante', ['id_evento' => $request->id_evento, 'nombre' => $request->nombre]);
                } else {
                    // Devuelve información sobre el participante
                    return ['participante' => $participante, 'inscrito' => $inscrito];
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
            redirect()->route('evento.inscripcion', ['participante' => $participante, 'evento' => ['id' => $request->id_evento, 'nombre' => $request->nombre]]);
        } else {
            return ['error' => true, 'mensaje' => 'El código de participante no coincide.'];
        }
    }

    public function enviarCodigoCorreo($id_evento, $id_participante)
    {
        $participante = Participante::findorfail($id_participante);
        $evento = Evento::findorfail($id_evento);
        return $participante->codigo;
    }

    public function update(Request $request, $id)
    {
        try {
            $participante = Participante::find($id);
            $participante->ci = $request->ci;
            $participante->nombres = $request->nombres;
            $participante->apellidos = $request->apellidos;
            $participante->correo = $request->correo;
            $participante->celular = $request->celular;
            $participante->fecha_nacimiento = $request->fecha_nacimiento;
            $participante->institucion = $request->institucion;
            $participante->grado_academico = $request->grado_academico;
            $participante->genero = $request->genero;
            $participante->talla = $request->talla;
            $participante->save();
            return $participante;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }
}
