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

    public function sitios()
    {
        return $this->hasMany(Sitio::class, 'id_evento');
    }

    public function eventoPatrocinador()
    {
        return $this->hasMany(EventoPatrocinador::class, 'id_evento');
    }

    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_evento');
    }

    public function inscritos()
    {
        return $this->hasMany(Inscrito::class, 'id_evento');
    }

    public function equiposInscrito()
    {
        return $this->hasMany(EquipoInscrito::class, 'id_evento');
    }
}
