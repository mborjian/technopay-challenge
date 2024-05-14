<?php

namespace App\Providers;

use App\Interfaces\NotificationSender;
use App\Services\MailNotificationSender;
use App\Services\SmsNotificationSender;
use App\Strategies\OrderFilter;
use App\Strategies\OrderStrategies\CustomerMobileFilter;
use App\Strategies\OrderStrategies\CustomerNationalCodeFilter;
use App\Strategies\OrderStrategies\OrderAmountRangeFilter;
use App\Strategies\OrderStrategies\OrderStatusFilter;
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

        $this->app->bind(OrderFilter::class, function ($app) {
            return new OrderFilter([
                new OrderStatusFilter(),
                new CustomerNationalCodeFilter(),
                new CustomerMobileFilter(),
                new OrderAmountRangeFilter()
            ]);
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
