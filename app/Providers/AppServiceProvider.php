<?php

namespace App\Providers;

use GuzzleHttp\Psr7\Request;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
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
    //      RateLimiter::for('custom-api', function (Request $request) {
    //     return Limit::perMinute(60)->by($request->ip());
    // });
    }
}
