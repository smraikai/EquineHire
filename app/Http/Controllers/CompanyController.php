<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Support\Facades\Cache;

// Illumination
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Stripe Integration for GA Tracking
use Stripe\Stripe;
use Stripe\Price;

// Analytics for Users Dashboard
use App\Models\PageView;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{
    // Functions for Business Owners
    public function index(Request $request)
    {
        $user = auth()->user();
        $company = $user->company;
        $jobListings = $company ? $company->jobListings()->latest()->take(5)->get() : collect();

        // Check if the user is a new subscriber. If so, pass off info to the DataLayer
        if ($request->query('subscription_completed')) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $subscription = $user->subscription('default');
            $price = Price::retrieve($subscription->stripe_price);
            $amount = $price->unit_amount / 100; // Convert cents to dollars

            return view('dashboard.index', compact('user', 'company', 'jobListings', 'subscription', 'amount'));
        }

        return view('dashboard.index', compact('user', 'company', 'jobListings'));
    }

    public function getLatLongFromAddress($address)
    {
        $apiKey = config('services.google.maps_api_key');
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            'address' => $address,
            'key' => $apiKey
        ]);

        $data = $response->json();

        if (!empty($data['results'])) {
            return $data['results'][0]['geometry']['location'];
        }

        return null;
    }
    ////////////////////////////////////////////////
    // Photo Uploads
    ////////////////////////////////////////////////
    public function uploadPhoto(Request $request)
    {
        $file = $request->file('photo');
        $path = $file->store('temp-photos', 'public');
        return response()->json(['path' => $path]);
    }

    public function removePhoto(Request $request)
    {
        $path = $request->getContent();
        Storage::disk('public')->delete($path);
        return response()->json(['success' => true]);
    }

    // Analytics for Page Views
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

    // Business Processing Status
    public function checkProcessingStatus(Business $business)
    {
        $completed = Cache::get("business_{$business->id}_processed", false);
        if ($completed) {
            session()->flash('success', 'Business listing updated successfully.');
            return response()->json([
                'completed' => true,
                'redirect' => route('jobs.index.show', [
                    'state_slug' => $business->state_slug,
                    'slug' => $business->slug,
                    'id' => $business->id
                ])
            ]);
        }
        return response()->json(['completed' => false]);
    }
}
