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
    public function __construct(Participante $participante)
    {
        $this->participante = $participante;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.participante.confirmacion', [
            'participante' => $this->participante
        ]);
    }
}
