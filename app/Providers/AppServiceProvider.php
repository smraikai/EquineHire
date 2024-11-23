<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Http\ViewComposers\PlansComposer;
use App\Models\Employer;
use App\Observers\EmployerObserver;
use App\Policies\EmployerPolicy;
use Illuminate\Support\Facades\View;
use App\Services\LocationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(LocationService::class, function ($app) {
            return new LocationService();
        });
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
        View::composer('*', PlansComposer::class);

        // Additional gates or policy registrations can be added here
    }
}
