<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;


class SmsNotification extends Notification
{
    use Queueable;

    protected string $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channel.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mock_sms'];
    }


    /**
     * Get the SMS representation of the notification.
     *
     * @param mixed $notifiable
     * @return string
     */
    public function toMockSms(mixed $notifiable): string
    {
        return $this->message;
    }
}
