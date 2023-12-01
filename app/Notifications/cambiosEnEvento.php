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

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($evento)
    {
        $this->evento = $evento;
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
        $cambios = $this->getCambios();
        return (new MailMessage)
            ->line('Se realizaron cambios en el evento.')
            ->line('Detalles del cambio:')
            ->line($this->getCambiosDescripcion($cambios))
            ->action('Ver detalles del evento', url('/eventos/' . $this->evento->id))
            ->line('Gracias por usar nuestra aplicación!');
    }

    protected function getCambios()
    {
        return $this->evento->getCambios();
    }

    protected function getCambiosDescripcion(array $cambios)
    {
        $descripcion = " ";

        foreach ($cambios as $atributo => $value) {
            $descripcion .= ucfirst($atributo). ' cambió de '. $value['old'] . ' a ' . $value['new'] . "\n";
        }
        return $cambios;
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
