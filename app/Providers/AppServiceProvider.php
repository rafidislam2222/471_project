<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // <--- 1. ADD THIS LINE

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
        // 2. ADD THIS BLOCK
        if (env('APP_ENV') !== 'local') {
            URL::forceScheme('https');
        }
    }
}