<?php

namespace App\Http\Controllers\JobListing;
use App\Http\Controllers\Controller;

use App\Models\JobListing;
use Illuminate\Support\Facades\Log;

class JobListingAnalyticsController extends Controller
{
    public function getJobListingsViews()
    {
        try {
            $jobListings = JobListing::where('user_id', auth()->id())
                ->select('title', 'views')
                ->orderBy('views', 'desc')
                ->get();

            if ($jobListings->isEmpty()) {
                return response()->json(['message' => 'No job listings found'], 204);
            }

            $data = [
                'labels' => $jobListings->pluck('title')->toArray(),
                'views' => $jobListings->pluck('views')->toArray(),
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in getJobListingsViews: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while fetching data'], 500);
        }
    }
}