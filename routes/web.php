<?php

use App\Http\Middleware\SubscriptionCheck;

// Employer 
Route::middleware([SubscriptionCheck::class, 'auth'])->group(function () {
    require __DIR__ . '/employer/dashboard.php';
    require __DIR__ . '/employer/uploads.php';
    require __DIR__ . '/employer/job-listings.php';
    require __DIR__ . '/employer/analytics.php';
});

// Main Routes
require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/public.php';
require __DIR__ . '/subscription.php';
require __DIR__ . '/api.php';
require __DIR__ . '/webhook.php';