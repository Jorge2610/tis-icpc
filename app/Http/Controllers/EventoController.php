<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Evento;

class EventoController extends Controller
{

    
    public function index()
    {
    }

    public function store(Request $request)
    {
        $evento = new Evento();
        $evento->nombre = $request->nombre;
        $evento->descripcion = $request->descripcion;
        $evento->inicio_inscripcion = $request->inicio_inscripcion;
        $evento->fin_inscripcion = $request->fin_inscripcion;
        $evento->inicio_evento = $request->inicio_evento;
        $evento->fin_evento = $request->fin_evento;
        $evento->limite_edad = $request->limite_edad;
        $evento->evento_pago = $request->evento_pago;
        $evento->competencia_general = $request->competencia_general;
        $evento->por_equipos = $request->por_equipos;
        $evento->requiere_registro = $request->requiere_registro;
        $evento->ruta_afiche = $request->ruta_afiche;
        $evento->id_tipo_evento = $request->id_tipo_evento;
        $evento->save();
        return "Guardado exitosamente";
    }
}
