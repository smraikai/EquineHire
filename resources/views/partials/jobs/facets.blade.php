@php
    $sortedCategories = collect($facets['categories'])
        ->map(function ($category) {
            $category->checked = in_array($category->id, request()->input('categories', []));
            return $category;
        })
        ->sortBy(function ($category) {
            if ($category->name === 'Other') {
                return 'zzz';
            }
            return strtolower($category->name);
        })
        ->partition(function ($category) {
            return $category->checked;
        });

    $sortedCategories = $sortedCategories->get(0)->merge($sortedCategories->get(1));

    $checkedCategoryCount = $sortedCategories->where('checked', true)->count();

    $jobTypes = \App\Models\JobListing::distinct()->pluck('job_type')->filter()->sort()->values();
    $experienceLevels = \App\Models\JobListing::distinct()->pluck('experience_required')->filter()->sort()->values();
    $salaryTypes = \App\Models\JobListing::distinct()->pluck('salary_type')->filter()->sort()->values();
@endphp
<!-- Facets -->
<div x-data="{
    showAllCategories: false,
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
                    @foreach ($sortedCategories as $category)
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
                <span class="text-sm font-medium">Job Type</span>
                <div class="flex flex-col gap-2 mt-2">
                    @foreach ($jobTypes as $jobType)
                        <div class="flex items-center w-full">
                            <input type="checkbox" name="job_types[]" value="{{ $jobType }}"
                                id="job-type-{{ $jobType }}" class="job-type-checkbox"
                                @checked(in_array($jobType, request()->input('job_types', [])))>
                            <label for="job-type-{{ $jobType }}"
                                class="ml-2 text-sm font-normal">{{ $jobType }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Experience Required -->
            <div class="mt-4">
                <span class="text-sm font-medium">Experience Required</span>
                <div class="flex flex-col gap-2 mt-2">
                    @foreach ($experienceLevels as $level)
                        <div class="flex items-center w-full">
                            <input type="checkbox" name="experience_levels[]" value="{{ $level }}"
                                id="experience-{{ $level }}" class="experience-checkbox"
                                @checked(in_array($level, request()->input('experience_levels', [])))>
                            <label for="experience-{{ $level }}"
                                class="ml-2 text-sm font-normal">{{ $level }}</label>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Salary Type -->
            <div class="mt-4">
                <span class="text-sm font-medium">Salary Type</span>
                <div class="flex flex-col gap-2 mt-2">
                    @foreach ($salaryTypes as $salaryType)
                        <div class="flex items-center w-full">
                            <input type="checkbox" name="salary_types[]" value="{{ $salaryType }}"
                                id="salary-type-{{ $salaryType }}" class="salary-type-checkbox"
                                @checked(in_array($salaryType, request()->input('salary_types', [])))>
                            <label for="salary-type-{{ $salaryType }}"
                                class="ml-2 text-sm font-normal">{{ $salaryType }}</label>
                        </div>
                    @endforeach
                </div>
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
