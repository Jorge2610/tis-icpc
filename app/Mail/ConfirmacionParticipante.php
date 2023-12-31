<?php

namespace App\Mail;

use App\Models\Participante;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmacionParticipante extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $participante;
    protected $evento;
    public function __construct(Participante $participante, $evento)
    {
        $this->participante = $participante;
        $this->evento = $evento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.participante.confirmacion', [
            'participante' => $this->participante,
            'evento' => $this->evento
        ]);
    }
}
