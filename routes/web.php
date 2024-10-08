<?php

use App\Http\Middleware\SubscriptionCheck;
use App\Http\Middleware\CheckUserType;

// Employer 
Route::middleware(['auth', 'user.type:employer', SubscriptionCheck::class])->group(function () {
    require __DIR__ . '/employer/dashboard.php';
    require __DIR__ . '/employer/uploads.php';
    require __DIR__ . '/employer/job-listings.php';
    require __DIR__ . '/employer/analytics.php';
});

// Job Seeker
Route::middleware(['auth', 'user.type:jobseeker'])->group(function () {
    require __DIR__ . '/job-seeker/dashboard.php';
});

// Main Routes
require __DIR__ . '/auth.php';
require __DIR__ . '/job-seeker/application.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/public.php';
require __DIR__ . '/subscription.php';
require __DIR__ . '/api.php';
require __DIR__ . '/webhook.php';