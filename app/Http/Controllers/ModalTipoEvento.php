<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ModalTipoEvento extends Controller
{
    public function get()
    {
        return view('modal');
    }

    public function procesarFormulario(Request $request)
    {
        return response()->json(['mensaje' => 'Creado exitosamente']);
    }
}

