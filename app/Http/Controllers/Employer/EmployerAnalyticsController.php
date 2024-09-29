<?php

namespace App\Http\Controllers\Employer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\PageView;
use Carbon\Carbon;

class EmployerAnalyticsController extends Controller
{
    public function getAnalytics(Request $request)
    {
        $user = $request->user();
        $business = $user->businesses()->first();

        if (!$business) {
            return response()->json([
                'labels' => [],
                'data' => [],
                'message' => 'No business found for this user'
            ]);
        }

        $pageViews = PageView::where('job_listing_id', $business->id)
            ->orderBy('date')
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->date)->format('W');
            });

        $labels = [];
        $data = [];

        foreach ($pageViews as $week => $views) {
            $labels[] = 'Week ' . $week;
            $data[] = $views->sum('view_count');
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }
}
