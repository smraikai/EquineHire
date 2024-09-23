<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// Models
use App\Models\Employer;

// Observers
use App\Observers\EmployerObserver;

// Policies
use App\Policies\EmployerPolicy;

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
     * The model to policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Employer::class => EmployerPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        Employer::observe(EmployerObserver::class);
        $this->registerPolicies();

        // Additional gates or policy registrations can be added here
    }
}
