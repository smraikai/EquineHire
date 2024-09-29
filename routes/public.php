<?php

use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

////////////////////////////////////////////////////////////////////
// Main Public Pages
////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    return view('home');
})->name('home');
Route::get('/our-story', function () {
    return view('our_story');
})->name('our.story');
Route::get('/privacy-policy', function () {
    return view('privacy_policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    return view('terms_of_service');
})->name('terms-of-service');


////////////////////////////////////////////////////////////////////
// Business & Employer (Public) Routes
////////////////////////////////////////////////////////////////////
Route::get('/jobs', [JobSearchController::class, 'search'])->name('jobs.index');
Route::get('/jobs/{job_slug}-{id}', [JobListingController::class, 'show'])
    ->name('jobs.show')
    ->where('job_slug', '[a-z0-9\-]+')
    ->middleware('job.view.counter');
Route::get('/employers/{employer}', [EmployerController::class, 'show'])->name('employers.show');

////////////////////////////////////////////////////////////////////
// Blog Pages
////////////////////////////////////////////////////////////////////
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');