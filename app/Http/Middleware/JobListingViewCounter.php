<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\JobListing;
use App\Models\PageView;
use Illuminate\Support\Facades\Auth;

class JobListingViewCounter
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

    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($request->route()->getName() === 'jobs.show') {
            $jobListingId = $request->route('id');
            $jobListing = JobListing::find($jobListingId);

            if (
                $jobListing &&
                (!Auth::check() || Auth::id() !== $jobListing->user_id) &&
                $this->isHumanUserAgent($request->header('User-Agent'))
            ) {
                $pageView = PageView::firstOrNew([
                    'job_listing_id' => $jobListing->id,
                    'date' => now()->toDateString()
                ]);
                $pageView->view_count = ($pageView->view_count ?? 0) + 1;
                $pageView->save();

                // Increment the total views on the job listing
                $jobListing->increment('views');
            }
        }
        return $response;
    }
}