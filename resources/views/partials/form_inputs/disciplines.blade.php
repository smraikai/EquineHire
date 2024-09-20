    <div class="mb-10">
        <label class="block mb-2 font-medium text-gray-500 text-md">Disciplines <span class="text-xs">(If
                Applicable)</span></label>
        <div class="relative">
            <input type="text" id="discipline-input"
                class="input"
                placeholder="Select or start typing">
            <div id="discipline-dropdown" class="absolute z-10 w-full mt-1 bg-white rounded-md shadow-lg">
                <!-- Dynamically populated via JavaScript -->
            </div>
        </div>
        <div id="discipline-tags" class="flex flex-wrap items-center mt-3">
            @foreach ($business->disciplines as $discipline)
                <!-- Check if the discipline has a parent -->
                <span
                    class="inline-flex items-center px-2 py-1 mb-2 mr-2 text-sm font-medium text-gray-800 bg-gray-100 rounded-sm"
                    data-discipline-id="{{ $discipline->id }}"
                    style="{{ $discipline->parent_id ? 'margin-left: 20px;' : '' }}">
                    {{ $discipline->name }}
                    <button type="button"
                        class="ml-2 text-gray-500 remove-discipline hover:text-gray-600 focus:outline-none">
                        &times;
                    </button>
                </span>
            @endforeach
        </div>
        <input type="hidden" id="selected-disciplines" name="disciplines[]"
            value="{{ $business->disciplines->pluck('id')->implode(',') }}">
    </div>
