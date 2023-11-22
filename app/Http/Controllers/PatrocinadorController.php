<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Patrocinador;
use App\Models\Evento;
use App\Models\EventoPatrocinador;
use Illuminate\Support\Facades\Storage;

class PatrocinadorController extends Controller
{
    public function index()
    {
        $patrocinadores =  Patrocinador::all();
        return $patrocinadores;
    }

    public function showPatrocinadorbyEvento($id)
    {
        $eventos =  EventoPatrocinador::where('id_evento', $id)->orderby('id_patrocinador', 'asc')->get();
        return $eventos;
    }

    public function showEventoWhithPatrocinadores($id)
    {
        $evento = EventoPatrocinador::where('id_evento', $id)->with('patrocinadores')->get();
        return $evento;
    }

    public function store(Request $request)
    {
        try {
            $patrocinador = new Patrocinador();
            $patrocinador->nombre = $request->nombre;
            $patrocinador->ruta_imagen = $this->storeImage($request);
            $patrocinador->enlace_web = $request->enlace_web;
            $patrocinador->save();
            return response()->json(['mensaje' => 'Creado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function estaBorrado(Request $request)
    {
        try {
            $patrocinador = Patrocinador::onlyTrashed()->where('nombre', $request->nombre)->first();
            if ($patrocinador) {
                return response()->json(['id' => $patrocinador->id, 'borrado' => true]);
            } else {
                $this->store($request);
                return response()->json(['borrado' => false]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function restaurar($id)
    {
        try {
            $patrocinador = Patrocinador::onlyTrashed()->find($id);
            $patrocinador->restore();
            return response()->json(['mensaje' => 'Restaurado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function storeImage(Request $request)
    {
        try {
            if ($request->hasFile('logo')) {
                $ruta = $request->file('logo')->store('public/patrocinadores');
                return Storage::url($ruta);
            }
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $patrocinador = Patrocinador::find($id);
            $patrocinador->nombre = $request->nombre;
            if ($request->hasFile('logo')) {
                Storage::delete($patrocinador->ruta_imagen);
                $patrocinador->ruta_imagen = $this->storeImage($request);
            }
            $patrocinador->enlace_web = $request->enlace_web;
            $patrocinador->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function destroy($id)
    {
        try {
            $patrocinador = Patrocinador::find($id);
            Storage::delete($patrocinador->ruta_imagen);
            $patrocinador->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function asignarPatrocinador(Request $request)
    {
        try {
            $patrocinador = new EventoPatrocinador();
            $patrocinador->id_evento = $request->id_evento;
            $patrocinador->id_patrocinador = $request->id_patrocinador;
            $patrocinador->save();
            return response()->json(['mensaje' => 'Asignado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function quitarPatrocinador($id)
    {
        try {
            $patrocinador = EventoPatrocinador::find($id);
            $patrocinador->delete();
            return response()->json(['mensaje' => 'Quitado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function vistaCrearPatrocinador()
    {
        $patrocinadores =  Patrocinador::orderBy('created_at', 'desc')->get();
        return view('patrocinador.crearPatrocinador', ['patrocinadores' => $patrocinadores]);
    }

    public function vistaEliminarPatrocinador()
    {
        $patrocinadores = Patrocinador::with('eventoPatrocinador.eventos')->get();
        return view('patrocinador.eliminarPatrocinador', ['patrocinadores' => $patrocinadores]);
    }

    public function vistaAsignarPatrocinador()
    {
        $eventos =  Evento::where('estado', 0)->with('eventoPatrocinador.patrocinadores')->orderBy('eventos.created_at', 'desc')->get();
        $patrocinadores =  Patrocinador::all();
        return view('patrocinador.asignarPatrocinador', ['eventos' => $eventos, 'patrocinadores' => $patrocinadores]);
    }

    public function vistaQuitarPatrocinador()
    {
        $eventos =  Evento::where('estado', 0)->with('eventoPatrocinador.patrocinadores')->orderBy('eventos.created_at', 'desc')->get();
        return view('patrocinador.quitarPatrocinador', ['eventos' => $eventos]);
    }
}
