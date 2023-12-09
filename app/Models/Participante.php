<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participante extends Model
{
    use HasFactory;

    public function inscritos()
    {
        return $this->hasMany(Inscrito::class, 'id_participante');
    }
}
