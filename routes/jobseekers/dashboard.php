<?php

use App\Http\Controllers\Jobseeker\JobSeekerProfileController;

Route::resource('job-seekers', JobSeekerProfileController::class);

Route::get('/job-seekers', [JobSeekerProfileController::class, 'index'])->name('dashboard.job-seekers.index');
Route::post('/job-seekers', [JobSeekerProfileController::class, 'store'])->name('dashboard.job-seekers.store');

Route::get('/job-seekers/{jobSeeker}/edit', [JobSeekerProfileController::class, 'edit'])->name('dashboard.job-seekers.edit');
Route::put('/job-seekers/{jobSeeker}', [JobSeekerProfileController::class, 'update'])->name('dashboard.job-seekers.update');

Route::delete('/job-seekers/{jobSeeker}', [JobSeekerProfileController::class, 'destroy'])->name('job-seekers.destroy');