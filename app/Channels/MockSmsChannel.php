<?php

namespace App\Channels;


use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class MockSmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toMockSms($notifiable);
        $adminPhone = config('app.admin_phone');

        Log::info("Sending mock SMS to: {$adminPhone} - Message: {$message}");
    }
}
