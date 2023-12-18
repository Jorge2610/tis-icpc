<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EnviarCodigoEquipoParticipante extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $participante;
    public $equipo;
    public $evento;
    public function __construct( $participante, $equipo, $evento )
    {
        $this->participante = $participante;
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
        return $this->markdown('emails.equipo.codigoParticipante',[
            'participante' => $this->participante,
            'equipo' => $this->equipo,
            'evento' => $this->evento
        ])->subject('Código de acceso');
    }
}
