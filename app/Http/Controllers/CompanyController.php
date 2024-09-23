<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Support\Facades\Cache;

// Illumination
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

// Stripe Integration for GA Tracking
use Stripe\Stripe;
use Stripe\Price;

// Analytics for Users Dashboard
use App\Models\PageView;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class CompanyController extends Controller
{

    /////////////////////////////////////////////////////////////
    // Company Dashboard
    /////////////////////////////////////////////////////////////
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



    //////////////////////////////////////////////////////////
    // Add Edit Delete Company Profile
    //////////////////////////////////////////////////////////
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'website' => 'nullable|url',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'photos.*' => 'nullable|image|max:2048',
            'photos' => 'array|max:5', // Limit to 5 photos
        ]);

        DB::beginTransaction();

        try {
            $company = new Company($validatedData);
            $company->user_id = auth()->id();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('company_logos', 'public');
                $company->logo = $path;
            }

            $company->save();

            $this->handlePhotos($request, $company);

            DB::commit();
            return redirect()->route('companies.show', $company)->with('success', 'Company profile created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while creating the company profile.');
        }
    }

    public function update(Request $request, Company $company)
    {
        $this->authorize('update', $company);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip_code' => 'required|string|max:20',
            'website' => 'nullable|url',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'logo' => 'nullable|image|max:2048',
            'photos.*' => 'nullable|image|max:2048',
            'photos' => 'array|max:5', // Limit to 5 photos
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('logo')) {
                if ($company->logo) {
                    Storage::disk('public')->delete($company->logo);
                }
                $path = $request->file('logo')->store('company_logos', 'public');
                $validatedData['logo'] = $path;
            }

            $company->update($validatedData);

            $this->handlePhotos($request, $company);

            DB::commit();
            return redirect()->route('companies.show', $company)->with('success', 'Company profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while updating the company profile.');
        }
    }

    ////////////////////////////////////////////////////
    // Photo Uploads
    ////////////////////////////////////////////////////

    private function handlePhotos(Request $request, Company $company)
    {
        if ($request->hasFile('photos')) {
            $existingPhotoCount = $company->photos()->count();
            $newPhotoCount = count($request->file('photos'));

            if ($existingPhotoCount + $newPhotoCount > 5) {
                throw new \Exception('Maximum of 5 photos allowed.');
            }

            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('company_photos', 'public');
                $company->photos()->create(['path' => $path]);
            }
        }
    }

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

    //////////////////////////////////////////////////////////
    // Helpers
    //////////////////////////////////////////////////////////
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
    // Business Processing Status
    public function checkProcessingStatus(JobListing $business)
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
