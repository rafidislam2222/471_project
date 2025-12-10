<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SystemNotification extends Notification
{
    use Queueable;

    public $message;
    public $url;

    public function __construct($message, $url = '#')
    {
        $this->message = $message;
        $this->url = $url;
    }

    // --- FIX IS HERE ---
    public function via($notifiable)
    {
        return ['database', 'mail']; // Now it sends BOTH!
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Notification - Property App')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line($this->message)
                    ->action('View Details', $this->url)
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->message,
            'url' => $this->url,
            'time' => now()->diffForHumans(),
        ];
    }
}