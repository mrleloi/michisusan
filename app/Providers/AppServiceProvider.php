<?php

namespace App\Providers;

//use App\Http\Middleware\VerifyVerionAppAuthenticateMiddleware;
//use Illuminate\Cache\RateLimiting\Limit;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\RateLimiter;
//use Illuminate\Support\Facades\Route;
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
        /*RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(120)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(10)->by($request->user()?->id ?: $request->ip());
        });*/
    }
}
