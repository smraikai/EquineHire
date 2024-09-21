<?php

namespace App\Http\Controllers;

// Requests
use App\Http\Requests\UpdateBusinessRequest;

// Models
use App\Models\JobListing;

use App\Models\Business;
use App\Models\BusinessCategory;
use App\Models\BusinessDiscipline;
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


class CompanyController extends Controller
{
    // Functions for Business Owners
    public function index(Request $request)
    {
        $user = auth()->user();
        $companies = $user->companies;
        $jobListings = JobListing::where('user_id', auth()->id())->get();
        $jobListings = JobListing::where('user_id', auth()->id())->get();


        // Check if the user is a new subscriber. If so, pass off info to the DataLayer
        if ($request->query('subscription_completed')) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $subscription = $user->subscription('default');
            $price = Price::retrieve($subscription->stripe_price);
            $amount = $price->unit_amount / 100; // Convert cents to dollars

            return view('dashboard.index', compact('companies', 'subscription', 'amount'));
        }
        ;

        return view('dashboard.index', compact('jobListings'));
    }


    public function create()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must be logged in to create a business.');
        }

        $business = Business::create([
            'name' => '',
            'description' => '',
            'post_status' => 'Draft',
            'user_id' => auth()->id(),
            'address' => ''
        ]);

        // Redirect to the edit page of the newly created business
        return redirect()->route('company.edit', $business->id);
    }

    public function edit(Business $business)
    {
        if (auth()->id() === $business->user_id) {
            // Check for active subscription
            if (!auth()->user()->subscription('default') || !auth()->user()->subscription('default')->active()) {
                return redirect()->route('company.index')->with('error', 'You need an active subscription to edit your business listing.');
            }

            $categories = BusinessCategory::all();
            $disciplines = BusinessDiscipline::all();
            return view('company.edit', compact('business', 'categories', 'disciplines'));
        }

        abort(403, 'Unauthorized action.');
    }


    public function update(
        Business $business,
        UpdateBusinessRequest $request
    ) {

        \Log::info('Auth user ID: ' . auth()->user()->id);
        \Log::info('Business user ID: ' . $business->user_id);

        // Check if the user is the owner of the business
        if (auth()->user()->id !== $business->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Check for active subscription
        if (!auth()->user()->subscription('default') || !auth()->user()->subscription('default')->active()) {
            return redirect()->route('company.index')->with('error', 'You need an active subscription to update your business listing.');
        }

        // Validate the incoming request
        $validatedData = $request->validated();

        // Update slug if 'name' or 'state' has changed
        if ($business->name !== $validatedData['name']) {
            $business->slug = Str::slug($validatedData['name']);
        }
        if ($business->state !== $validatedData['state']) {
            $business->state_slug = Str::slug($validatedData['state']);
        }

        // Update post status to 'Published'
        if ($business->post_status !== 'Published') {
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
                $business->photos()->create([
                    'path' => $url
                ]);
            }
        }


        // Mass assign all validated data
        $business->fill($validatedData);

        // Save the updated business details to the database
        $business->save();

        // Handle categories after saving the business
        if (!empty($validatedData['categories'][0])) {
            // Split the first element (expecting a string of comma-separated integers)
            $categoryIds = explode(',', $validatedData['categories'][0]);
            $categoryIds = array_map('intval', $categoryIds);
            $categoryIds = array_filter($categoryIds);

            // Sync the categories to the business
            $business->categories()->sync($categoryIds);
        } else {
            $business->categories()->detach();
        }

        // Handle discipline after saving the business
        if (!empty($validatedData['disciplines'][0])) {
            // Split the first element (expecting a string of comma-separated integers)
            $disciplineIds = explode(',', $validatedData['disciplines'][0]);
            $disciplineIds = array_map('intval', $disciplineIds);
            $disciplineIds = array_filter($disciplineIds);

            // Sync the disciplines to the business
            $business->disciplines()->sync($disciplineIds);
        } else {
            $business->disciplines()->detach();
        }

        // Redirect to processing page
        return view('businesses.process', ['business' => $business]);

        // Redirect to the updated business directory page with success message
        // return redirect()->route('company.index')
        //    ->with('success', 'Business listing updated successfully.');
    }

    public function destroy(Business $business)
    {
        // Check if the authenticated user owns the business listing
        if ($business->user_id !== auth()->user()->id) {
            abort(403, 'Unauthorized action.');
        }

        // Delete the business listing
        $business->delete();

        return redirect()->route('company.index')
            ->with('success', 'Business listing deleted successfully.');
    }

    // Search Directory View and Functions
    public function directory(Request $request)
    {
        $validatedData = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'location' => 'nullable|string',
            'categories' => 'nullable|array',
            'disciplines' => 'nullable|array',
        ]);

        $keyword = $request->input('keyword', '');
        $location = $request->input('location');
        $categoryIds = $request->input('categories', []);
        $disciplineIds = $request->input('disciplines', []);

        if (empty($latitude) || empty($longitude)) {
            $locationData = $this->getLatLongFromAddress($location);
            $latitude = $locationData['lat'] ?? null;
            $longitude = $locationData['lng'] ?? null;
        }

        $query = Business::search($keyword);

        if ($latitude && $longitude) {
            $query->with([
                'aroundLatLng' => "{$latitude}, {$longitude}",
                // 'aroundRadius' => 80467, // Around 50 Miles
            ]);
        }

        if (!empty($categoryIds)) {
            $query->whereIn('category_ids', $categoryIds);
        }

        if (!empty($disciplineIds)) {
            $query->whereIn('discipline_ids', $disciplineIds);
        }

        $businesses = $query->paginate(10);

        $facets = [
            'categories' => BusinessCategory::all(),
            'disciplines' => BusinessDiscipline::all(),
        ];

        return view('jobs.index', compact('businesses', 'facets'));
    }

    public function directoryShow(Request $request, $state, $slug, $id, SeoService $seoService)
    {
        $business = Business::where('id', $id)
            ->where('state_slug', $state)
            ->with('photos') // Eager load the photos relationship
            ->firstOrFail();

        // Check if the business is a draft and the user is not the owner
        if ($business->post_status === 'Draft') {
            if (!auth()->check() || auth()->id() !== $business->user_id) {
                abort(404);
            }
        }

        $canonicalSlug = $business->slug;
        $canonicalUrl = route('jobs.index.show', [
            'state_slug' => $state,
            'slug' => $canonicalSlug,
            'id' => $id,
        ]);

        if ($slug !== $canonicalSlug) {
            return redirect($canonicalUrl, 301);
        }

        // Generate meta title and description using SeoService
        $metaTitle = $seoService->generateMetaTitle($business->name, $business->city, $business->state);
        $metaDescription = $seoService->generateMetaDescription($business->description);

        $isOwner = auth()->check() && auth()->user()->id === $business->user_id;

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
