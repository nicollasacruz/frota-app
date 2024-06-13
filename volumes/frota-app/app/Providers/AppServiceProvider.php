<?php

namespace App\Providers;

use App\Models\PaymentDriver;
use App\Observers\PaymentDriverObserver;
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
        PaymentDriver::observe(PaymentDriverObserver::class);
    }
}
