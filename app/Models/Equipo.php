<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    public function integrantes()
    {
        return $this->hasMany(Integrante::class, 'id_equipo');
    }

    public function equipoInscrito()
    {
        return $this->hasMany(EquipoInscrito::class, 'id_equipo');
    }
}
