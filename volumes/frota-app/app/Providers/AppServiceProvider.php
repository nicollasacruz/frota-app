<?php

namespace App\Providers;

use App\Models\PaymentDriver;
use App\Observers\PaymentDriverObserver;
use Illuminate\Support\Facades\URL;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
        if ($this->app->environment('local') && env('ENV') === 'servidor') {
            URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
        PaymentDriver::observe(PaymentDriverObserver::class);
    }
}
