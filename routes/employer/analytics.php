<?php

use App\Http\Controllers\JobListingController;

//////////////////////////////////////
/// Business Analytics Route
//////////////////////////////////////
Route::get('/business/analytics', [JobListingController::class, 'getAnalytics'])
    ->name('business.analytics')
    ->middleware('auth');