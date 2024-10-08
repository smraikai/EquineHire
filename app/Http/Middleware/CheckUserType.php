<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserType
{
    public function handle(Request $request, Closure $next, $type)
    {
        if (!auth()->check()) {
            return redirect('login');
        }

        if ($type === 'employer' && !auth()->user()->is_employer) {
            abort(403, 'Access denied. Employer account required.');
        }

        if ($type === 'jobseeker' && auth()->user()->is_employer) {
            abort(403, 'Access denied. Job seeker account required.');
        }

        return $next($request);
    }
}