<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Afiche;
use App\Models\Evento;
use Illuminate\Support\Facades\Storage;

class AficheController extends Controller
{
    //

    public function index()
    {
        $afiches = Afiche::all();
        return $afiches;
    }

    public function showPorEventoId($id)
    {
        try {
            $afiche = Afiche::where('id_evento', $id)->get();
            return $afiche;
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function storageAfiche(Request $request)
    {
        try {
            if ($request->hasFile('afiche')) {
                $ruta = $request->file('afiche')->store('public/evento');
                return Storage::url($ruta);
            }
            return "error";
        } catch (\Throwable $th) {
            return response()->json(['error' => true]);
        }
    }

    public function asignarAfiche(Request $request)
    {
        try {
            $afiche = new Afiche();
            $afiche->ruta_afiche = $this->storageAfiche($request);
            $afiche->id_evento = $request->id_evento;
            $afiche->save();
            return response()->json(['mensaje' => 'Asignado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function eliminarAfiche($id)
    {
        try {
            $afiche = Afiche::find($id);
            $afiche->ruta_afiche = "/afiche.jpg";
            Storage::delete($afiche->ruta_afiche);
            $afiche->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $afiche = Afiche::find($id);
            $afiche->ruta_afiche = $this->storageAfiche($request);
            $afiche->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        } catch (QueryException $e) {
            return $e->getMessage();
        }
    }

    public function vistaTablaEventos()
    {
        $afiches =  Evento::with('afiches')->get();
        return view('afiche.asignarAfiche', ['afiches' => $afiches]);
    }
}
