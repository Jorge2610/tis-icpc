<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscrito extends Model
{
    use HasFactory;
    
    public function evento()
    {
        return $this->belongsTo(Evento::class);
    }

    public function participante()
    {
        return $this->belongsTo(Participante::class, 'id_participante');
    }
}