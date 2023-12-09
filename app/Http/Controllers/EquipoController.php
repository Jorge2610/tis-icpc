<?php

namespace App\Http\Controllers;


use App\Models\Equipo;
use App\Models\EquipoInscrito;
use App\Models\Integrante;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;



class EquipoController extends Controller
{
    public function index()
    {
        $equipos = Equipo::all();
        return $equipos;
    }

    public function store(Request $request)
    {
        try {
            $equipo = new Equipo();
            $equipo->nombre = $request->nombre;
            $equipo->correo_general = $request->correo_general;
            $equipo->save();
            return $equipo;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function addIntegrante(Request $request, $id_equipo, $cantidadIntegrantes)
    {
        try {
            $integrante = Integrante::where('ci', $request->ci)
                ->where('id_equipo', $id_equipo)
                ->first();
            if (!$integrante) {
                $integrante = new Integrante();
                $integrante->ci = $request->ci;
                $integrante->nombres = $request->nombres;
                $integrante->apellidos = $request->apellidos;
                $integrante->correo = $request->correo;
                $integrante->celular = $request->celular;
                $integrante->fecha_nacimiento = $request->fecha_nacimiento;
                $integrante->institucion = $request->institucion;
                $integrante->grado_academico = $request->grado_academico;
                $integrante->genero = $request->genero;
                $integrante->talla = $request->talla;
                $integrante->id_equipo = $id_equipo;
                $integrante->save();
                return ['mensaje' => 'Integrante asignado correctamente.', 'error' => false];
            } else {
                return ['mensaje' => 'El integrante ya ha sido asignado en este grupo.', 'error' => true];
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function inscribirEquipo(Request $request)
    {
        try {
            $equipo = $this->existeEquipo($request->ci, $request->id_evento);
            if (!$equipo) {
                $equipo = $this->store($request);
                $inscribir = new EquipoInscrito();
                $inscribir->id_evento = $request->id_evento;
                $inscribir->id_equipo = $equipo->id;
                $inscribir->save();
                return ['mensaje' => 'Equipo inscrito correctamente.', 'error' => false];
            } else {
                if ($equipo->correo_confirmado == 0) {
                    $equipo = $this->update($request, $equipo->id);
                    return ['mensaje' => 'Equipo inscrito correctamente.', 'error' => false];
                } else {
                    return ['mensaje' => 'El equipo ya ha sido inscrito.', 'error' => true];
                }
            }
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    private function existeEquipo($correo, $id_evento)
    {
        $equipo = EquipoInscrito::where('id_evento', $id_evento)
            ->where('correo', $correo)
            ->first();
        return $equipo;
    }

    public function update(Request $request, $id)
    {
        try {
            $equipo = Equipo::find($id);
            $equipo->nombre = $request->nombre;
            $equipo->correo_general = $request->correo_general;
            $equipo->save();
            return $equipo;
        } catch (QueryException $e) {
            return ['mensaje' => $e->getMessage(), 'error' => true];
        }
    }

    public function verificarEquipo($id, $id_evento)
    {

    }
}
