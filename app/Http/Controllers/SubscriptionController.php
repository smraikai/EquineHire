<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Facades\Auth;

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

            $checkoutBuilder = $user->newSubscription($planName, $planId)
                ->allowPromotionCodes();

            if (!$planId) {
                return redirect()->route('subscription.plans')->with('error', 'Please select a plan first.');
            }

            try {
                $checkout = $checkoutBuilder->checkout([
                    'success_url' => route('dashboard.employers.index', ['session_id' => '{CHECKOUT_SESSION_ID}', 'plan' => $planId, 'subscription_completed' => true]),
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
            return redirect()->route('register');
        }
    }


}
