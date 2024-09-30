<?php

namespace App\Http\Controllers\JobListing;
use App\Http\Controllers\Controller;

use App\Models\JobListing;
use App\Models\JobListingCategory;
use Algolia\AlgoliaSearch\SearchIndex;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Traits\HasStates;

class JobSearchController extends Controller
{

    use HasStates;

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
}