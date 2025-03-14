<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\JobListingViewCounter;
use App\Http\Middleware\CheckUserType;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(\App\Http\Middleware\RedirectMiddleware::class);
        $middleware->validateCsrfTokens(except: [
            'stripe/*',
        ]);
        $middleware->alias([
            'job.view.counter' => JobListingViewCounter::class,
            'user.type' => CheckUserType::class,
        ]);
        $middleware->append(\App\Http\Middleware\DetectUserLocation::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

