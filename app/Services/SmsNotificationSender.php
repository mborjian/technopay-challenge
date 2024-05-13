<?php

namespace App\Services;

use App\Interfaces\NotificationSender;
use App\Notifications\SmsNotification;
use Illuminate\Support\Facades\Notification;

class SmsNotificationSender implements NotificationSender
{
    public function sendNotification(string $message): void
    {
        Notification::route('log', '')->notify(new SmsNotification($message));
    }
}
