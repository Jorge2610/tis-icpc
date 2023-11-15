<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoPatrocinador extends Model
{
    use HasFactory;

    protected $table = 'evento_patrocinadores';

    public function eventos()
    {
        return $this->belongsTo(Evento::class, 'id_evento');
    }

    public function patrocinadores()
    {
        return $this->belongsTo(Patrocinador::class, 'id_patrocinador');
    }
}
