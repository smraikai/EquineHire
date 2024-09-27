<?php

// Controllers
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UploadController;

// Classes
use App\Models\JobListingCategory;
use Illuminate\Http\Request;
// Routes
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
// Middleware
use App\Http\Middleware\SubscriptionCheck;


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
// Subscriber-Only Routes
////////////////////////////////////////////////////////////////////
Route::middleware([SubscriptionCheck::class, 'auth'])->group(function () {

    //////////////////////////////////////
    // Employers
    //////////////////////////////////////
    Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard.employers.index');

    // Employer Routes
    Route::get('/employers', [EmployerController::class, 'profileIndex'])->name('employers.index');
    Route::get('/employers/create', [EmployerController::class, 'create'])->name('employers.create');
    Route::post('/employers', [EmployerController::class, 'store'])->name('employers.store');

    // More specific employer routes
    Route::get('/employers/{employer}/edit', [EmployerController::class, 'edit'])->name('employers.edit');
    Route::put('/employers/{employer}', [EmployerController::class, 'update'])->name('employers.update');
    Route::delete('/employers/{employer}', [EmployerController::class, 'destroy'])->name('employers.destroy');

    // Image Handling for Employers
    Route::post('/upload/delete', [UploadController::class, 'deleteFile'])->name('upload.delete');
    Route::post('/upload/featured-image', [UploadController::class, 'uploadFeaturedImage'])->name('upload.featured_image');
    Route::post('/upload/logo', [UploadController::class, 'uploadLogo'])->name('upload.logo');

    //////////////////////////////////////
    // Job Listings
    //////////////////////////////////////
    Route::prefix('employers/job-listings')->name('employers.job-listings.')->group(function () {
        Route::get('/', [JobListingController::class, 'employerJobListings'])->name('index');
        Route::get('/create', [JobListingController::class, 'employerCreateJobListing'])->name('create');
        Route::post('/', [JobListingController::class, 'employerStoreJobListing'])->name('store');
        Route::get('/{jobListing}/edit', [JobListingController::class, 'employerEditJobListing'])->name('edit');
        Route::put('/{jobListing}', [JobListingController::class, 'employerUpdateJobListing'])->name('update');
        Route::delete('/{jobListing}', [JobListingController::class, 'employerDestroyJobListing'])->name('destroy');
    });


    //////////////////////////////////////
    // Candidates
    //////////////////////////////////////


    //////////////////////////////////////
    /// Business Analytics Route
    //////////////////////////////////////
    Route::get('/business/analytics', [JobListingController::class, 'getAnalytics'])
        ->name('business.analytics')
        ->middleware('auth');


});

////////////////////////////////////////////////////////////////////
// Blog Pages
////////////////////////////////////////////////////////////////////
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

////////////////////////////////////////////////////////////////////
// Business & Employer (Public) Routes
////////////////////////////////////////////////////////////////////
Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/{job_slug}-{id}', [JobListingController::class, 'show'])
    ->name('jobs.show')
    ->where('job_slug', '[a-z0-9\-]+')
    ->middleware('track.pageviews');
Route::get('/employers/{employer}', [EmployerController::class, 'show'])->name('employers.show');

////////////////////////////////////////////////////////////////////
// Authentication Routes
////////////////////////////////////////////////////////////////////
require __DIR__ . '/auth.php';

////////////////////////////////////////////////////////////////////
// User Profile Routes
////////////////////////////////////////////////////////////////////
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

////////////////////////////////////////////////////////////////////
// Subscription and Billing Routes
////////////////////////////////////////////////////////////////////
Route::get('/subscription', [SubscriptionController::class, 'showPlans'])->name('subscription.plans');
Route::post('/subscription/store-plan', [SubscriptionController::class, 'storePlan'])->name('subscription.store-plan');
Route::get('/subscription/success', [SubscriptionController::class, 'handleSuccessfulSubscription'])->name('subscription.success');
Route::middleware('auth')->group(function () {
    Route::get('/subscription/select', [SubscriptionController::class, 'showSubscriptionSelection'])->name('subscription.select');
    Route::match(['get', 'post'], '/subscription/checkout', [SubscriptionController::class, 'initiateCheckout'])->name('subscription.checkout');
    Route::get('/subscription/incomplete', [SubscriptionController::class, 'handleIncompletePayment'])->name('subscription.incomplete');
    Route::get('/billing', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('dashboard.employers.index'));
    })->name('billing');
});


////////////////////////////////////////////////////////////////////
// API Routes for Searchable Categories and Disciplines
////////////////////////////////////////////////////////////////////
Route::get('/categories', function () {
    return Cache::remember('categories', 60 * 60, function () {
        return JobListingCategory::all();
    });
});

////////////////////////////////////////////////////////////////////
// Stripe
////////////////////////////////////////////////////////////////////
Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');