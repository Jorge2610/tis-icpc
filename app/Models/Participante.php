<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\DatabaseNotification;

class Participante extends Model
{
    use HasFactory, Notifiable;

    public function inscritos()
    {
        return $this->hasMany(Inscrito::class, 'id_participante');
    }

    public function notificaciones()
    {
        return $this->hasMany(DatabaseNotification::class);
    }

    public function routeNotificationForMail()
    {
        return $this->correo;
    }
}
