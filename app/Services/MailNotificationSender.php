<?php

namespace App\Services;

use App\Interfaces\NotificationSender;
use App\Notifications\MailNotification;
use Illuminate\Support\Facades\Notification;

class MailNotificationSender implements NotificationSender
{
    public function sendNotification(string $message): void
    {
        Notification::route('mail', config('app.admin_email'))->notify(new MailNotification($message));
    }
}
