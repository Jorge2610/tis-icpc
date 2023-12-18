<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionEquipo extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $equipo;
    public $evento;
    public $participante;
    public function __construct($equipo, $evento, $participante)
    {
        $this->equipo = $equipo;
        $this->evento = $evento;
        $this->participante = $participante;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.equipo.confirmacion', [
            'equipo' => $this->equipo,
            'evento' => $this->evento,
            'participante' => $this->participante
        ])->subject('Confirmación de equipo');
    }
}
