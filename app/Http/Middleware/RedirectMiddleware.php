<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $redirects = config('redirects');
        $currentPath = '/' . ltrim($request->path(), '/');

        if (isset($redirects[$currentPath])) {
            return redirect($redirects[$currentPath], 301);
        }

        return $next($request);
    }
}