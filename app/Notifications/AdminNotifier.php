<?php

namespace App\Notifications;

use App\Interfaces\NotificationSender;

class AdminNotifier
{
    protected NotificationSender $notificationSender;

    public function setNotifier(NotificationSender $notificationSender): void
    {
        $this->notificationSender = $notificationSender;
    }

    public function send(string $message): void
    {
        $this->notificationSender->sendNotification($message);
    }
}
