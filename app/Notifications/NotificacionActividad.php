<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotificacionActividad extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public $actividad;
    public $evento;
    public $cambios;

    public function __construct($actividad, $evento, $cambios = null)
    {
        $this->actividad = $actividad;
        $this->evento = $evento;
        $this->cambios = $cambios;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('emails.notificacion.actividad', [
            'actividad' => $this->actividad,
            'cambios' => $this->cambios,
            'evento' => $this->evento,
            'notifiable' => $notifiable
        ])->subject('Notificación de evento: ' . $this->evento->nombre)
            ->action('Ver detalles del evento', url('/eventos/' . str_replace(' ', '%20', $this->evento->nombre)));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'actividad' => $this->actividad,
            'cambios' => $this->cambios,
            'evento' => $this->evento,
            'notifiable' => $notifiable
        ];
    }
}
