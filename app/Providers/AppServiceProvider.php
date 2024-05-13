<?php

namespace App\Providers;

use App\Interfaces\NotificationSender;
use App\Services\MailNotificationSender;
use App\Services\SmsNotificationSender;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NotificationSender::class, function ($app) {
            return [
                new MailNotificationSender(),
                new SmsNotificationSender(),
            ];
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
