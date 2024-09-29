<?php

namespace App\Http\Controllers\JobListing;
use App\Http\Controllers\Controller;

use App\Models\JobListing;

class JobListingAnalyticsController extends Controller
{
    public function getJobListingsViews()
    {
        $jobListings = JobListing::where('user_id', auth()->id())
            ->select('title', 'views')
            ->orderBy('views', 'desc')
            ->get();

        $data = [
            'labels' => $jobListings->pluck('title')->toArray(),
            'views' => $jobListings->pluck('views')->toArray(),
        ];

        return response()->json($data);
    }
}