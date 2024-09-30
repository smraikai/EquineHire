<?php

use App\Http\Controllers\Joblisting\JobListingController;

//////////////////////////////////////
/// Business Analytics Route
//////////////////////////////////////
Route::get('/business/analytics', [JobListingController::class, 'getAnalytics'])
    ->name('business.analytics')
    ->middleware('auth');