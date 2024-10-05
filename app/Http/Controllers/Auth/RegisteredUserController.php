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
use Illuminate\Support\Facades\Session;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        if (Session::has('selected_plan')) {
            return $this->createEmployer();
        }
        return view('auth.register-choice');
    }

    public function createJobSeeker(): View
    {
        Session::forget('selected_plan');
        return view('auth.register', ['is_employer' => false]);
    }
    public function createEmployer(): View
    {
        return view('auth.register', ['is_employer' => true]);
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
            'is_employer' => $request->is_employer,
        ]);

        event(new Registered($user));

        Auth::login($user);

        if ($user->isJobSeeker()) {
            return redirect()->route('dashboard.job_seekers.index');
        } elseif ($user->isEmployer()) {
            if ($request->session()->has('selected_plan')) {
                $planId = $request->session()->get('selected_plan');
                return redirect()->route('subscription.checkout', ['plan' => $planId]);
            }
            return redirect()->route('subscription.plans');
        }

        return redirect()->route('dashboard');
    }

    public function clearSelectedPlan(Request $request): RedirectResponse
    {
        Session::forget('selected_plan');
        return redirect()->route('register');
    }

}
