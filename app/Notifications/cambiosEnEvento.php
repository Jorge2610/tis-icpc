<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CambiosEnEvento extends Notification implements ShouldQueue
{
    use Queueable;

    protected $evento;
    protected $cambios;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evento, $cambios)
    {
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
        $eventoNombreUrl = str_replace(' ', '%20', $this->evento->nombre);
        return (new MailMessage)->markdown('emails.notificacion.cambios', [
            'evento' => $this->evento,
            'notificable' => $notifiable,
        ])
            ->subject('Notificación de cambios en el evento: ' . $this->evento->nombre)
            ->greeting('Notificación de cambios')
            ->action('Ver detalles del evento', url('/eventos/' . $eventoNombreUrl));
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
            'cambios' => $this->getCambiosDescripcion($this->cambios),
            'url' => url('/eventos/' . $this->evento->nombre),
            'email' => $notifiable->email,
            'nombre' => $notifiable->name,
            'id' => $this->id,
        ];
    }
}
