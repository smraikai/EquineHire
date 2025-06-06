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
use App\Models\JobSeeker;

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
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', Rules\Password::defaults()], // Removed 'confirmed'
            'account_type' => ['required', 'in:employer,jobseeker'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_employer' => $request->account_type === 'employer',
        ]);

        if (!$user->is_employer) {
            JobSeeker::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        if ($user->is_employer) {
            if ($request->session()->has('selected_plan')) {
                $planId = $request->session()->get('selected_plan');
                return redirect()->route('subscription.checkout', ['plan' => $planId]);
            }
            return redirect()->route('subscription.select');
        }

        return redirect()->route('jobs.index');
    }
}
