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
            class="mt-1 block w-full rounded-t-none rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror"
            style="height: 200px;"></div>
        <input type="hidden" name="description" id="description"
            value="{{ old('description', $employer->description ?? '') }}" required>
        @error('description')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>


    <div id="location_fields" class="space-y-4">
        <!-- Replace the existing location fields with this -->
        <div>
            <label for="location_search" class="block text-sm font-medium text-gray-700">Search Address</label>
            <input type="text" id="location_search"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                placeholder="Start typing your address...">
        </div>

        <!-- Hidden fields to store the actual values -->
        <input type="hidden" name="street_address" id="street_address"
            value="{{ old('street_address', $employer->street_address ?? '') }}">
        <input type="hidden" name="city" id="city" value="{{ old('city', $employer->city ?? '') }}">
        <input type="hidden" name="state" id="state" value="{{ old('state', $employer->state ?? '') }}">
        <input type="hidden" name="country" id="country" value="{{ old('country', $employer->country ?? '') }}">
        <input type="hidden" name="postal_code" id="postal_code"
            value="{{ old('postal_code', $employer->postal_code ?? '') }}">
        <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $employer->latitude ?? '') }}">
        <input type="hidden" name="longitude" id="longitude"
            value="{{ old('longitude', $employer->longitude ?? '') }}">

        <!-- Display fields (readonly) -->
        <div class="grid grid-cols-1 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Street Address</label>
                <input type="text" id="display_street_address" readonly
                    value="{{ old('street_address', $employer->street_address ?? '') }}"
                    class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md select-none">
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">City</label>
                    <input type="text" id="display_city" readonly value="{{ old('city', $employer->city ?? '') }}"
                        class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md select-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">State/Region</label>
                    <input type="text" id="display_state" readonly
                        value="{{ old('state', $employer->state ?? '') }}"
                        class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md select-none">
                </div>
            </div>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Country</label>
                    <input type="text" id="display_country" readonly
                        value="{{ old('country', $employer->country ?? '') }}"
                        class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md select-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Postal Code</label>
                    <input type="text" id="display_postal_code" readonly
                        value="{{ old('postal_code', $employer->postal_code ?? '') }}"
                        class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md select-none">
                </div>
            </div>
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
    <input type="hidden" id="featured_image_path" name="featured_image_path"
        value="{{ $employer->featured_image }}">

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


<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const locationSearch = document.getElementById('location_search');
        if (!locationSearch) return;

        const autocomplete = new google.maps.places.Autocomplete(locationSearch, {
            types: ['address'],
            fields: ['address_components', 'geometry', 'formatted_address']
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();

            // Reset all fields
            resetAddressFields();

            if (!place.geometry) {
                console.log("No location data available");
                return;
            }

            // Set latitude and longitude
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();

            // Process address components
            for (const component of place.address_components) {
                const type = component.types[0];

                switch (type) {
                    case 'street_number':
                    case 'route':
                        updateAddressField('street_address',
                            (document.getElementById('street_address').value + ' ' + component
                                .long_name).trim());
                        break;
                    case 'locality':
                        updateAddressField('city', component.long_name);
                        break;
                    case 'administrative_area_level_1':
                        updateAddressField('state', component.long_name);
                        break;
                    case 'country':
                        updateAddressField('country', component.long_name);
                        break;
                    case 'postal_code':
                        updateAddressField('postal_code', component.long_name);
                        break;
                }
            }

            // Clear the search field
            locationSearch.value = '';
        });

        function updateAddressField(field, value) {
            document.getElementById(field).value = value;
            document.getElementById(`display_${field}`).value = value;
        }

        function resetAddressFields() {
            const fields = ['street_address', 'city', 'state', 'country', 'postal_code'];
            fields.forEach(field => {
                document.getElementById(field).value = '';
                document.getElementById(`display_${field}`).value = '';
            });
            document.getElementById('latitude').value = '';
            document.getElementById('longitude').value = '';
        }
    });
</script>
