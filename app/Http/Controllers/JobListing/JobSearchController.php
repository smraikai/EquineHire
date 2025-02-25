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

            $facetFilters = [];
            $facetFilters[] = "is_active:true";
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

            // Optional: Adjust ranking to balance distance vs. relevance
            $options['getRankingInfo'] = true;

            return $algolia->search($query, $options);
        });


        $results = $algoliaResults->paginate(15);
        $rawResults = $algoliaResults->raw();
        $facets = $rawResults['facets'] ?? [];

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

            $facetFilters = ["category_ids:{$category->id}", "is_active:true"];
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