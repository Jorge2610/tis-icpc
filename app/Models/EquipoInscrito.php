<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipoInscrito extends Model
{
    use HasFactory;

    public function equipos()
    {
        return $this->belongsTo(Equipo::class, 'id_equipo');
    }

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
