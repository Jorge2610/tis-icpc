<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class cambiosEnActividad extends Notification
{
    use Queueable;
    protected $actividad;
    protected $evento;
    protected $cambios;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $cambios = $this->cambios;
        return (new MailMessage)
            ->line('Se realizaron cambios en el evento.')
            ->line('Detalles del cambio:')
            ->line($this->getCambiosDescripcion($cambios))
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    

    protected function getCambiosDescripcion()
    {
        $descripcion = "";
        foreach ($this->cambios as $atributo => $value) {
            $descripcion .= ucfirst($atributo) . ' cambió de ' . $value['old'] . ' a ' . $value['new'] . "\n";
        }
        return $descripcion;
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
            //
        ];
    }
}
