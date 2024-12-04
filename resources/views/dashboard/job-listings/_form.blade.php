@csrf

@if ($errors->any())
    <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Job Title <span
                class="text-red-500">*</span></label>
        <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('title') border-red-500 @enderror"
            value="{{ old('title', $jobListing->title ?? '') }}" placeholder="Enter job title" required>
        @error('title')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span
                class="text-red-500">*</span></label>
        <select name="category_id" id="category_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror"
            required>
            <option value="">Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $jobListing->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description <span
                class="text-red-500">*</span></label>
        <div id="quill_editor"
            class="max-h-[500px] overflow-auto ]mt-1 block w-full rounded-t-none rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">
        </div>
        <input type="hidden" name="description" id="description"
            value="{{ old('description', $jobListing->description ?? '') }}" required>
        @error('description')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    @include('dashboard.job-listings._listing-strength')

    <div>
        <label class="block text-sm font-medium text-gray-700">Remote Position <span
                class="text-red-500">*</span></label>
        <div class="mt-2 space-y-2 sm:space-y-0 sm:flex sm:space-x-4">
            <div class="flex items-center">
                <input type="radio" id="remote_position_yes" name="remote_position" value="1"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('remote_position', $jobListing->remote_position ?? '') == '1' ? 'checked' : '' }} required>
                <label for="remote_position_yes" class="ml-2 text-sm text-gray-600">Yes</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="remote_position_no" name="remote_position" value="0"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('remote_position', $jobListing->remote_position ?? '') == '0' ? 'checked' : '' }} required>
                <label for="remote_position_no" class="ml-2 text-sm text-gray-600">No</label>
            </div>
        </div>
        @error('remote_position')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>



    <div id="location_fields" class="space-y-4" style="display: none;">
        <div>
            <label for="location_search" class="block text-sm font-medium text-gray-700">Search Address <span
                    class="text-red-500">*</span></label>
            <input type="text" id="location_search"
                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                placeholder="Start typing your address..."
                value="{{ old('street_address', $jobListing->street_address ?? '')
                    ? old('street_address', $jobListing->street_address) .
                        ', ' .
                        old('city', $jobListing->city) .
                        ', ' .
                        old('state', $jobListing->state) .
                        ' ' .
                        old('postal_code', $jobListing->postal_code) .
                        ', ' .
                        old('country', $jobListing->country ?? 'United States')
                    : '' }}">
        </div>

        <!-- Hidden fields for form submission -->
        <input type="hidden" name="street_address" id="street_address"
            value="{{ old('street_address', $jobListing->street_address ?? '') }}">
        <input type="hidden" name="city" id="city" value="{{ old('city', $jobListing->city ?? '') }}">
        <input type="hidden" name="state" id="state" value="{{ old('state', $jobListing->state ?? '') }}">
        <input type="hidden" name="country" id="country"
            value="{{ old('country', $jobListing->country ?? 'United States') }}">
        <input type="hidden" name="postal_code" id="postal_code"
            value="{{ old('postal_code', $jobListing->postal_code ?? '') }}">
        <input type="hidden" name="latitude" id="latitude"
            value="{{ old('latitude', $jobListing->latitude ?? '') }}">
        <input type="hidden" name="longitude" id="longitude"
            value="{{ old('longitude', $jobListing->longitude ?? '') }}">
    </div>


    <div>
        <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type <span
                class="text-red-500">*</span></label>
        <select name="job_type" id="job_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('job_type') border-red-500 @enderror"
            required>
            <option value="">Select Job Type</option>
            <option value="full-time"
                {{ old('job_type', $jobListing->job_type ?? '') == 'full-time' ? 'selected' : '' }}>Full Time</option>
            <option value="part-time"
                {{ old('job_type', $jobListing->job_type ?? '') == 'part-time' ? 'selected' : '' }}>Part Time</option>
            <option value="contract"
                {{ old('job_type', $jobListing->job_type ?? '') == 'contract' ? 'selected' : '' }}>Contract</option>
            <option value="temp" {{ old('job_type', $jobListing->job_type ?? '') == 'temp' ? 'selected' : '' }}>
                Temporary</option>
            <option value="freelance"
                {{ old('job_type', $jobListing->job_type ?? '') == 'freelance' ? 'selected' : '' }}>Freelance</option>
            <option value="working-student"
                {{ old('job_type', $jobListing->job_type ?? '') == 'working-student' ? 'selected' : '' }}>Working
                Student</option>
            <option value="internship"
                {{ old('job_type', $jobListing->job_type ?? '') == 'internship' ? 'selected' : '' }}>Internship
            </option>
            <option value="externship"
                {{ old('job_type', $jobListing->job_type ?? '') == 'externship' ? 'selected' : '' }}>Externship
            </option>
            <option value="seasonal"
                {{ old('job_type', $jobListing->job_type ?? '') == 'seasonal' ? 'selected' : '' }}>Seasonal</option>
        </select>
        @error('job_type')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="experience_required" class="block text-sm font-medium text-gray-700">Experience Required <span
                class="text-red-500">*</span></label>
        <select name="experience_required" id="experience_required"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('experience_required') border-red-500 @enderror"
            required>
            <option value="">Select Experience</option>
            <option value="0-1 Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '0-1 Years' ? 'selected' : '' }}>
                0-1 Years</option>
            <option value="1-2 Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '1-2 Years' ? 'selected' : '' }}>
                1-2 Years</option>
            <option value="2-5 Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '2-5 Years' ? 'selected' : '' }}>
                2-5 Years</option>
            <option value="5+ Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '5+ Years' ? 'selected' : '' }}>
                5+ Years</option>
        </select>
        @error('experience_required')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="salary_type" class="block text-sm font-medium text-gray-700">Salary Type (Optional)</label>
        <select name="salary_type" id="salary_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('salary_type') border-red-500 @enderror">
            <option value="">Select Salary Type</option>
            <option value="hourly"
                {{ old('salary_type', $jobListing->salary_type ?? '') == 'hourly' ? 'selected' : '' }}>Hourly</option>
            <option value="salary"
                {{ old('salary_type', $jobListing->salary_type ?? '') == 'salary' ? 'selected' : '' }}>Salary</option>
        </select>
        @error('salary_type')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="currency_selector" style="display: none;">
        <label for="currency" class="block text-sm font-medium text-gray-700">Currency <span
                class="text-red-500">*</span></label>
        <select name="currency" id="currency"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('currency') border-red-500 @enderror"
            required>
            @foreach (\App\Models\JobListing::CURRENCIES as $code => $currency)
                <option value="{{ $code }}"
                    {{ old('currency', $jobListing->currency ?? 'USD') == $code ? 'selected' : '' }}>
                    {{ $currency['symbol'] }} - {{ $currency['name'] }}
                </option>
            @endforeach
        </select>
        @error('currency')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="hourly_rate_fields" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4"
        style="display: none;">
        <div>
            <label for="hourly_rate_min" class="block text-sm font-medium text-gray-700">Hourly Rate Min <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50"
                    id="hourly-currency-symbol">
                    {{ \App\Models\JobListing::CURRENCIES[old('currency', $jobListing->currency ?? 'USD')]['symbol'] }}
                </span>
                <select name="hourly_rate_min" id="hourly_rate_min"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-blue-500 focus:border-blue-500 rounded-r-md sm:text-sm">
                    <option value="">Select minimum rate</option>
                    @for ($i = 10; $i <= 100; $i += 5)
                        <option value="{{ $i }}"
                            {{ old('hourly_rate_min', $jobListing->hourly_rate_min ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }}.00</option>
                    @endfor
                </select>
            </div>
            @error('hourly_rate_min')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="hourly_rate_max" class="block text-sm font-medium text-gray-700">Hourly Rate Max <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50"
                    id="hourly-currency-symbol">
                    {{ \App\Models\JobListing::CURRENCIES[old('currency', $jobListing->currency ?? 'USD')]['symbol'] }}
                </span>
                <select name="hourly_rate_max" id="hourly_rate_max"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-blue-500 focus:border-blue-500 rounded-r-md sm:text-sm">
                    <option value="">Select maximum rate</option>
                    @for ($i = 15; $i <= 200; $i += 5)
                        <option value="{{ $i }}"
                            {{ old('hourly_rate_max', $jobListing->hourly_rate_max ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }}.00</option>
                    @endfor
                </select>
            </div>
            @error('hourly_rate_max')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div id="annual_salary_fields" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4"
        style="display: none;">
        <div>
            <label for="salary_range_min" class="block text-sm font-medium text-gray-700">Salary Range Min <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50"
                    id="salary-currency-symbol">
                    {{ \App\Models\JobListing::CURRENCIES[old('currency', $jobListing->currency ?? 'USD')]['symbol'] }}
                </span>
                <select name="salary_range_min" id="salary_range_min"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-blue-500 focus:border-blue-500 rounded-r-md sm:text-sm">
                    <option value="">Select minimum salary</option>
                    @for ($i = 10000; $i <= 100000; $i += 10000)
                        <option value="{{ $i }}"
                            {{ old('salary_range_min', $jobListing->salary_range_min ?? '') == $i ? 'selected' : '' }}>
                            {{ number_format($i) }}</option>
                    @endfor
                </select>
            </div>
            @error('salary_range_min')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="salary_range_max" class="block text-sm font-medium text-gray-700">Salary Range Max <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50"
                    id="salary-currency-symbol">
                    {{ \App\Models\JobListing::CURRENCIES[old('currency', $jobListing->currency ?? 'USD')]['symbol'] }}
                </span>
                <select name="salary_range_max" id="salary_range_max"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-blue-500 focus:border-blue-500 rounded-r-md sm:text-sm">
                    <option value="">Select maximum salary</option>
                    @for ($i = 20000; $i <= 200000; $i += 10000)
                        <option value="{{ $i }}"
                            {{ old('salary_range_max', $jobListing->salary_range_max ?? '') == $i ? 'selected' : '' }}>
                            {{ number_format($i) }}</option>
                    @endfor
                </select>
            </div>
            @error('salary_range_max')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Application Type <span
                class="text-red-500">*</span></label>
        <div class="mt-2 space-y-2 sm:space-y-0 sm:flex sm:space-x-4">
            <div class="flex items-center">
                <input type="radio" id="application_type_link" name="application_type" value="link"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('application_type', $jobListing->application_type ?? '') == 'link' ? 'checked' : '' }}
                    required>
                <label for="application_type_link" class="ml-2 text-sm text-gray-600">External Link</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="application_type_email" name="application_type" value="email"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('application_type', $jobListing->application_type ?? '') == 'email' ? 'checked' : '' }}
                    required>
                <label for="application_type_email" class="ml-2 text-sm text-gray-600">Email</label>
            </div>
        </div>
        @error('application_type')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="application_link_container" style="display: none;">
        <label for="application_link" class="block text-sm font-medium text-gray-700">Application URL <span
                class="text-red-500">*</span></label>
        <input type="url" name="application_link" id="application_link"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('application_link') border-red-500 @enderror"
            value="{{ old('application_link', $jobListing->application_link ?? '') }}"
            placeholder="https://example.com/apply">
        @error('application_link')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="email_link_container" style="display: none;">
        <label for="email_link" class="block text-sm font-medium text-gray-700">Application Email <span
                class="text-red-500">*</span></label>
        <input type="email" name="email_link" id="email_link"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email_link') border-red-500 @enderror"
            value="{{ old('email_link', $jobListing->email_link ?? '') }}" placeholder="apply@example.com">
        @error('email_link')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-8">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
            {{ isset($jobListing) ? 'Update Job Listing' : 'Create Job Listing' }}
        </button>
    </div>
