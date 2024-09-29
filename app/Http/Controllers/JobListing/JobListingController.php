<?php

namespace App\Http\Controllers\JobListing;
use App\Http\Controllers\Controller;

use App\Models\JobListing;
use App\Services\SeoService;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    public function show(Request $request, $job_slug, $id, SeoService $seoService)
    {
        $job_listing = JobListing::with('employer')->findOrFail($id);

        if ($job_listing->slug !== $job_slug) {
            return redirect()->route('jobs.show', [$job_listing->slug, $job_listing->id], 301);
        }

        if (!$job_listing->is_active) {
            abort(404);
        }

        $location = $job_listing->remote_position ? null : "{$job_listing->city}, {$job_listing->state}";
        $metaTitle = $seoService->generateMetaTitle($job_listing->title, $job_listing->employer->name, $location);
        $metaDescription = $seoService->generateMetaDescription($job_listing->description);

        $isOwner = auth()->check() && auth()->user()->id === $job_listing->user_id;
        $employer = $job_listing->employer;

        return view('jobs.show', compact('job_listing', 'isOwner', 'metaTitle', 'metaDescription', 'employer'));
    }
}