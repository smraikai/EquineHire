<?php

namespace App\Http\Controllers;

// Requests
use App\Http\Requests\UpdateBusinessRequest;

use Algolia\AlgoliaSearch\SearchClient;

// Models
use App\Models\Company;
use App\Models\JobListingCategory;
use App\Models\JobListing;
use Illuminate\Support\Facades\Cache;

// Illumination
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

// Services 
use App\Services\SeoService;

// Stripe Integration for GA Tracking
use Stripe\Stripe;
use Stripe\Price;

// Analytics for Users Dashboard
use App\Models\PageView;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;


class JobListingController extends Controller
{

    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a business.');
        }

        $job_listing = JobListing::create([
            'name' => '',
            'description' => '',
            'post_status' => 'Draft',
            'user_id' => auth()->id(),
            'address' => ''
        ]);

        // Redirect to the edit page of the newly created business
        return redirect()->route('businesses.edit', $job_listing->id);
    }

    public function edit(JobListing $job_listing)
    {
        if (auth()->id() === $job_listing->user_id) {
            // Check for active subscription
            if (!auth()->user()->subscription('default') || !auth()->user()->subscription('default')->active()) {
                return redirect()->route('businesses.index')->with('error', 'You need an active subscription to edit your business listing.');
            }

            $categories = JobListingCategory::all();

            return view('businesses.edit', compact('business', 'categories', 'disciplines'));
        }

        abort(403, 'Unauthorized action.');
    }


    public function update(JobListing $job_listing, $request)
    {

        \Log::info('Auth user ID: ' . auth()->user()->id);
        \Log::info('Business user ID: ' . $job_listing->user_id);

        // Check if the user is the owner of the business
        if (auth()->user()->id !== $job_listing->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Check for active subscription
        if (!auth()->user()->subscription('default') || !auth()->user()->subscription('default')->active()) {
            return redirect()->route('businesses.index')->with('error', 'You need an active subscription to update your business listing.');
        }

        // Validate the incoming request
        $validatedData = $request->validated();

        // Update slug if 'name' or 'state' has changed
        if ($job_listing->name !== $validatedData['name']) {
            $job_listing->slug = Str::slug($validatedData['name']);
        }
        if ($job_listing->state !== $validatedData['state']) {
            $job_listing->state_slug = Str::slug($validatedData['state']);
        }

        // Update post status to 'Published'
        if ($job_listing->post_status !== 'Published') {
            $validatedData['post_status'] = 'Published';
        }

        // Only update logo and featured_image if they are provided
        if (empty($validatedData['logo'])) {
            unset($validatedData['logo']);
        }
        if (empty($validatedData['featured_image'])) {
            unset($validatedData['featured_image']);
        }

        // Handle additional photos
// Handle additional photos
        $additionalPhotoUrls = json_decode($request->input('additional_photos_urls'), true);

        if ($additionalPhotoUrls) {
            foreach ($additionalPhotoUrls as $url) {
                $job_listing->photos()->create([
                    'path' => $url
                ]);
            }
        }


        // Mass assign all validated data
        $job_listing->fill($validatedData);

        // Save the updated business details to the database
        $job_listing->save();

        // Handle categories after saving the business
        if (!empty($validatedData['categories'][0])) {
            // Split the first element (expecting a string of comma-separated integers)
            $categoryIds = explode(',', $validatedData['categories'][0]);
            $categoryIds = array_map('intval', $categoryIds);
            $categoryIds = array_filter($categoryIds);

            // Sync the categories to the business
            $job_listing->categories()->sync($categoryIds);
        } else {
            $job_listing->categories()->detach();
        }

        // Handle discipline after saving the business
        if (!empty($validatedData['disciplines'][0])) {
            // Split the first element (expecting a string of comma-separated integers)
            $disciplineIds = explode(',', $validatedData['disciplines'][0]);
            $disciplineIds = array_map('intval', $disciplineIds);
            $disciplineIds = array_filter($disciplineIds);

            // Sync the disciplines to the business
            $job_listing->disciplines()->sync($disciplineIds);
        } else {
            $job_listing->disciplines()->detach();
        }

        // Redirect to processing page
        return view('businesses.process', ['business' => $job_listing]);

        // Redirect to the updated business directory page with success message
        // return redirect()->route('businesses.index')
        //    ->with('success', 'Business listing updated successfully.');
    }

    public function destroy(JobListing $job_listing)
    {
        // Check if the authenticated user owns the business listing
        if ($job_listing->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the business listing
        $job_listing->delete();

        return redirect()->route('businesses.index')
            ->with('success', 'Business listing deleted successfully.');
    }

    // Search Directory View and Functions
    public function index(Request $request)
    {
        $validatedData = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'categories' => 'nullable|array',
        ]);

        $keyword = $request->input('keyword', '');
        $location = $request->input('location');
        $categoryIds = $request->input('categories', []);

        $query = JobListing::search($keyword);

        if ($location) {
            $locationData = $this->getLatLongFromAddress($location);
            $latitude = $locationData['lat'] ?? null;
            $longitude = $locationData['lng'] ?? null;

            if ($latitude && $longitude) {
                $query->aroundLatLng($latitude, $longitude, 80467); // Around 50 Miles
            }
        }

        if (!empty($categoryIds)) {
            $query->whereIn('category_ids', $categoryIds);
        }

        $results = $query->paginate(10);

        $facets = [
            'categories' => JobListingCategory::all(),
        ];

        return view('jobs.index', compact('results', 'facets'));
    }

    public function directoryShow(Request $request, $state, $slug, $id, SeoService $seoService)
    {
        $job_listing = Business::where('id', $id)
            ->where('state_slug', $state)
            ->with('photos') // Eager load the photos relationship
            ->firstOrFail();

        // Check if the business is a draft and the user is not the owner
        if ($job_listing->post_status === 'Draft') {
            if (!auth()->check() || auth()->id() !== $job_listing->user_id) {
                abort(404);
            }
        }

        $canonicalSlug = $job_listing->slug;
        $canonicalUrl = route('jobs.index.show', [
            'state_slug' => $state,
            'slug' => $canonicalSlug,
            'id' => $id,
        ]);

        if ($slug !== $canonicalSlug) {
            return redirect($canonicalUrl, 301);
        }

        // Generate meta title and description using SeoService
        $metaTitle = $seoService->generateMetaTitle($job_listing->name, $job_listing->city, $job_listing->state);
        $metaDescription = $seoService->generateMetaDescription($job_listing->description);

        $isOwner = auth()->check() && auth()->user()->id === $job_listing->user_id;

        return view('jobs.index-show', compact('business', 'isOwner', 'metaTitle', 'metaDescription'));
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

    // Analytics for Page Views
    public function getAnalytics(Request $request)
    {
        $user = $request->user();
        $job_listing = $user->businesses()->first();

        if (!$job_listing) {
            return response()->json([
                'labels' => [],
                'data' => [],
                'message' => 'No business found for this user'
            ]);
        }

        $pageViews = PageView::where('job_listing_id', $job_listing->id)
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
    public function checkProcessingStatus(Business $job_listing)
    {
        $completed = Cache::get("business_{$job_listing->id}_processed", false);
        if ($completed) {
            session()->flash('success', 'Business listing updated successfully.');
            return response()->json([
                'completed' => true,
                'redirect' => route('jobs.index.show', [
                    'state_slug' => $job_listing->state_slug,
                    'slug' => $job_listing->slug,
                    'id' => $job_listing->id
                ])
            ]);
        }
        return response()->json(['completed' => false]);
    }
}
