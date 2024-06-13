<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\PaymentDriver;
use App\Policies\PaymentDriverPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        PaymentDriver::class => PaymentDriverPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
