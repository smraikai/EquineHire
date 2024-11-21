<form action="{{ route('jobs.index') }}" method="GET" class="w-full max-w-4xl mx-auto" id="jobSearchForm">
    <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-gray-400" />
            </div>
            <input type="search" name="keyword" placeholder="Search for jobs..." value="{{ request('keyword') }}"
                class="w-full py-3 pl-10 pr-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="relative">
            <select name="country" id="countrySelect"
                class="w-full py-3 pl-2 pr-8 text-gray-700 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Countries</option>
                @foreach (\App\Models\JobListing::getUniqueCountries() as $country)
                    <option value="{{ $country }}" {{ request('country') == $country ? 'selected' : '' }}>
                        {{ $country }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<script>
    // Auto-detect user's country if no country is selected
    if (!document.getElementById('countrySelect').value) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(position => {
                const geocoder = new google.maps.Geocoder();
                const latlng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };

                geocoder.geocode({
                    location: latlng
                }, (results, status) => {
                    if (status === 'OK') {
                        if (results[0]) {
                            for (let component of results[0].address_components) {
                                if (component.types.includes('country')) {
                                    const userCountry = component.long_name;
                                    const select = document.getElementById('countrySelect');

                                    // Find and select the matching option
                                    for (let option of select.options) {
                                        if (option.text === userCountry) {
                                            option.selected = true;
                                            select.dispatchEvent(new Event('change'));
                                            break;
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                    }
                });
            });
        }
    }

    document.getElementById('countrySelect').addEventListener('change', function() {
        document.getElementById('jobSearchForm').submit();
    });
</script>

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places">
    </script>
@endpush
