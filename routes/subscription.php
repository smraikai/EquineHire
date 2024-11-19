<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

////////////////////////////////////////////////////////////////////
// Subscription and Billing Routes
////////////////////////////////////////////////////////////////////
Route::get('/subscription', [SubscriptionController::class, 'showPlans'])->name('subscription.plans');
Route::post('/subscription/store-plan', [SubscriptionController::class, 'storePlan'])->name('subscription.store-plan');

Route::middleware('auth')->group(function () {
    Route::get('/subscription/select', [SubscriptionController::class, 'showSubscriptionSelection'])->name('subscription.select');
    Route::match(['get', 'post'], '/subscription/checkout', [SubscriptionController::class, 'initiateCheckout'])->name('subscription.checkout');

    // Subscription Success
    Route::get('/subscription/success', [SubscriptionController::class, 'handleSuccessfulSubscription'])->name('subscription.success');
    Route::get('/subscription/thank-you', function () {
        return view('subscription.thank-you');
    })->name('subscription.thank-you');

    Route::get('/subscription/incomplete', [SubscriptionController::class, 'handleIncompletePayment'])->name('subscription.incomplete');
    Route::get('/billing', function (Request $request) {
        return $request->user()->redirectToBillingPortal(route('dashboard.employers.index'));
    })->name('billing');
});