<?php

namespace App\Providers;

use App\Events\SendNotification;
use App\Listeners\SendNotificationListener;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    protected $listen = [
        SendNotification::class => [SendNotificationListener::class]

    ];
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
