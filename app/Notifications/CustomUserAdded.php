<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomUserAdded extends Notification
{
    use Queueable;

    private $customUserDetails;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($customUserDetails)
    {
        $this->customUserDetails = $customUserDetails;
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
            ->subject(env('APP_NAME').': You have been added with some admin privileges')
            ->greeting("Hello! ".$this->customUserDetails['name'])
            ->line('You have been added as a user with special permissions.')
            ->line('Click the button to login with the following credentials')
            ->line("email: ".$this->customUserDetails['email'])
            ->line("password: ".$this->customUserDetails['plainPassword'])
            ->action('Login', url(env('APP_URL').'/login'))
            ->line('Thank you!');
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
