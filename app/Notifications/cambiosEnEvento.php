<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class cambiosEnEvento extends Notification
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
        
        return (new MailMessage)
            ->line('Se realizaron cambios en el evento.')
            ->line('Por favor revisa el evento: ')
            ->action('Ver detalles del evento', url('/eventos/' . $this->evento->nombre))
            ->line('Gracias por usar nuestra aplicación!');
    }

    

    protected function getCambiosDescripcion(array $cambios)
    {
        $descripcion = "";
        foreach ($cambios as $atributo => $value) {
            $descripcion .= $atributo . ": " . $value . "\n";
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
