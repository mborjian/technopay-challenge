<?php

namespace App\Providers;

use App\Channels\MockSmsChannel;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected array $listen = [
        'Illuminate\Notifications\Events\NotificationSending' => [
            'App\Listeners\LogSendingNotification',
        ],
        'Illuminate\Notifications\Events\NotificationSent' => [
            'App\Listeners\LogSentNotification',
        ],
    ];


    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->extend(ChannelManager::class, function ($service) {
            $service->extend('mock_sms', function ($app) {
                return $app->make(MockSmsChannel::class);
            });

            return $service;
        });
    }
}
