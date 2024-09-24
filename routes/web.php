<?php

// Controllers
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\LogoUploadController;
// Classes
use App\Models\JobListingCategory;
use Illuminate\Http\Request;
// Routes
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
// Middleware
use App\Http\Middleware\SubscriptionCheck;
use App\Http\Middleware\ClearDraftsMiddleware;
// Models
use App\Models\BusinessDiscipline;

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
// Annual Discount
////////////////////////////////////////////////////////////////////
Route::get('/eh-offer', function (Request $request) {
    if (Auth::check()) {
        return app(RegisteredUserController::class)->handleLoggedInDiscount($request);
    }
    return app(RegisteredUserController::class)->createWithDiscount();
})->name('eh.offer');

Route::get('/eh-checkout', [SubscriptionController::class, 'checkoutAnnualDiscount'])
    ->name('eh.checkout');

////////////////////////////////////////////////////////////////////
// Blog Pages
////////////////////////////////////////////////////////////////////
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

////////////////////////////////////////////////////////////////////
// Business Directory (Public) Routes
////////////////////////////////////////////////////////////////////
Route::get('/jobs', [JobListingController::class, 'index'])->name('jobs.index');
Route::get('/{job_slug}-{id}', [JobListingController::class, 'show'])
    ->name('jobs.show')
    ->where('job_slug', '[a-z0-9\-]+')
    ->middleware('track.pageviews');

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
Route::middleware('auth')->group(function () {
    Route::get('/subscription/select', [SubscriptionController::class, 'showSubscriptionSelection'])->name('subscription.select');
    Route::match(['get', 'post'], '/subscription/checkout', [SubscriptionController::class, 'initiateCheckout'])->name('subscription.checkout');
    Route::get('/subscription/incomplete', [SubscriptionController::class, 'handleIncompletePayment'])->name('subscription.incomplete');
    Route::get('/billing', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('dashboard.employers.index'));
    })->name('billing');
});

////////////////////////////////////////////////////////////////////
// Subscriber-Only Routes
////////////////////////////////////////////////////////////////////
Route::middleware([SubscriptionCheck::class, 'auth'])->group(function () {


    Route::get('/dashboard', [EmployerController::class, 'index'])->name('dashboard.employers.index');

    Route::get('/dashboard/create', [EmployerController::class, 'create'])->name('employer.create');
    Route::put('/employers/{employer}', [EmployerController::class, 'update'])->name('employers.update');

    Route::get('/dashboard/{business}/edit', [EmployerController::class, 'edit'])->name('employer.edit')->middleware(ClearDraftsMiddleware::class);
    Route::delete('/dashboard/{business}', [EmployerController::class, 'destroy'])->name('employer.destroy');

    Route::post('/logo/upload', [LogoUploadController::class, 'upload'])->name('logo.upload');
    Route::delete('/logo/delete', [LogoUploadController::class, 'delete'])->name('logo.delete');


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
// Trial Signup
////////////////////////////////////////////////////////////////////
Route::get('/trial', [SubscriptionController::class, 'trialSignup'])->name('trial.signup');

////////////////////////////////////////////////////////////////////
// Stripe
////////////////////////////////////////////////////////////////////
Route::post('stripe/webhook', '\Laravel\Cashier\Http\Controllers\WebhookController@handleWebhook');

////////////////////////////////////////////////////////////////////
/// Business Analytics Route
////////////////////////////////////////////////////////////////////
Route::get('/business/analytics', [JobListingController::class, 'getAnalytics'])
    ->name('business.analytics')
    ->middleware('auth');

////////////////////////////////////////////////////////////////////
// Check Processing Status for Business Updates
////////////////////////////////////////////////////////////////////
Route::get('/check-processing-status/{business}', [EmployerController::class, 'checkProcessingStatus'])->name('business.check-status');

// Job Listing Dashboard Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard/job-listings')->name('dashboard.job-listings.')->group(function () {
        Route::get('/', [JobListingController::class, 'dashboardIndex'])->name('index');
        Route::get('/create', [JobListingController::class, 'dashboardCreate'])->name('create');
        Route::post('/', [JobListingController::class, 'dashboardStore'])->name('store');
        Route::get('/{jobListing}/edit', [JobListingController::class, 'dashboardEdit'])->name('edit');
        Route::put('/{jobListing}', [JobListingController::class, 'dashboardUpdate'])->name('update');
        Route::delete('/{jobListing}', [JobListingController::class, 'dashboardDestroy'])->name('destroy');
    });
});

//////////////////////////////////////////////////////////
// Employer Routes
//////////////////////////////////////////////////////////
Route::middleware(['auth'])->group(function () {

    // Profile Index
    Route::get('/employers', [EmployerController::class, 'profileIndex'])->name('employers.index');

    // Create new employer (this will create a draft and redirect to edit)
    Route::get('/employers/create', [EmployerController::class, 'create'])->name('employers.create');

    // Store new employer
    Route::post('/employers', [EmployerController::class, 'store'])->name('employers.store');

    // Edit form
    Route::get('/employers/{employer}/edit', [EmployerController::class, 'edit'])
        ->name('employers.edit');

    // Delete Employer Profile
    Route::delete('/employers/{employer}', [EmployerController::class, 'destroy'])->name('employers.destroy');

    // Update existing employer
    Route::put('/employers/{employer}', [EmployerController::class, 'update'])->name('employers.update');

    // Photos
    Route::post('/employer/{employer}/photos', [EmployerController::class, 'addPhoto'])->name('employers.addPhoto');
    Route::delete('/employer-photos/{photo}', [EmployerController::class, 'removePhoto'])->name('employers.removePhoto');
});