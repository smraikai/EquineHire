<?php

use App\Http\Middleware\SubscriptionCheck;

// Employer 
Route::middleware([SubscriptionCheck::class, 'auth'])->group(function () {
    require __DIR__ . '/employers/dashboard.php';
    require __DIR__ . '/employers/job-listings.php';
    require __DIR__ . '/employers/analytics.php';
});

Route::middleware(['web', 'auth'])->group(function () {
    require __DIR__ . '/jobseekers/dashboard.php';
    require __DIR__ . '/uploads.php';
});

// Main Routes
require __DIR__ . '/auth.php';
require __DIR__ . '/profile.php';
require __DIR__ . '/public.php';
require __DIR__ . '/subscription.php';
require __DIR__ . '/api.php';
require __DIR__ . '/webhook.php';