<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Start Annual Discount Registration
        if ($request->session()->has('annual_discount')) {
            return redirect()->route('eh.checkout');
        }

        // Start: Trial Registration
        if ($request->session()->has('trial')) {
            $request->session()->forget('trial');
            return redirect()->route('trial.signup');
        }
        // End: Trial Registration

        if ($request->session()->has('selected_plan')) {
            $planId = $request->session()->get('selected_plan');
            return redirect()->route('subscription.checkout', ['plan' => $planId]);
        }

        return redirect()->route('subscription.plans');
    }

    ////////////////////////////////////////////////////////////////
    // Annual Discount
    ////////////////////////////////////////////////////////////////
    public function createWithDiscount(): View
    {
        session(['annual_discount' => true]);
        return view('auth.register');
    }
    public function handleLoggedInDiscount(Request $request)
    {
        if (!$request->user()->subscribed('default')) {
            // User is logged in but not subscribed, redirect to checkout
            session(['annual_discount' => true]);
            return redirect()->route('eh.checkout');
        } else {
            // User is already subscribed, redirect to dashboard with a message
            return redirect()->route('employer.index')
                ->with('info', 'You are already subscribed. Check your billing portal for plan changes or upgrades.');
        }
    }


}
