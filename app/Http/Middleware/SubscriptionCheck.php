<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next) : Response
    {
        $user = $request->user();

        // If user is admin, allow access.
        if ($user->email === 'admin@equinehire.com') {
            return $next($request);
        }

        if (! $user) {
            return redirect('/login');
        }

        if (! $user->hasStripeId()) {
            return redirect()->route('subscription.incomplete');
        }

        if (! $user->subscriptions()->active()->count()) {
            return redirect()->route('subscription.incomplete');
        }

        return $next($request);
    }
}