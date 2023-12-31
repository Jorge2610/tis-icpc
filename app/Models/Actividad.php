<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    protected $table = 'actividades';
    use HasFactory;
    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
