<?php

namespace App\Http\Controllers\JobListing;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SEOController;
use App\Models\JobListing;
use Illuminate\Http\Request;

class JobListingController extends Controller
{
    protected $seoController;

    public function __construct(SEOController $seoController)
    {
        $this->seoController = $seoController;
    }

    public function show(Request $request, $job_slug, $id)
    {
        $job_listing = JobListing::with('employer')->findOrFail($id);

        // Set SEO metadata
        $this->seoController->setJobListingSEO($job_listing);

        if ($job_listing->slug !== $job_slug) {
            return redirect()->route('jobs.show', [$job_listing->slug, $job_listing->id], 301);
        }

        if (!$job_listing->is_active) {
            abort(404);
        }

        $isOwner = auth()->check() && auth()->user()->id === $job_listing->user_id;

        // Set SEO metadata
        $this->seoController->setJobListingSEO($job_listing);

        return view('jobs.show', compact('job_listing', 'isOwner'));
    }
}