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
            \Log::warning('SubscriptionCheck: No authenticated user');
            return redirect()->route('login');
        }

        if (!$user->subscribed('default')) {
            \Log::info("User {$user->id} is not subscribed, redirecting to subscription page");
            return redirect()->route('subscription.plans');
        }

        \Log::info("User {$user->id} passed subscription check");
        return $next($request);
    }
}