<?php

namespace App\Http\Controllers;

use App\Models\Inscrito;
use Illuminate\Http\Request;
use App\Models\Participante;
use Illuminate\Database\QueryException;
use App\Mail\ConfirmacionParticipante;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\FuncCall;

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
            if (!$this->existeParticipante($request->ci, $request->id_evento)) {
                $participante = $this->store($request);
                $inscribir = new Inscrito();
                $inscribir->id_evento = $request->id_evento;
                $inscribir->id_participante = $participante->id;
                $inscribir->save();
                Mail::to($participante->correo)->send(new ConfirmacionParticipante($participante));
                return ['mensaje' => 'Participante inscrito correctamente.', 'error' => false];
            } else {
                $participante = Participante::whereHas('Inscritos', function ($q) use ($request) {
                    $q->where('id_evento', $request->id_evento);
                })->where('ci', $request->ci)->first();
                if ($participante->correo_confirmado == 0) {
                    $participante = $this->update($request, $participante->id);
                    Mail::to($participante->correo)->send(new ConfirmacionParticipante($participante));
                    return ['mensaje' => 'Participante inscrito correctamente.', 'error' => false];
                } else {
                    return ['mensaje' => 'EL participante ya ha sido inscrito.', 'error' => true];
                }
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    private function store(Request $request)
    {
        try {
            $participante = new Participante();
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

    private function existeParticipante($ci, $id_evento)
    {
        try {
            $participante = Inscrito::where('id_evento', $id_evento)
                ->whereHas('participante', function ($q) use ($ci) {
                    $q->where('ci', $ci);
                })->first();
            if ($participante) {
                return true;
            }
            return false;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function verificarParticipante($id)
    {
        $participante = Inscrito::where('id_participante', $id)->first();
        if ($participante->confirmar_inscripcion == 0) {
            $participante->confirmar_inscripcion = 1;
            $participante->save();
            // return view ()
            return $participante;
        } else {
            // return view ()
            return "El participante ya ha sido confirmado";
        }
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
