<?php

// Controllers
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FileDeleteController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\RegisteredUserController;
// Classes
use Illuminate\Http\Request;
// Routes
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
// Middleware
use App\Http\Middleware\SubscriptionCheck;
use App\Http\Middleware\ClearDraftsMiddleware;
// Models
use App\Models\BusinessCategory;
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
        return $request->user()->redirectToBillingPortal(route('businesses.index'));
    })->name('billing');
});

////////////////////////////////////////////////////////////////////
// Subscriber-Only Routes
////////////////////////////////////////////////////////////////////
Route::middleware([SubscriptionCheck::class, 'auth'])->group(function () {
    Route::get('/dashboard', [BusinessController::class, 'index'])->name('businesses.index');
    Route::get('/dashboard/create', [BusinessController::class, 'create'])->name('businesses.create');
    Route::get('/dashboard/{business}/edit', [BusinessController::class, 'edit'])->name('businesses.edit')->middleware(ClearDraftsMiddleware::class);
    Route::delete('/dashboard/{business}', [BusinessController::class, 'destroy'])->name('businesses.destroy');
    Route::put('/dashboard/{business}', [BusinessController::class, 'update'])->name('businesses.update');

    // Handle Image Processing
    Route::post('/upload', [FileUploadController::class, 'upload']);
    Route::get('/upload', [FileUploadController::class, 'load']);
    Route::post('/delete-logo', [FileDeleteController::class, 'deleteLogo']);
    Route::post('/delete-featured-image', [FileDeleteController::class, 'deleteFeaturedImage']);
    Route::delete('/delete-additional-photo', [FileDeleteController::class, 'deleteAdditionalPhoto']);
});

////////////////////////////////////////////////////////////////////
// Admin Routes
////////////////////////////////////////////////////////////////////
Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::put('/businesses/{business}', [AdminController::class, 'update'])->name('admin.businesses.update');
    Route::get('/businesses/{business}/edit', [AdminController::class, 'edit'])->name('admin.businesses.edit');
    Route::delete('/businesses/{business}', [AdminController::class, 'destroy'])->name('admin.businesses.destroy');
    Route::get('/users/{user}', [AdminController::class, 'showUser'])->name('admin.users.show');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');
});

////////////////////////////////////////////////////////////////////
// API Routes for Searchable Categories and Disciplines
////////////////////////////////////////////////////////////////////
Route::get('/categories', function () {
    return Cache::remember('categories', 60 * 60, function () {
        return BusinessCategory::all();
    });
});
Route::get('/disciplines', function () {
    return Cache::remember('disciplines', 60 * 60, function () {
        return BusinessDiscipline::all();
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
Route::get('/business/analytics', [BusinessController::class, 'getAnalytics'])
    ->name('business.analytics')
    ->middleware('auth');

////////////////////////////////////////////////////////////////////
// Check Processing Status for Business Updates
////////////////////////////////////////////////////////////////////
Route::get('/check-processing-status/{business}', [BusinessController::class, 'checkProcessingStatus'])->name('business.check-status');