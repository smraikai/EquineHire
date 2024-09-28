<?php

namespace App\Http\Controllers;

use Algolia\AlgoliaSearch\SearchIndex;

// Models
use App\Models\JobListingCategory;
use App\Models\JobListing;
use App\Models\Employer;
use Illuminate\Support\Str;

// Illumination
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

// Services 
use App\Services\SeoService;

class JobListingController extends Controller
{

    ////////////////////////////////////////////////////////////////
    // Job Index, Views, Etc.
    ////////////////////////////////////////////////////////////////
    public function index(Request $request)
    {

        Log::info('Incoming search request:', $request->all());

        $validatedData = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'job_type' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'salary_type' => 'nullable|string',
            'remote_position' => 'nullable|boolean',
        ]);

        $keyword = $request->input('keyword', '');
        $state = $validatedData['state'] ?? null;
        $categoryIds = $request->input('categories', []);
        $jobType = $request->input('job_type');
        $experienceLevel = $request->input('experience_level');
        $salaryType = $request->input('salary_type');
        $remotePosition = $request->boolean('remote_position');

        $algoliaResults = JobListing::search($keyword, function (SearchIndex $algolia, string $query, array $options) use ($state, $categoryIds, $jobType, $experienceLevel, $salaryType, $remotePosition) {
            $options['facets'] = ['state', 'category_ids', 'job_type', 'experience_required', 'salary_type', 'remote_position'];

            $facetFilters = [];
            if ($state) {
                $facetFilters[] = "state:{$state}";
            }
            if (!empty($categoryIds)) {
                $categoryFilters = array_map(function ($id) {
                    return "category_ids:{$id}";
                }, $categoryIds);
                $facetFilters[] = $categoryFilters;
            }
            if ($jobType) {
                $facetFilters[] = "job_type:{$jobType}";
            }
            if ($experienceLevel) {
                $facetFilters[] = "experience_required:{$experienceLevel}";
            }
            if ($salaryType) {
                $facetFilters[] = "salary_type:{$salaryType}";
            }
            if ($remotePosition) {
                $facetFilters[] = 'remote_position:true';
            }

            if (!empty($facetFilters)) {
                $options['facetFilters'] = $facetFilters;
            }

            Log::info('Algolia search query:', [
                'query' => $query,
                'options' => $options
            ]);

            return $algolia->search($query, $options);
        });


        $results = $algoliaResults->paginate(15);
        $rawResults = $algoliaResults->raw();
        $facets = $rawResults['facets'] ?? [];

        Log::info('Search parameters:', [
            'keyword' => $keyword,
            'state' => $state,
            'categoryIds' => $categoryIds,
            'jobType' => $jobType,
            'experienceLevel' => $experienceLevel,
            'salaryType' => $salaryType,
            'remotePosition' => $remotePosition,
            'resultsCount' => $results->count(),
            'resultsTotal' => $results->total(),
        ]);

        $categories = JobListingCategory::all();

        return view('jobs.index', [
            'results' => $results,
            'facets' => [
                'categories' => $categories,
                'states' => $facets['state'] ?? [],
                'job_types' => $facets['job_type'] ?? [],
                'experience_levels' => $facets['experience_required'] ?? [],
                'salary_types' => $facets['salary_type'] ?? [],
                'remote_positions' => $facets['remote_position'] ?? [],
            ],
        ]);
    }

    public function show(Request $request, $job_slug, $id, SeoService $seoService)
    {
        $job_listing = JobListing::with('employer')->findOrFail($id);

        // Check if the slug matches (for SEO purposes)
        if ($job_listing->slug !== $job_slug) {
            return redirect()->route('jobs.show', [$job_listing->slug, $job_listing->id], 301);
        }

        // Check if the job listing is active
        if (!$job_listing->is_active) {
            abort(404);
        }

        // Generate meta title and description using SeoService
        $location = $job_listing->remote_position ? null : "{$job_listing->city}, {$job_listing->state}";
        $metaTitle = $seoService->generateMetaTitle($job_listing->title, $job_listing->employer->name, $location);
        $metaDescription = $seoService->generateMetaDescription($job_listing->description);

        $isOwner = auth()->check() && auth()->user()->id === $job_listing->user_id;

        // Pass the employer to the view
        $employer = $job_listing->employer;

        return view('jobs.show', compact('job_listing', 'isOwner', 'metaTitle', 'metaDescription', 'employer'));
    }

    ////////////////////////////////////////////////////////////////
    // Employer – Job Listing: Views
    ////////////////////////////////////////////////////////////////
    public function employerJobListings()
    {
        // Define User
        $user = auth()->user();

        // Check if User has Employer Profile
        if (!Employer::employerProfileCheck($user)) {
            return redirect()->route('employers.index')->with('error', 'You need to complete your employer profile first.');
        }

        $jobListings = auth()->user()->jobListings()->paginate(10);
        return view('dashboard.job-listings.index', compact('jobListings'));
    }

    public function employerCreateJobListing()
    {
        $user = auth()->user();
        $employer = $user->employer;

        // Check if user has employer profile
        if (!Employer::employerProfileCheck($user)) {
            return redirect()->route('employers.index')->with('error', 'You need to complete your employer profile first.');
        }

        // Check if user is at job posting limit for their subscription
        if (!$user->canCreateJobListing()) {
            return redirect()->route('employers.job-listings.index')->with('error', 'You have reached the job listing limit for your current subscription plan.');
        }

        $categories = JobListingCategory::all();
        $states = $this->getStates();
        $jobListing = new JobListing();
        return view('dashboard.job-listings.create', compact('categories', 'states'));
    }

    public function employerEditJobListing(JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);
        $categories = JobListingCategory::all();
        $states = $this->getStates();
        return view('dashboard.job-listings.edit', compact('jobListing', 'categories', 'states'));
    }


    ////////////////////////////////////////////////////////////////
    // Dashboard – Job Listing: Logic
    ////////////////////////////////////////////////////////////////

    public function employerStoreJobListing(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:job_listing_categories,id',
            'description' => 'required',
            'remote_position' => 'required|boolean',
            'city' => 'nullable|required_if:remote_position,0|string|max:255',
            'state' => 'nullable|required_if:remote_position,0|string|size:2|in:' . implode(',', array_keys($this->getStates())),
            'job_type' => 'required|in:full-time,part-time,contract,temp,freelance,internship,externship,seasonal,working-student',
            'experience_required' => 'required|in:0-1 Years,1-2 Years,2-5 Years,5+ Years',
            'salary_type' => 'nullable|in:hourly,annual',
            'hourly_rate_min' => 'required_if:salary_type,hourly|nullable|numeric|min:10|max:100',
            'hourly_rate_max' => 'required_if:salary_type,hourly|nullable|numeric|min:15|max:200|gt:hourly_rate_min',
            'salary_range_min' => 'required_if:salary_type,annual|nullable|numeric|min:10000|max:100000',
            'salary_range_max' => 'required_if:salary_type,annual|nullable|numeric|min:20000|max:300000|gt:salary_range_min',
            'application_type' => 'required|in:link,email',
            'application_link' => 'required_if:application_type,link|nullable|url',
            'email_link' => 'required_if:application_type,email|nullable|email',
        ]);

        $validatedData['slug'] = $this->generateUniqueSlug($validatedData['title']);

        $user = auth()->user();
        $employer = $user->employer;

        $validatedData['employer_id'] = $employer->id;
        $validatedData['user_id'] = $user->id;

        try {
            $jobListing = JobListing::create($validatedData);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the job listing. Please try again.');
        }

        return redirect()->route('employers.job-listings.index')->with('success', 'Job listing created successfully.');
    }

    public function employerUpdateJobListing(Request $request, JobListing $jobListing)
    {
        $this->authorize('update', $jobListing);

        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'category_id' => 'required|exists:job_listing_categories,id',
            'slug',
            'description' => 'required',
            'remote_position' => 'required|boolean',
            'city' => 'nullable|required_if:remote_position,0|string|max:255',
            'state' => 'nullable|required_if:remote_position,0|string|size:2|in:' . implode(',', array_keys($this->getStates())),
            'job_type' => 'required|in:full-time,part-time,contract,temporary',
            'experience_required' => 'required|in:0-1 Years,1-2 Years,2-5 Years,5+ Years',
            'salary_type' => 'required|in:hourly,annual',
            'hourly_rate_min' => 'required_if:salary_type,hourly|nullable|numeric|min:10|max:100',
            'hourly_rate_max' => 'required_if:salary_type,hourly|nullable|numeric|min:15|max:200|gt:hourly_rate_min',
            'salary_range_min' => 'required_if:salary_type,annual|nullable|numeric|min:10000|max:100000',
            'salary_range_max' => 'required_if:salary_type,annual|nullable|numeric|min:20000|max:300000|gt:salary_range_min',
            'application_type' => 'required|in:link,email',
            'application_link' => 'required_if:application_type,link|nullable|url',
            'email_link' => 'required_if:application_type,email|nullable|email',
        ]);

        $jobListing->update($validatedData);

        return redirect()->route('employers.job-listings.index')->with('success', 'Job listing updated successfully.');
    }

    public function employerDestroyJobListing(JobListing $jobListing)
    {
        $this->authorize('delete', $jobListing);

        $jobListing->delete();

        return redirect()->route('employers.job-listings.index')
            ->with('success', 'Job listing deleted successfully.');
    }

    ////////////////////////////////////////////////////
    // Helpers
    ////////////////////////////////////////////////////
    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 2;

        while (JobListing::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
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
}
