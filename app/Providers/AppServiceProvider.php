<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\RoomObserver;
use App\Models\Room;
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
        Room::observe(RoomObserver::class);
    }
}
