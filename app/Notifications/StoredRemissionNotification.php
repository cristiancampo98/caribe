<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class StoredRemissionNotification extends Notification
{
    use Queueable;

    public $remission;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($remission)
    {
        $this->remission = $remission;
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
        $url = url('remission/' .$this->remission->id);
        
        return (new MailMessage)
                    ->subject('Remisión de producto')
                    ->greeting('¡Hola '. $this->remission->orderDetail->order->client->name .'!')
                    ->line('Hemos creado una remisión para tu producto ' . $this->remission->orderDetail->product->name)
                    ->action('Ver remisión', $url)
                    ->line('Gracias por preferirnos.')
                    ->salutation(Auth::user()->name);
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
