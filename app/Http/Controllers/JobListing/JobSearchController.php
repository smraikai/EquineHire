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

    public function search(Request $request)
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
            $filters = [];

            if ($state) {
                $filters[] = "state:{$state}";
            }

            if (!empty($categoryIds)) {
                $categoryFilter = 'category_id:(' . implode(' OR ', $categoryIds) . ')';
                $filters[] = $categoryFilter;
            }

            if ($jobType) {
                $filters[] = "job_type:{$jobType}";
            }

            if ($experienceLevel) {
                $filters[] = "experience_required:{$experienceLevel}";
            }

            if ($salaryType) {
                $filters[] = "salary_type:{$salaryType}";
            }

            if ($remotePosition) {
                $filters[] = "remote_position:true";
            }

            $options['filters'] = implode(' AND ', $filters);
            $options['facets'] = ['state', 'job_type', 'experience_required', 'salary_type', 'remote_position'];

            return $options;
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