<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Patrocinador;
use App\Models\Evento;
use Illuminate\Support\Facades\Storage;

class PatrocinadorController extends Controller
{
    public function index(){
        $patrocinadores = Patrocinador::all();
        return $patrocinadores;
    }

    public function show($id){
        $patrocinador = Patrocinador::find($id);
        return $patrocinador;
    }

    public function store(Request $request){
        try{
            $patrocinador = new Patrocinador();
            $patrocinador->nombre = $request->nombre;
            $patrocinador->ruta_logo = $this->storeImage($request);
            $patrocinador->enlace_web = $request->enlace_web;
            $patrocinador->id_evento = $request->id_evento;
            $patrocinador->save();
            return response()->json(['mensaje' => 'Asignado exitosamente', 'error' => false]);
        }catch(QueryException $e){
            return $e->getMessage();
        }
    }

    public function storeImage(Request $request){
        try{
            if ($request->hasFile('logo')) {
                $ruta = $request->file('logo')->store('public/patrocinadores');
                return Storage::url($ruta);
            }
        }catch(QueryException $e){
            return $e->getMessage();
        }
    }

    public function showPatrocinadorbyEvento($id){
        $patrocinadores = Patrocinador::where('id_evento', $id)->get();
        return $patrocinadores;
    }

    public function update(Request $request, $id){
        try{
            $patrocinador = Patrocinador::find($id);
            $patrocinador->nombre = $request->nombre;
            if($request->hasFile('logo')){
                Storage::delete($patrocinador->ruta_logo);
                $patrocinador->ruta_logo = $this->storeImage($request);
            }
            $patrocinador->enlace_web = $request->enlace_web;
            $patrocinador->id_evento = $request->id_evento;
            $patrocinador->save();
            return response()->json(['mensaje' => 'Actualizado exitosamente', 'error' => false]);
        }catch(QueryException $e){
            return $e->getMessage();
        }
    }

    public function destroy($id){
        try{
            $patrocinador = Patrocinador::find($id);
            Storage::delete($patrocinador->ruta_logo);
            $patrocinador->delete();
            return response()->json(['mensaje' => 'Eliminado exitosamente', 'error' => false]);
        }catch(QueryException $e){
            return $e->getMessage();
        }
    }

    public function vistaTablaEventos()
    {
        $patrocinadores =  Evento::with('patrocinadores')->get();
        return view('patrocinador.asignarPatrocinador', ['patrocinadores' => $patrocinadores]);
    }


}
