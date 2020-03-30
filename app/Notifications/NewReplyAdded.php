<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReplyAdded extends Notification
{
    use Queueable;
    
    public $discussion = '';

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($discussion)
    {
        $this->discussion = $discussion;
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
                    // ->grettings('Hello from Udemy Forum')
                    ->line('New reply left on a discussion you are watching.')
                    ->action('View Discussion', url('/')) //$this->discussion->slug
                    ->line('Thank you for using our application!');
    }
}
