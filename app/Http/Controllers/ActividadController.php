<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Actividad;
use App\Models\Evento;

class ActividadController extends Controller
{
    public function index()
    {
        $actividades = Actividad::all();
        return $actividades;
    }

    public function eventosConActividades()
    {
        $eventos = Evento::where('estado', 0)->with(['actividades', function ($q) {
            $q->withTrashed();
        }])->get();
        return view('eventos.', ['actividades' => $eventos]);
    }

    public function show($id)
    {
        $actividad = Actividad::find($id);
        return $actividad;
    }

    public function store(Request $request)
    {
        try {
            $actividad = new Actividad();
            $actividad->nombre = $request->nombre;
            $actividad->inicio_actividad = $request->inicio_evento;
            $actividad->fin_actividad = $request->fin_evento;
            $actividad->descripcion = $request->descripcion;
            $actividad->inscripcion = $request->inscripcion;
            $actividad->id_evento = $request->evento_id;
            /**Antes de guardar debemos revisar si el nombre ya existe**/
            $nombreExistente = Actividad::where('id_evento', $actividad->id_evento)
                ->where('nombre', $actividad->nombre)
                ->first();
            if ($nombreExistente) {
                return response()->json(['mensaje' => 'La actividad ya existe', 'error' => true]);
            }
            $actividad->save();
            $this->notificacionActividad($actividad);
            return response()->json(['mensaje' => 'Actividad creada exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function notificacionActividad($actividad)
    {
        $actividad->inscritos->each(function ($usuario) use ($actividad) {
            $usuario->notify(new CambiosEnEvento($actividad));
        });
    }

    protected function notificarCambios($actividad, $atributosAntiguos)
    {
        $cambios = array_diff_assoc($actividad->getOriginal(), $atributosAntiguos);
        $fecha1 = \Carbon\Carbon::parse('inicio_actividad')->setTimezone('UTC');
        $fecha2 = \Carbon\Carbon::parse($atributosAntiguos['inicio_actividad'])->setTimezone('UTC');
        $fecha3 = \Carbon\Carbon::parse('fin_actividad')->setTimezone('UTC');
        $fecha4 = \Carbon\Carbon::parse(['fin_actividad'])->setTimezone('UTC');

        if (!$fecha1->equalTo($fecha2)) {
            $cambios['inicio_actividad'] = $actividad->inicio_actividad;
        } else {
            unset($cambios['inicio_actividad']);
        }
        if (!$fecha3->equalTo($fecha4)) {
            $cambios['fin_actividad'] =  $actividad->fin_actividad;
        } else {
            unset($cambios['fin_actividad']);
        }

        $inscritos = ['email' => 'jesusgonzales0968@gmail.com'];

        if (!empty($cambios)) {
            foreach ($inscritos as $tipo => $valor) {
                // Asumo que $valor contiene la dirección de correo electrónico del usuario
                $usuario = new User(); // Reemplaza 'Usuario' con el nombre de tu modelo de usuario
                $usuario->email = $valor;
                $usuario->notify(new CambiosEnActividad($actividad, $cambios));
            }
        }
    }

    public function destroy($id)
    {
        try {
            $actividad = Actividad::find($id);
            $actividad->delete();
            return response()->json(['mensaje' => 'Eliminada exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            /**Obtenemos la actividad con ID**/
            $actividad = Actividad::find($id);
            $atributosAntiguos = $actividad->getOriginal();
            $actividad->nombre = $request->nombre;
            $actividad->inicio_actividad = $request->inicio_evento;
            $actividad->fin_actividad = $request->fin_evento;
            $actividad->descripcion = $request->descripcion;
            /**Antes de guardar debemos revisar si el nombre ya existe y que no sea el id del evento
             * Para eso obtenemos el id del evento al que pertenece esta actividad
             **/
            $nombreExistente = Actividad::where('id_evento', $actividad->id_evento)
                ->where('id', '!=', $id)
                ->where('nombre', $actividad->nombre)
                ->first();
            if ($nombreExistente) {
                return response()->json(['mensaje' => 'La actividad ya existe', 'error' => true]);
            }
            $actividad->save();
            if($request->notificacion){
                $this->notificarCambios($actividad,$atributosAntiguos);
            }
            return response()->json(['mensaje' => 'Actividad actualizada exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function crearActividad($id)
    {
        $evento = Evento::where('id', $id)->first();
        return view('actividad.formCrearActividad', ['evento' => $evento]);
    }

    public function vistaTablaActividades()
    {
        $actividades =  Evento::where('estado', 0)->with(['actividades', 'tipoEvento' => function ($q) {
            $q->withTrashed();
        }])->get();
        return view('actividad.crearActividad', ['actividades' => $actividades]);
    }

    public function listarEventos()
    {
        $eventos =  Evento::where('estado', 0)->with(['actividades', 'tipoEvento' => function ($q) {
            $q->withTrashed();
        }])->get();
        return view('actividad.eliminarActividad', ['eventos' => $eventos]);
    }

    public function obtenerActividades($eventoId)
    {
        $actividades = Actividad::where('id_evento', $eventoId)->get();
        return view('actividad.eliminarActividad', ['actividades' => $actividades]);
    }

    public function actividadPorEventoId($id)
    {
        try {
            $actividad = Actividad::where('id_evento', $id)->get();
            return $actividad;
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function listaEditar()
    {
        $eventos =  Evento::where('estado', 0)->with(['actividades', 'tipoEvento' => function ($q) {
            $q->withTrashed();
        }])->get();
        return view('actividad.listaEditarActividad', ['eventos' => $eventos]);
    }
    public function editarActividad($id)
    {
        $actividad = Actividad::find($id);
        $evento = Evento::find($actividad->id_evento);
        return view('actividad.editarActividad', ['actividad' => $actividad, 'evento' => $evento]);
    }
}
