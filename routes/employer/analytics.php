<?php

use App\Http\Controllers\JobListing\JobListingAnalyticsController;

//////////////////////////////////////
/// Business Analytics Route
//////////////////////////////////////
Route::get('/api/job-listings-views', [JobListingAnalyticsController::class, 'getJobListingsViews'])
    ->name('api.job-listings-views')
    ->middleware('auth');