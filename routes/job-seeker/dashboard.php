<?php

use App\Http\Controllers\JobSeeker\JobSeekerDashboardController;

Route::get('/dashboard/job-seeker', [JobSeekerDashboardController::class, 'index'])->name('dashboard.job-seeker.index');
Route::get('/dashboard/job-seeker/edit', [JobSeekerDashboardController::class, 'edit'])->name('job-seeker.edit');
Route::put('/dashboard/job-seeker/update', [JobSeekerDashboardController::class, 'update'])->name('job-seeker.update');
