    <div class="mb-10">
        <span class="block mb-2 font-medium text-gray-500 text-md">Description</span>
        <input type="hidden" name="description" id="description"
            value="{{ old('description', $business->description ?? '') }}" required>
        <div id="quill_editor"
            class="input">
        </div>
        <div id="descriptionError" class="mt-1 text-sm text-red-500"></div>
    </div>
