<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\JobListing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $jobListing = JobListing::find($request->route('id'));

            if (
                $jobListing &&
                (!Auth::check() || Auth::id() !== $jobListing->user_id) &&
                $this->isHumanUserAgent($request->header('User-Agent'))
            ) {
                $jobListing->increment('views');
            } else {
                Log::info('JobListingViewCounter: View not counted', [
                    'job_id' => $jobListing ? $jobListing->id : 'null',
                    'reason' => $this->getReasonForNotCounting($jobListing, $request),
                ]);
            }
        }

        return $response;
    }

    private function getReasonForNotCounting($jobListing, $request)
    {
        if (!$jobListing) {
            return 'Job listing not found';
        }
        if (Auth::check() && Auth::id() === $jobListing->user_id) {
            return 'User is the owner of the job listing';
        }
        if (!$this->isHumanUserAgent($request->header('User-Agent'))) {
            return 'Non-human user agent';
        }
        return 'Unknown reason';
    }
}