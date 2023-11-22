<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patrocinador extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'patrocinadores';

    public function eventoPatrocinador()
    {
        return $this->hasMany(EventoPatrocinador::class, 'id_patrocinador');
    }
}
