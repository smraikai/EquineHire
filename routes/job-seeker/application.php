<?php

use App\Http\Controllers\UploadController;
use App\Http\Controllers\JobSeeker\JobApplicationController;

Route::get('/jobs/{jobListing}/apply', [JobApplicationController::class, 'create'])->name('job-applications.create');
Route::post('/jobs/{jobListing}/apply', [JobApplicationController::class, 'store'])->name('job-applications.store');
Route::post('/upload/resume', [UploadController::class, 'uploadResume'])->name('upload.resume');
