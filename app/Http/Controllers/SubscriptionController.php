<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    ////////////////////////////////////////////
    // Views
    ////////////////////////////////////////////
    public function showPlans()
    {
        // Fetch subscription plans from Stripe or define them in your code
        $plans = config('subscriptions.plans.' . (app()->environment('local') ? 'local' : 'production'));
        return view('subscription.plans', compact('plans'));
    }

    public function showSubscriptionSelection()
    {
        // Show minimal select plan page for new employers
        $plans = config('subscriptions.plans.' . (app()->environment('local') ? 'local' : 'production'));
        return view('subscription.select-plan', compact('plans'));
    }

    ////////////////////////////////////////////
    // Checkout
    ////////////////////////////////////////////
    public function initiateCheckout(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();
            $planId = $request->session()->get('selected_plan');
            $planName = $request->session()->get('plan_name');

            $cancelUrl = $request->headers->get('referer') ?? route('subscription.plans');

            if (!$planId) {
                return redirect()->route('subscription.plans')->with('error', 'Please select a plan first.');
            }

            $checkoutBuilder = $user->newSubscription($planName, $planId)
                ->allowPromotionCodes();

            try {
                $checkout = $checkoutBuilder->checkout([
                    'success_url' => route('subscription.success', ['session_id' => '{CHECKOUT_SESSION_ID}', 'plan' => $planId]),
                    'cancel_url' => $cancelUrl,
                ]);

                $request->session()->forget('selected_plan');

                return redirect($checkout->url);
            } catch (IncompletePayment $exception) {
                return redirect()->route('subscription.incomplete');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to subscribe.');
        }
    }

    public function handleSuccessfulSubscription(Request $request)
    {
        $user = $request->user();
        $newPlanId = $request->input('plan');

        // Retrieve the new subscription
        $newSubscription = $user->subscriptions()->where('stripe_price', $newPlanId)->latest()->first();

        if (!$newSubscription) {
            Log::error('New subscription not found', [
                'user_id' => $user->id,
                'plan_id' => $newPlanId,
            ]);
            return redirect()->route('dashboard.employers.index')->with('error', 'Subscription update failed. Please contact support.');
        }

        // Cancel any other active subscriptions
        foreach ($user->subscriptions as $subscription) {
            if ($subscription->id !== $newSubscription->id && $subscription->active()) {
                try {
                    $subscription->cancelNow();
                    Log::info('Cancelled additional subscription', [
                        'user_id' => $user->id,
                        'old_subscription_id' => $subscription->id,
                        'new_subscription_id' => $newSubscription->id,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to cancel subscription', [
                        'user_id' => $user->id,
                        'subscription_id' => $subscription->id,
                        'error' => $e->getMessage(),
                    ]);
                }
            }
        }

        return redirect()->route('subscription.thank-you', ['subscription_completed' => true]);
    }

    public function handleIncompletePayment(Request $request)
    {
        return view('subscription.incomplete_payment');

    }

    ////////////////////////////////////////////
    // Helpers
    ////////////////////////////////////////////

    public function storePlan(Request $request)
    {
        // make plan name lowercase
        $planName = strtolower(str_replace(' ', '_', $request->input('planName')));

        // pull info from session
        $request->session()->put('selected_plan', $request->input('plan'));
        $request->session()->put('plan_name', $planName);

        // if user has a login, proceed to checkout, otherwise register for an account
        if (Auth::check()) {
            return redirect()->route('subscription.checkout');
        } else {
            // if coming from select-plan page, preserve the plan selection and go to register
            if ($request->input('source') === 'select-plan') {
                return redirect()->route('register');
            }
            return redirect()->route('register');
        }
    }


}
