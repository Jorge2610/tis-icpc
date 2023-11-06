<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    use HasFactory;
    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class, 'id_tipo_evento');
    }

    public function afiches()
    {
        return $this->hasMany(Afiche::class, 'id_evento');
    }

    public function patrocinadores()
    {
        return $this->hasMany(Patrocinador::class, 'id_evento');
    }

    public function recursos()
    {
        return $this->hasMany(Recurso::class, 'id_evento');
    }
}
