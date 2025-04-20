<?php

namespace App\Providers;

use App\Models\Travel;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    // protected $observers = [
    //     Travel::class => [
    //         \App\Observers\TravelObserver::class,
    //     ],
    // ];
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
        // Travel::observe(\App\Observers\TravelObserver::class);
    }
}
