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
@endphp
<!-- Facets -->
<div x-data="{
    showAllCategories: false,
    clearAll() {
        const allCheckboxes = [...this.$refs.facetForm.querySelectorAll('.category-checkbox')];
        allCheckboxes.forEach(checkbox => checkbox.checked = false);
    }
}" x-ref="facetForm">

    @php
        $showCountCategories = max(5, $checkedCategoryCount);
    @endphp

    <h3 class="hidden text-lg font-medium md:block">Filters</h3>
    <hr class="my-2">

    <div class="space-y-8">
        <form action="{{ route('jobs.index') }}" method="GET">
            <!-- Hidden inputs for keyword and location -->
            <input type="hidden" name="keyword" value="{{ request('keyword') }}">
            <input type="hidden" name="location" value="{{ request('location') }}">

            <!-- Categories -->
            <div>
                <span class="text-sm font-medium">Categories</span>
                <div class="flex flex-col gap-2 mt-2">
                    @foreach ($sortedCategories as $key => $category)
                        <div class="flex items-center w-full"
                            :class="{ 'hidden': !showAllCategories && {{ $key }} >= {{ $showCountCategories }} }">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                id="category-{{ $category->id }}" class="category-checkbox"
                                @checked($category->checked)>
                            <label for="category-{{ $category->id }}"
                                class="ml-2 text-sm font-normal">{{ $category->name }}</label>
                        </div>
                    @endforeach
                    @if (count($facets['categories']) > 5)
                        <button type="button" @click="showAllCategories = !showAllCategories"
                            class="mt-1 text-blue-500 hover:text-blue-700">
                            <span x-show="!showAllCategories" class="flex items-center space-x-1 text-sm">
                                <span>{{ __('Show More') }}</span>
                                <x-coolicon-caret-down-sm class="w-6 h-6" />
                            </span>
                            <span x-show="showAllCategories" class="flex items-center space-x-1 text-sm">
                                <span>{{ __('Show Less') }}</span>
                                <x-coolicon-caret-up-sm class="w-6 h-6" />
                            </span>
                        </button>
                    @endif
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
