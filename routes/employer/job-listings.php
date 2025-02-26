<?php

use App\Http\Controllers\JobListing\EmployerJobListingController;
use App\Http\Controllers\JobListing\JobListingBoostController;

//////////////////////////////////////
// Job Listings
//////////////////////////////////////
Route::prefix('employers/job-listings')->name('employers.job-listings.')->group(function () {
    Route::get('/', [EmployerJobListingController::class, 'index'])->name('index');
    Route::get('/create', [EmployerJobListingController::class, 'create'])->name('create');
    Route::post('/', [EmployerJobListingController::class, 'store'])->name('store');
    Route::get('/{jobListing}/edit', [EmployerJobListingController::class, 'edit'])->name('edit');
    Route::put('/{jobListing}', [EmployerJobListingController::class, 'update'])->name('update');
    Route::delete('/{jobListing}', [EmployerJobListingController::class, 'destroy'])->name('destroy');
});

// Job Boosts
Route::post('/job-listings/{jobListing}/boost', [JobListingBoostController::class, 'boost'])
    ->middleware(['auth'])
    ->name('job-listings.boost');
Route::get('/job-listing/{jobListing}/boost/success', [JobListingBoostController::class, 'handleSuccessfulBoost'])
    ->name('job-listing.boost.success');

// Archive and Restore Job Listings
Route::patch('/jobs/{jobListing}/archive', [EmployerJobListingController::class, 'archive'])->name('jobs.archive');
Route::patch('/jobs/{jobListing}/unarchive', [EmployerJobListingController::class, 'unarchive'])->name('jobs.unarchive');