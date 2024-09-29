<?php

use App\Http\Controllers\NewsletterController;
use App\Models\JobListingCategory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;


////////////////////////////////////////////////////////////////////
// API Routes
////////////////////////////////////////////////////////////////////
Route::get('/categories', function () {
    return Cache::remember('categories', 60 * 60, function () {
        return JobListingCategory::all();
    });
});

Route::post('/subscribe', [NewsletterController::class, 'subscribe'])->name('subscribe');