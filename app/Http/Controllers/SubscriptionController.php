<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\IncompletePayment;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function showPlans()
    {
        // Fetch subscription plans from Stripe or define them in your code
        $plans = config('subscriptions.plans.' . (app()->environment('local') ? 'local' : 'production'));
        return view('subscription.plans', compact('plans'));
    }

    public function initiateCheckout(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();
            $planId = $request->session()->get('selected_plan');

            if (!$planId) {
                return redirect()->route('subscription.plans')->with('error', 'Please select a plan first.');
            }

            try {
                $checkout = $user->newSubscription('default', $planId)
                    ->allowPromotionCodes()
                    ->checkout([
                        'success_url' => route('dashboard.index', ['subscription_completed' => true]), // True for Stripe GA4 tracking
                        'cancel_url' => route('subscription.plans'),
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

    public function storePlan(Request $request)
    {
        $request->session()->put('selected_plan', $request->input('plan'));
        if (Auth::check()) {
            return redirect()->route('subscription.checkout');
        } else {
            return redirect()->route('register');
        }
    }

    public function handleIncompletePayment(Request $request)
    {
        return view('subscription.incomplete_payment');

    }
    //////////////////////////////////////////////////////////////////
    // Trial Registration
    //////////////////////////////////////////////////////////////////
    public function trialSignup(Request $request)
    {
        if (Auth::check()) {
            return $this->initiateTrialCheckout($request);
        }

        $request->session()->put('trial', 'true');
        return redirect()->route('register');
    }

    private function initiateTrialCheckout(Request $request)
    {
        $user = $request->user();
        $planId = config('subscriptions.plans.yearly_plan_id.' . (app()->environment('local') ? 'local' : 'production'));

        $checkout = $user->newSubscription('default', $planId)
            ->trialDays(101)
            ->checkout([
                'success_url' => route('dashboard.index'),
                'cancel_url' => route('subscription.plans'),
                'subscription_data' => [
                    'trial_settings' => [
                        'end_behavior' => [
                            'missing_payment_method' => 'cancel'
                        ]
                    ]
                ],
                'payment_method_collection' => 'if_required'
            ]);

        return redirect($checkout->url);
    }

    //////////////////////////////////////////////////////////////////
    // Annual Discount Checkout
    //////////////////////////////////////////////////////////////////
    public function checkoutAnnualDiscount(Request $request)
    {
        if (Auth::check()) {
            $user = $request->user();
            $planId = config('subscriptions.plans.yearly_plan_id.' . (app()->environment('local') ? 'local' : 'production'));
            $couponId = env('EQUINEHIRE_ANNUAL_DISCOUNT_ID');

            try {
                $checkout = $user->newSubscription('default', $planId)
                    ->withCoupon($couponId)
                    ->checkout([
                        'success_url' => route('dashboard.index', ['subscription_completed' => true]),
                        'cancel_url' => route('subscription.plans'),
                    ]);

                // Forget the annual_discount session variable
                $request->session()->forget('annual_discount');

                return redirect($checkout->url);
            } catch (IncompletePayment $exception) {
                return redirect()->route('subscription.incomplete');
            }
        } else {
            return redirect()->route('login')->with('error', 'Please log in to subscribe.');
        }
    }
}
