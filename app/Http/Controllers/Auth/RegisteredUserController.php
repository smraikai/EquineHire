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
use App\Models\UserType;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $hasPlanSelected = session()->has('selected_plan') ||
            session()->has('annual_discount') ||
            session()->has('trial');

        return view('auth.register', compact('hasPlanSelected'));
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
            'is_employer' => ['required', 'boolean'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_employer' => $request->is_employer,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->isJobSeeker()) {
            return redirect()->route('dashboard.job_seekers.index');
        } elseif ($user->isEmployer()) {
            if ($request->session()->has('annual_discount')) {
                return redirect()->route('eh.checkout');
            }
            if ($request->session()->has('trial')) {
                $request->session()->forget('trial');
                return redirect()->route('trial.signup');
            }
            if ($request->session()->has('selected_plan')) {
                $planId = $request->session()->get('selected_plan');
                return redirect()->route('subscription.checkout', ['plan' => $planId]);
            }
            return redirect()->route('subscription.plans');
        }

        // Fallback redirect
        return redirect()->route('dashboard');
    }
}
