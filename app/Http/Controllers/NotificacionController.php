<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Evento;
use App\Models\Participante;
use Illuminate\Http\Request;
use App\Notifications\NotificacionEvento;
use Illuminate\Support\Facades\Log;


class NotificacionController extends Controller
{
    public function tablaEventos()
    {
        $eventos = Evento::select(
            'id',
            'nombre',
            'updated_at',
            'id_tipo_evento'
        )
            ->with(['tipoEvento' => function ($q) {
                $q->select('id', 'nombre')
                    ->withTrashed();
            }])
            ->withCount(['inscritos as cantidad_inscritos' => function ($q) {
                $q->whereHas('participante', function ($q) {
                    $q->where('correo_confirmado', 1);
                });
            }])
            ->withCount(['equiposInscrito as cantidad_equipos' => function ($q) {
                $q->whereHas('equipos', function ($q) {
                    $q->where('correo_verificado', 1);
                });
            }])
            ->where('estado', 0)
            ->orderBy('eventos.updated_at', 'desc')
            ->get();

        return view('notificaciones.enviar', ['eventos' => $eventos]);
    }

    public function storeArchivo(Request $request)
    {
        try {
            if ($request->hasFile('archivo')) {
                $archivo = $request->file('archivo');
                $nombreArchivo = $archivo->getClientOriginalName();
                $ruta = $archivo->storeAs('public/archivo_adjunto', $nombreArchivo);
                $urlArchivo = $ruta;
                return $urlArchivo;
            } else {
                return null;
            }
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }

    public function getParticipantes($id_evento)
    {
        $participantes = Participante::whereHas('inscritos', function ($q) use ($id_evento) {
            $q->where('id_evento', $id_evento);
        })->where('correo_confirmado', 1)->get();
        return $participantes;
    }

    public function notificar(Request $request)
    {
        try {

            $adjunto = $request->hasFile('archivo') ? $this->storeArchivo($request) : null;

            $datos = [
                'asunto' => $request->asunto,
                'mensaje' => $request->mensaje,
                'adjunto' => $adjunto,
                'id_evento' => $request->id_evento,
                'nombre' => $request->nombre
            ];


            $participantes = $this->getParticipantes($request->id_evento);
            $equipos = $this->getEquipos($request->id_evento);

            foreach ($equipos as $equipo) {
                $equipo->notify(new NotificacionEvento($datos));
            }

            foreach ($participantes as $participante) {
                $participante->notify(new NotificacionEvento($datos));
            }

            return response()->json(['mensaje' => 'Notificación enviada correctamente', 'error' => false]);
        } catch (\Exception $e) {
            Log::error('Error al enviar la notificación: ' . $e->getMessage());
            return 'Error al enviar la notificación.';
        }
    }

    public function getEquipos($id_evento)
    {
        $equipos = Equipo::whereHas('equipoInscrito', function ($q) use ($id_evento) {
            $q->where('id_evento', $id_evento);
        })->where('correo_verificado', 1)->get();
        return $equipos;
    }
}
