<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoEvento extends Model
{
    use HasFactory;
    public function eventos()
    {
        return $this->hasMany(Evento::class, 'id_tipo_evento');
    }
}
