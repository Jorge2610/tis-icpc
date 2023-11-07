<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patrocinador extends Model
{
    use HasFactory;

    protected $table = 'patrocinadores';

    public function evento()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }
}
