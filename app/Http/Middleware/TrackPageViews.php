<?php

namespace App\Http\Middleware;

use App\Models\PageView;
use App\Models\Business;
use Closure;
use Illuminate\Support\Facades\Auth;

class TrackPageViews
{
    private function isHumanUserAgent($userAgent)
    {
        $humanAgents = [
            'Mozilla/',
            'Chrome/',
            'Safari/',
            'Firefox/',
            'Edge/',
            'Opera/'
        ];

        foreach ($humanAgents as $agent) {
            if (strpos($userAgent, $agent) !== false) {
                return true;
            }
        }

        return false;
    }

    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if ($request->route()->getName() === 'jobs.index.show') {
            $businessId = $request->route('id');
            $business = Business::find($businessId);

            if (
                $business &&
                (!Auth::check() || Auth::id() !== $business->user_id) &&
                $this->isHumanUserAgent($request->header('User-Agent'))
            ) {
                $pageView = PageView::firstOrNew([
                    'job_listing_id' => $business->id,
                    'date' => now()->toDateString()
                ]);
                $pageView->view_count = ($pageView->view_count ?? 0) + 1;
                $pageView->save();
            }
        }

        return $response;
    }
}
