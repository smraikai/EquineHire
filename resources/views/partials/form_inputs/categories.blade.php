    <div class="mb-10">
        <label class="block mb-2 font-medium text-gray-500 text-md">Categories</label>
        <div class="relative">
            <input type="text" id="category-input" class="input" placeholder="Select or start typing">
            <div id="category-dropdown" class="absolute z-10 w-full mt-1 transform bg-white rounded-lg shadow-lg">

                <!-- Dynamically populated via JavaScript -->
            </div>
        </div>
        <div id="category-tags" class="flex flex-wrap items-center mt-3">
            @foreach ($business->categories as $category)
                <!-- Check if the category has a parent -->
                <span
                    class="inline-flex items-center px-2 py-1 mb-2 mr-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-sm"
                    data-category-id="{{ $category->id }}"
                    style="{{ $category->parent_id ? 'margin-left: 20px;' : '' }}">
                    {{ $category->name }}
                    <button type="button"
                        class="ml-2 text-gray-500 remove-category hover:text-gray-600 focus:outline-none">
                        &times;
                    </button>
                </span>
            @endforeach
        </div>
        <input type="hidden" id="selected-categories" name="categories[]"
            value="{{ $business->categories->pluck('id')->implode(',') }}">
        <div id="categoryError" class="mt-1 text-sm text-red-500"></div>
    </div>
