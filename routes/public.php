<?php

use App\Http\Controllers\JobListing\JobSearchController;
use App\Http\Controllers\JobListing\JobListingController;
use App\Http\Controllers\Employer\EmployerController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

////////////////////////////////////////////////////////////////////
// Main Public Pages
////////////////////////////////////////////////////////////////////
Route::get('/', function () {
    $metaTitle = 'Find Equine Services Near You';
    $metaDescription = 'Discover local boarding facilities, farriers, veterinarians, trainers, and more equine services. Connect with top professionals in your area.';

    SEOMeta::setTitle($metaTitle);
    SEOMeta::setDescription($metaDescription);
    OpenGraph::setTitle($metaTitle);
    OpenGraph::setDescription($metaDescription);
    OpenGraph::setUrl(url('/'));

    return view('home', compact('metaTitle', 'metaDescription'));
})->name('home');

Route::get('/privacy-policy', function () {
    SEOMeta::setTitle('Privacy Policy');
    SEOMeta::setDescription('Read our privacy policy');
    OpenGraph::setTitle('Privacy Policy');
    OpenGraph::setDescription('Read our privacy policy');
    OpenGraph::setUrl(url('/privacy-policy'));

    return view('privacy_policy');
})->name('privacy-policy');

Route::get('/terms-of-service', function () {
    SEOMeta::setTitle('Terms of Service');
    SEOMeta::setDescription('Read our terms of service');
    OpenGraph::setTitle('Terms of Service');
    OpenGraph::setDescription('Read our terms of service');
    OpenGraph::setUrl(url('/terms-of-service'));

    return view('terms_of_service');
})->name('terms-of-service');


////////////////////////////////////////////////////////////////////
// Job Listings & Employer (Public) Routes
////////////////////////////////////////////////////////////////////
Route::get('/jobs', [JobSearchController::class, 'index'])->name('jobs.index');
Route::get('/categories/{category:slug}', [JobSearchController::class, 'category'])->name('jobs.category');
Route::get('/jobs/{job_slug}-{id}', [JobListingController::class, 'show'])
    ->name('jobs.show')
    ->where('job_slug', '[a-z0-9\-]+')
    ->middleware('job.view.counter');
Route::get('/employers/{employer}', [EmployerController::class, 'show'])->name('employers.show');

////////////////////////////////////////////////////////////////////
// Blog Pages
////////////////////////////////////////////////////////////////////
Route::get('/blog', function () {
    $metaTitle = 'Blog';
    $metaDescription = 'Insights and advice for equestrian employers and job seekers.';

    SEOMeta::setTitle($metaTitle);
    SEOMeta::setDescription($metaDescription);
    OpenGraph::setTitle($metaTitle);
    OpenGraph::setDescription($metaDescription);
    OpenGraph::setUrl(url('/blog'));

    return app(BlogController::class)->index();
})->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');