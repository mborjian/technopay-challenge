<?php

namespace App\Interfaces;

interface NotificationSender
{
    public function sendNotification(string $message): void;
}
