<?php

use App\Http\Controllers\Jobseeker\JobSeekerController;
use App\Http\Controllers\ProfileController;

Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/job-seekers', [JobSeekerController::class, 'index'])
        ->name('job_seekers.index');

    Route::post('/job-seekers', [JobSeekerController::class, 'store'])
        ->name('job_seekers.store');
});

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

Route::resource('job-seekers', JobSeekerController::class);