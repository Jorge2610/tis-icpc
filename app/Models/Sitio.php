<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sitio extends Model
{
    use HasFactory;

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
