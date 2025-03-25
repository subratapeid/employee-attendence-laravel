<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        //Assign Super Admin Without Any Permissions
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        // Fix database migrations issue for older MySQL versions
        Schema::defaultStringLength(191);

        // Force HTTPS when using Ngrok or in production
        // if (env('APP_ENV') !== 'local') {
        //     URL::forceScheme('https');
        // }
    }
}
