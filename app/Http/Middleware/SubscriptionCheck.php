<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionCheck
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Bypass check for admin@equinehire.com
        if ($user->email === 'admin@equinehire.com') {
            return $next($request);
        }

        if (!$this->hasActiveSubscription($user)) {
            return redirect()->route('subscription.select');
        }

        return $next($request);
    }

    private function hasActiveSubscription($user): bool
    {
        $hasActiveSubscription = $user->subscriptions()
            ->whereIn('stripe_status', ['active'])
            ->exists();

        return $hasActiveSubscription;
    }
}