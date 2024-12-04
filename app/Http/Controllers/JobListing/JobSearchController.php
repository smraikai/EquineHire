<?php

namespace App\Http\Controllers\JobListing;
use App\Http\Controllers\Controller;

use App\Models\JobListing;
use App\Models\JobListingCategory;
use Algolia\AlgoliaSearch\SearchIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\HasStates;
use App\Services\LocationService;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;

class JobSearchController extends Controller
{

    use HasStates;

    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function index(Request $request)
    {

        Log::info('Incoming search request:', $request->all());

        $validatedData = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
            'job_type' => 'nullable|string',
            'experience_level' => 'nullable|string',
            'salary_type' => 'nullable|string',
            'remote_position' => 'nullable|boolean',
        ]);

        $keyword = $request->input('keyword', '');
        $country = isset($validatedData['country']) && $validatedData['country']
            ? strtoupper(trim($validatedData['country']))
            : null;
        $categoryIds = $request->input('categories', []);
        $jobType = $request->input('job_type');
        $experienceLevel = $request->input('experience_level');
        $salaryType = $request->input('salary_type');
        $remotePosition = $request->boolean('remote_position');


        $algoliaResults = JobListing::search($keyword, function (SearchIndex $algolia, string $query, array $options) use ($country, $categoryIds, $jobType, $experienceLevel, $salaryType, $remotePosition) {
            $options['facets'] = ['country', 'category_ids', 'job_type', 'experience_required', 'salary_type', 'remote_position'];

            // Get user's selected/detected location
            $userLocation = $this->locationService->getLocation();

            // Only use IP-based geolocation if no specific country is selected
            if (!$country) {
                if (session()->has('user_location')) {
                    // Use specific coordinates based on country
                    $coordinates = $this->getCountryCoordinates($userLocation['country']);
                    $options['aroundLatLng'] = "{$coordinates['lat']}, {$coordinates['lng']}";
                } else {
                    // Fall back to IP-based geolocation
                    $options['aroundLatLngViaIP'] = true;
                }
            }

            $facetFilters = [];
            if ($country) {
                $facetFilters[] = "country:{$country}";
                Log::info('Applying country filter:', ['filter' => "country:{$country}"]);
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

            // Optional: Adjust ranking to balance distance vs. relevance
            $options['getRankingInfo'] = true;

            return $algolia->search($query, $options);
        });


        $results = $algoliaResults->paginate(15);
        $rawResults = $algoliaResults->raw();
        $facets = $rawResults['facets'] ?? [];

        Log::info('Search parameters:', [
            'keyword' => $keyword,
            'country' => $country,
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
                'countries' => $facets['country'] ?? [],
                'job_types' => $facets['job_type'] ?? [],
                'experience_levels' => $facets['experience_required'] ?? [],
                'salary_types' => $facets['salary_type'] ?? [],
                'remote_positions' => $facets['remote_position'] ?? [],
            ],
        ]);
    }

    private function getCountryCoordinates(string $countryCode): array
    {
        $coordinates = [
            // Non-EU Countries
            'US' => ['lat' => 37.0902, 'lng' => -95.7129],
            'GB' => ['lat' => 55.3781, 'lng' => -3.4360],
            'CA' => ['lat' => 56.1304, 'lng' => -106.3468],

            // EU Countries
            'AT' => ['lat' => 47.5162, 'lng' => 14.5501], // Austria
            'BE' => ['lat' => 50.8503, 'lng' => 4.3517],  // Belgium
            'BG' => ['lat' => 42.7339, 'lng' => 25.4858], // Bulgaria
            'HR' => ['lat' => 45.1000, 'lng' => 15.2000], // Croatia
            'CY' => ['lat' => 35.1264, 'lng' => 33.4299], // Cyprus
            'CZ' => ['lat' => 49.8175, 'lng' => 15.4730], // Czech Republic
            'DK' => ['lat' => 56.2639, 'lng' => 9.5018],  // Denmark
            'EE' => ['lat' => 58.5953, 'lng' => 25.0136], // Estonia
            'FI' => ['lat' => 61.9241, 'lng' => 25.7482], // Finland
            'FR' => ['lat' => 46.2276, 'lng' => 2.2137],  // France
            'DE' => ['lat' => 51.1657, 'lng' => 10.4515], // Germany
            'GR' => ['lat' => 39.0742, 'lng' => 21.8243], // Greece
            'HU' => ['lat' => 47.1625, 'lng' => 19.5033], // Hungary
            'IE' => ['lat' => 53.1424, 'lng' => -7.6921], // Ireland
            'IT' => ['lat' => 41.8719, 'lng' => 12.5674], // Italy
            'LV' => ['lat' => 56.8796, 'lng' => 24.6032], // Latvia
            'LT' => ['lat' => 55.1694, 'lng' => 23.8813], // Lithuania
            'LU' => ['lat' => 49.8153, 'lng' => 6.1296],  // Luxembourg
            'MT' => ['lat' => 35.9375, 'lng' => 14.3754], // Malta
            'NL' => ['lat' => 52.1326, 'lng' => 5.2913],  // Netherlands
            'PL' => ['lat' => 51.9194, 'lng' => 19.1451], // Poland
            'PT' => ['lat' => 39.3999, 'lng' => -8.2245], // Portugal
            'RO' => ['lat' => 45.9432, 'lng' => 24.9668], // Romania
            'SK' => ['lat' => 48.6690, 'lng' => 19.6990], // Slovakia
            'SI' => ['lat' => 46.1512, 'lng' => 14.9955], // Slovenia
            'ES' => ['lat' => 40.4637, 'lng' => -3.7492], // Spain
            'SE' => ['lat' => 60.1282, 'lng' => 18.6435], // Sweden
        ];

        return $coordinates[$countryCode] ?? $coordinates['US'];
    }

    public function category(Request $request, JobListingCategory $category)
    {
        $validatedData = $request->validate([
            'keyword' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $keyword = $request->input('keyword', '');
        $country = $validatedData['country'] ? strtoupper(trim($validatedData['country'])) : null;

        $algoliaResults = JobListing::search($keyword, function (SearchIndex $algolia, string $query, array $options) use ($category, $country) {
            $options['facets'] = ['country', 'category_ids', 'job_type', 'experience_required', 'salary_type', 'remote_position'];

            $facetFilters = ["category_ids:{$category->id}"];
            if ($country) {
                $facetFilters[] = "country:{$country}";
                Log::info('Applying category country filter:', ['filter' => "country:{$country}"]);
            }

            $options['facetFilters'] = $facetFilters;
            return $algolia->search($query, $options);
        });

        $results = $algoliaResults->paginate(15);

        Log::info('Category search parameters:', [
            'category' => $category->name,
            'keyword' => $keyword,
            'country' => $country,
            'resultsCount' => $results->count(),
            'resultsTotal' => $results->total(),
        ]);

        // Set SEO metadata
        $metaTitle = "Find {$category->name} Near You";
        $metaDescription = "Discover {$category->name} job opportunities in the equine industry. Connect with top employers and find your dream job in the horse world.";

        SEOMeta::setTitle($metaTitle);
        SEOMeta::setDescription($metaDescription);
        OpenGraph::setTitle($metaTitle);
        OpenGraph::setDescription($metaDescription);
        OpenGraph::setUrl(url("/jobs/{$category->slug}"));

        return view('jobs.category', [
            'category' => $category,
            'results' => $results,
        ]);
    }

}