<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostSubmitted extends Notification
{
    use Queueable;

    private $post;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($post)
    {
        $this->post = $post;
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
        if ($notifiable->id = $this->post->user_id) {
            return (new MailMessage)
                    ->subject('Post submission: Your post has been successfully submitted for approval')
                    ->greeting('Hello! '.$notifiable->name)
                    ->line('The following post has been successfully submitted for approval')
                    ->line("Title: ".$this->post->title)
                    ->line("Summary: ".$this->post->summary)
                    ->action('View it here', url('/admin/posts/'.$this->post->slug.'/edit'))
                    ->line('Thank you!');
        } else {
            return (new MailMessage)
                    ->subject('New Post Submission: The following post needs your approval')
                    ->greeting("Hello! ".$notifiable->name)
                    ->line('The following post needs your approval')
                    ->line("Title: ".$this->post->title)
                    ->line("Summary: ".$this->post->summary)
                    ->action('View it here', url('/admin/posts/'.$this->post->slug.'/edit'))
                    ->line('Thank you!');
        }
        
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
