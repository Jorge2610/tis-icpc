<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Integrante extends Model
{
    use HasFactory;

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }
}
