<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

class Equipo extends Model
{
    use HasFactory, Notifiable;

    public function integrantes()
    {
        return $this->hasMany(Integrante::class, 'id_equipo');
    }

    public function equipoInscrito()
    {
        return $this->hasMany(EquipoInscrito::class, 'id_equipo');
    }

    public function notificaciones()
    {
        return $this->hasMany(DatabaseNotification::class);
    }

    public function routeNotificationForMail()
    {
        return $this->correo_general;
    }
}
