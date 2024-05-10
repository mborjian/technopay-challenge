<?php

namespace App\Notifications;

use App\Notifications\Channels\MockSmsChannel;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ErrorNotification extends Notification
{
    use Queueable;

    private Exception $exception;

    /**
     * Create a new notification instance.
     */

    public function __construct(Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(object $notifiable): array
    {
        return ['mail', MockSmsChannel::class];
    }


    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Api Error Notification')
            ->line('An error occurred in the api.')
            ->line('Error Details: ' . $this->exception->getMessage());
    }


    /**
     * Get the SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    public function toSms(mixed $notifiable): string
    {
        return 'An error occurred: ' . $this->exception->getMessage();
    }
}
