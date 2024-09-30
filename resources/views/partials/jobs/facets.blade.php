@php
    $categories = \App\Models\JobListingCategory::orderBy('name')
        ->get()
        ->map(function ($category) {
            $category->checked = in_array($category->id, request()->input('categories', []));
            return $category;
        })
        ->sortBy(function ($category) {
            return $category->name === 'Other' ? 'zzz' : strtolower($category->name);
        });

    $checkedCategoryCount = $categories->where('checked', true)->count();

    $jobTypes = \App\Models\JobListing::distinct()->pluck('job_type')->filter()->sort()->values();
    $experienceLevels = \App\Models\JobListing::distinct()->pluck('experience_required')->filter()->sort()->values();
    $salaryTypes = \App\Models\JobListing::distinct()->pluck('salary_type')->filter()->sort()->values();
@endphp
<!-- Facets -->
<div x-data="{
    categories: {
        open: false,
        selected: {{ $checkedCategoryCount }}
    },
    jobTypes: {
        open: false,
        selected: {{ count(request()->input('job_types', [])) }}
    },
    experienceLevels: {
        open: false,
        selected: {{ count(request()->input('experience_levels', [])) }}
    },
    salaryTypes: {
        open: false,
        selected: {{ count(request()->input('salary_types', [])) }}
    },
    clearAll() {
        const allCheckboxes = [...this.$refs.facetForm.querySelectorAll('.category-checkbox')];
        allCheckboxes.forEach(checkbox => checkbox.checked = false);
    }
}" x-ref="facetForm">

    <div class="space-y-8">
        <form action="{{ route('jobs.index') }}" method="GET">
            <!-- Hidden inputs for keyword and location -->
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            <input type="hidden" name="location" value="{{ request('location') }}">

            <!-- Categories -->
            <div>
                <span class="text-sm font-medium">Categories</span>
                <div class="flex flex-col gap-2 mt-2">
                    @foreach ($categories as $category)
                        <div class="flex items-center w-full">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                id="category-{{ $category->id }}" class="category-checkbox"
                                @checked($category->checked)>
                            <label for="category-{{ $category->id }}"
                                class="ml-2 text-sm font-normal">{{ $category->name }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Job Type -->
            <div class="mt-4">
                <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type</label>
                <select id="job_type" name="job_type" x-ref="jobTypeSelect"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Job Types</option>
                    @foreach ($jobTypes as $jobType)
                        <option value="{{ $jobType }}" @selected(request('job_type') == $jobType)>{{ $jobType }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Experience Required -->
            <div class="mt-4">
                <label for="experience_level" class="block text-sm font-medium text-gray-700">Experience
                    Required</label>
                <select id="experience_level" name="experience_level" x-ref="experienceLevelSelect"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Experience Levels</option>
                    @foreach ($experienceLevels as $level)
                        <option value="{{ $level }}" @selected(request('experience_level') == $level)>{{ $level }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Salary Type -->
            <div class="mt-4">
                <label for="salary_type" class="block text-sm font-medium text-gray-700">Salary Type</label>
                <select id="salary_type" name="salary_type" x-ref="salaryTypeSelect"
                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="">All Salary Types</option>
                    @foreach ($salaryTypes as $salaryType)
                        <option value="{{ $salaryType }}" @selected(request('salary_type') == $salaryType)>{{ Str::title($salaryType) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Remote Position -->
            <div class="mt-4">
                <span class="text-sm font-medium">Remote Position</span>
                <div class="flex items-center w-full mt-2">
                    <input type="checkbox" name="remote_position" value="1" id="remote-position"
                        class="remote-position-checkbox" @checked(request()->input('remote_position'))>
                    <label for="remote-position" class="ml-2 text-sm font-normal">Remote</label>
                </div>
            </div>

            <!-- Apply button for categories -->
            <button type="submit"
                class="w-full mt-5 rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Apply</button>

            <!-- Clear All Button -->
            <button type="button" @click="clearAll()" class="w-full mt-2 text-sm text-gray-500 hover:text-gray-700">
                Clear Selection
            </button>
        </form>
    </div>
</div>
