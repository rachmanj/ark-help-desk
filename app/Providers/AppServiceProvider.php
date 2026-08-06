<?php

namespace App\Providers;

use App\Events\TicketCreated;
use App\Events\TicketEscalated;
use App\Events\TicketResolved;
use App\Listeners\SendTicketCreatedNotification;
use App\Listeners\SendTicketEscalatedNotification;
use App\Listeners\SendTicketResolvedNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            TicketCreated::class,
            SendTicketCreatedNotification::class,
        );

        Event::listen(
            TicketEscalated::class,
            SendTicketEscalatedNotification::class,
        );

        Event::listen(
            TicketResolved::class,
            SendTicketResolvedNotification::class,
        );
    }
}
