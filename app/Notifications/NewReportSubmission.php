<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewReportSubmission extends Notification
{
    use Queueable;

    protected $trackerItem;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($trackerItem)
    {
        $this->trackerItem = $trackerItem;
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
                ->subject('New Report Submission: '.$this->trackerItem->title)
                ->greeting('Hello! '.$notifiable->name)
                ->line('There has been a new report submitted')
                ->action('View it here', url('/admin/trackerItems/'.$this->trackerItem->tracker->id.'/'.$this->trackerItem->id.'/edit'))
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
