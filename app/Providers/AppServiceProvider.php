<?php

namespace App\Providers;

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
     * This method runs after all services are registered. -)
     */
    public function boot(): void
    {
        view()->composer('layouts.navigation', \App\Http\View\Composers\FriendshipComposer::class);
    }
}
