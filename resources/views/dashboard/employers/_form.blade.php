@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700">Employer Name <span
                class="text-red-500">*</span></label>
        <input type="text" name="name" id="name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
            value="{{ old('name', $employer->name ?? '') }}" required
            placeholder="Enter your company or organization name">
        @error('name')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description <span
                class="text-red-500">*</span></label>
        <div id="quill_editor"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror"
            style="height: 200px;"></div>
        <input type="hidden" name="description" id="description"
            value="{{ old('description', $employer->description ?? '') }}" required>
        @error('description')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">City <span
                    class="text-red-500">*</span></label>
            <input type="text" name="city" id="city"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('city') border-red-500 @enderror"
                value="{{ old('city', $employer->city ?? '') }}" required placeholder="Enter your company's city">
            @error('city')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="state" class="block text-sm font-medium text-gray-700">State <span
                    class="text-red-500">*</span></label>
            <select name="state" id="state"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('state') border-red-500 @enderror"
                required>
                <option value="">Select your company's state</option>
                @foreach ($states as $abbr => $name)
                    <option value="{{ $abbr }}"
                        {{ old('state', $employer->state ?? '') == $abbr ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('state')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
        <input type="url" name="website" id="website"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('website') border-red-500 @enderror"
            value="{{ old('website', $employer->website ?? '') }}" placeholder="https://www.yourcompany.com">
        <p class="mt-1 text-xs text-gray-500">https:// is required</p>
        @error('website')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">Employer Logo</label>
        @if ($employer->logo)
            <div class="flex flex-col items-start mb-2 sm:flex-row sm:items-center">
                <img src="{{ $employer->logo_url }}" alt="{{ $employer->name }} logo"
                    class="max-w-[200px] max-h-[100px] object-contain mb-2 sm:mb-0">
                <div class="flex flex-wrap gap-2 sm:ml-4">
                    <button type="button" id="replace-logo"
                        class="px-3 py-1 text-sm text-gray-800 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Replace logo
                    </button>
                    <button type="button" id="delete-logo"
                        class="px-3 py-1 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete logo
                    </button>
                </div>
            </div>
        @else
            <p class="mt-1 text-xs text-gray-500">Upload your company logo (max 3MB)</p>
        @endif
        <div id="logo-uploader" class="{{ $employer->logo ? 'hidden' : '' }}"></div>
    </div>
    <input type="hidden" name="logo_path" id="logo_path" value="{{ $employer->logo }}">

    <div>
        <label for="featured_image" class="block mb-2 text-sm font-medium text-gray-700">Featured Image</label>
        @if ($employer->featured_image)
            <div class="flex flex-col items-start mb-2 sm:flex-row sm:items-center">
                <img src="{{ Storage::url($employer->featured_image) }}" alt="{{ $employer->name }} featured image"
                    class="max-w-[300px] max-h-[150px] object-contain mb-2 sm:mb-0">
                <div class="flex flex-wrap gap-2 sm:ml-4">
                    <button type="button" id="replace-featured-image"
                        class="px-3 py-1 text-sm text-gray-800 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Replace image
                    </button>
                    <button type="button" id="delete-featured-image"
                        class="px-3 py-1 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete image
                    </button>
                </div>
            </div>
        @else
            <p class="mt-1 text-xs text-gray-500">Upload a featured image to showcase your business.</p>
        @endif
        <div id="featured-image-uploader" class="{{ $employer->featured_image ? 'hidden' : '' }}"></div>
    </div>
    <input type="hidden" id="featured_image_path" name="featured_image_path" value="{{ $employer->featured_image }}">

    <div class="flex flex-col-reverse items-end justify-end gap-4 sm:flex-row">
        <a href="{{ route('employers.index') }}"
            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm sm:w-auto hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition bg-blue-600 border border-transparent rounded-md sm:w-auto hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
            {{ isset($employer) && $employer->exists ? 'Update Employer Profile' : 'Create Profile' }}
        </button>

    </div>
</div>
