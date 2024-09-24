<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use Illuminate\Support\Facades\Cache;

// Illumination
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

// Stripe Integration for GA Tracking
use Stripe\Stripe;
use Stripe\Price;

// Analytics for Users Dashboard
use App\Models\PageView;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class EmployerController extends Controller
{

    /////////////////////////////////////////////////////////////
    // Employer Dashboard
    /////////////////////////////////////////////////////////////
    public function index(Request $request)
    {
        $user = auth()->user();
        $employer = $user->employer;
        $jobListings = $employer ? $employer->jobListings()->latest()->take(5)->get() : collect();

        // Check if the user is a new subscriber. If so, pass off info to the DataLayer
        if ($request->query('subscription_completed')) {
            Stripe::setApiKey(config('services.stripe.secret'));
            $subscription = $user->subscription('default');
            $price = Price::retrieve($subscription->stripe_price);
            $amount = $price->unit_amount / 100; // Convert cents to dollars

            return view('dashboard.employers.index', compact('user', 'employer', 'jobListings', 'subscription', 'amount'));
        }

        return view('dashboard.employers.index', compact('user', 'employer', 'jobListings'));
    }

    //////////////////////////////////////////////////////////
    // Employer Profile: Views
    //////////////////////////////////////////////////////////

    public function profileIndex()
    {
        $user = auth()->user();
        $employer = $user->employer;

        return view('dashboard.employers.index', compact('employer'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Employer::class);

        $employer = Employer::create([
            'user_id' => auth()->id(),
            'name' => '',
            'description' => '',
            'website' => '',
            'city' => '',
            'state' => '',
            'logo' => '',
        ]);

        return redirect()->route('employers.edit', $employer)
            ->with('info', 'New employer profile created. Please complete the details.');
    }

    public function edit(Request $request, Employer $employer)
    {
        $this->authorize('update', $employer);

        $states = $this->getStates();
        return view('dashboard.employers.edit', compact('employer', 'states'));
    }
    //////////////////////////////////////////////////////////
    // Emplower Profile: Edit, Update, Destroy
    //////////////////////////////////////////////////////////
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'website' => 'nullable|url',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'logo' => 'nullable|image|max:2048',
        ]);

        DB::beginTransaction();

        try {
            $employer = new Employer($validatedData);
            $employer->user_id = auth()->id();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('employer_logos', 'public');
                $employer->logo = $path;
            }

            $employer->save();

            $this->handlePhotos($request, $employer);

            DB::commit();
            return redirect()->route('employers.show', $employer)->with('success', 'Employer profile created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'An error occurred while creating the employer profile.');
        }
    }

    public function update(Request $request, Employer $employer)
    {
        $this->authorize('update', $employer);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'website' => ['nullable', 'url', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'logo_path' => 'nullable|string',
            'featured_image_path' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            if ($request->filled('logo_path')) {
                $employer->logo = $validatedData['logo_path'];
            }

            if ($request->filled('featured_image_path')) {
                $employer->featured_image = $validatedData['featured_image_path'];
            }

            $employer->update($validatedData);

            DB::commit();
            return redirect()->route('employers.index', $employer)->with('success', 'Employer profile updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating employer profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the employer profile.');
        }
    }


    ////////////////////////////////////////////////////
    // Job View Analytics
    ////////////////////////////////////////////////////
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
    private function getStates()
    {
        return [
            'AL' => 'Alabama',
            'AK' => 'Alaska',
            'AZ' => 'Arizona',
            'AR' => 'Arkansas',
            'CA' => 'California',
            'CO' => 'Colorado',
            'CT' => 'Connecticut',
            'DE' => 'Delaware',
            'FL' => 'Florida',
            'GA' => 'Georgia',
            'HI' => 'Hawaii',
            'ID' => 'Idaho',
            'IL' => 'Illinois',
            'IN' => 'Indiana',
            'IA' => 'Iowa',
            'KS' => 'Kansas',
            'KY' => 'Kentucky',
            'LA' => 'Louisiana',
            'ME' => 'Maine',
            'MD' => 'Maryland',
            'MA' => 'Massachusetts',
            'MI' => 'Michigan',
            'MN' => 'Minnesota',
            'MS' => 'Mississippi',
            'MO' => 'Missouri',
            'MT' => 'Montana',
            'NE' => 'Nebraska',
            'NV' => 'Nevada',
            'NH' => 'New Hampshire',
            'NJ' => 'New Jersey',
            'NM' => 'New Mexico',
            'NY' => 'New York',
            'NC' => 'North Carolina',
            'ND' => 'North Dakota',
            'OH' => 'Ohio',
            'OK' => 'Oklahoma',
            'OR' => 'Oregon',
            'PA' => 'Pennsylvania',
            'RI' => 'Rhode Island',
            'SC' => 'South Carolina',
            'SD' => 'South Dakota',
            'TN' => 'Tennessee',
            'TX' => 'Texas',
            'UT' => 'Utah',
            'VT' => 'Vermont',
            'VA' => 'Virginia',
            'WA' => 'Washington',
            'WV' => 'West Virginia',
            'WI' => 'Wisconsin',
            'WY' => 'Wyoming',
        ];
    }
}