</div>


<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places">
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const remotePositionYes = document.getElementById('remote_position_yes');
        const remotePositionNo = document.getElementById('remote_position_no');
        const locationFields = document.getElementById('location_fields');

        function toggleLocationFields() {
            // Show location fields only if "No" is checked for remote position
            const isRemote = document.querySelector('input[name="remote_position"]:checked')?.value === '1';
            locationFields.classList.toggle('hidden', isRemote || !document.querySelector(
                'input[name="remote_position"]:checked'));
        }

        remotePositionYes?.addEventListener('change', toggleLocationFields);
        remotePositionNo?.addEventListener('change', toggleLocationFields);

        // Ensure fields are hidden by default
        toggleLocationFields();


        // Google Places Autocomplete
        const locationSearch = document.getElementById('location_search');
        if (!locationSearch) return;

        const autocomplete = new google.maps.places.Autocomplete(locationSearch, {
            types: ['establishment', 'geocode'], // Add 'establishment' to include businesses and farms
            fields: ['address_components', 'geometry', 'formatted_address', 'name']
        });

        autocomplete.addListener('place_changed', function() {
            const place = autocomplete.getPlace();

            if (!place.geometry) {
                console.log("No location data available");
                return;
            }

            // Clear all fields first
            const fields = ['street_address', 'city', 'state', 'country', 'postal_code', 'latitude',
                'longitude'
            ];
            fields.forEach(field => {
                document.getElementById(field).value = '';
            });

            // Set latitude and longitude
            document.getElementById('latitude').value = place.geometry.location.lat();
            document.getElementById('longitude').value = place.geometry.location.lng();

            // Update the search field with the formatted address
            document.getElementById('location_search').value = place.formatted_address;

            let addressComponents = {
                street_address: '',
                city: '',
                state: '',
                country: '',
                postal_code: ''
            };

            // Process address components for hidden fields
            for (const component of place.address_components) {
                const type = component.types[0];

                switch (type) {
                    case 'premise':
                    case 'street_number':
                    case 'route':
                    case 'establishment':
                        // Concatenate to build the street address
                        addressComponents.street_address +=
                            (addressComponents.street_address ? ' ' : '') + component.long_name;
                        break;
                    case 'postal_town':
                    case 'locality':
                    case 'sublocality':
                    case 'administrative_area_level_3':
                        if (!addressComponents.city) {
                            addressComponents.city = component.long_name;
                        }
                        break;
                    case 'administrative_area_level_1':
                        addressComponents.state = component.long_name;
                        break;
                    case 'country':
                        addressComponents.country = component.long_name;
                        break;
                    case 'postal_code':
                        addressComponents.postal_code = component.long_name;
                        break;
                }
            }

            // If no street address was found, use the name of the place
            if (!addressComponents.street_address && place.name) {
                addressComponents.street_address = place.name;
            }

            // Set the values in the form
            document.getElementById('street_address').value = addressComponents.street_address;
            document.getElementById('city').value = addressComponents.city;
            document.getElementById('state').value = addressComponents.state;
            document.getElementById('country').value = addressComponents.country;
            document.getElementById('postal_code').value = addressComponents.postal_code;
        });

        function resetAddressFields() {
            const fields = ['street_address', 'city', 'state', 'country', 'postal_code', 'latitude',
                'longitude'
            ];
            fields.forEach(field => {
                document.getElementById(field).value = '';
            });
            document.getElementById('display_full_address').value = '';
        }

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

    // Add this to your existing script section
    document.addEventListener('DOMContentLoaded', function() {
        const currencySelect = document.getElementById('currency');
        const hourlyCurrencySymbols = document.querySelectorAll('#hourly-currency-symbol');
        const salaryCurrencySymbols = document.querySelectorAll('#salary-currency-symbol');

        const currencies = @json(\App\Models\JobListing::CURRENCIES);

        currencySelect?.addEventListener('change', function() {
            const symbol = currencies[this.value].symbol;
            hourlyCurrencySymbols.forEach(span => span.textContent = symbol);
            salaryCurrencySymbols.forEach(span => span.textContent = symbol);
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const salaryTypeSelect = document.getElementById('salary_type');
        const currencySelector = document.getElementById('currency_selector');
        const currencySelect = document.getElementById('currency');
        const hourlyCurrencySymbols = document.querySelectorAll('#hourly-currency-symbol');
        const salaryCurrencySymbols = document.querySelectorAll('#salary-currency-symbol');
        const currencies = @json(\App\Models\JobListing::CURRENCIES);

        // Function to toggle currency selector visibility
        function toggleCurrencySelector() {
            const selectedValue = salaryTypeSelect.value;
            currencySelector.style.display = selectedValue ? 'block' : 'none';

            // Make currency field required only when salary type is selected
            currencySelect.required = !!selectedValue;
        }

        // Initial state
        toggleCurrencySelector();

        // Listen for changes on salary type
        salaryTypeSelect?.addEventListener('change', toggleCurrencySelector);

        // Update currency symbols when currency changes
        currencySelect?.addEventListener('change', function() {
            const symbol = currencies[this.value].symbol;
            hourlyCurrencySymbols.forEach(span => span.textContent = symbol);
            salaryCurrencySymbols.forEach(span => span.textContent = symbol);
        });
    });
</script>
