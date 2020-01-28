<?php

namespace App\Providers;

use App\Models\Event;
use App\Models\User;
use App\Observers\UserObserver;
use App\Observers\UuidObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Event::observe(UuidObserver::class);
        Schema::defaultStringLength(191);
    }
}
