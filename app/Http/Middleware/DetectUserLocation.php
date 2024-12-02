<?php

namespace App\Http\Middleware;

use Closure;
use App\Services\LocationService;

class DetectUserLocation
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function handle($request, Closure $next)
    {
        if (!session()->has('user_location') && !session()->has('location_checked')) {
            $this->locationService->detectAndSetLocation($request->ip());
            session(['location_checked' => now()]);
        }

        return $next($request);
    }
}