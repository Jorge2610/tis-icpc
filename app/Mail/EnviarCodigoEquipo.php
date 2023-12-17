<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarCodigoEquipo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $equipo;
    public $evento;
    public function __construct($equipo, $evento)
    {
        $this->equipo = $equipo;
        $this->evento = $evento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.equipo.codigo', [
            'equipo' => $this->equipo,
            'evento' => $this->evento
        ])->subject('Código de acceso');
    }
}
