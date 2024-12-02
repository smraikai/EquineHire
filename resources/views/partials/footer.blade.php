@inject('locationService', 'App\Services\LocationService')

<footer class="pt-20 pb-20 bg-gray-50">
    <div class="container px-4 mx-auto max-w-7xl">
        <div class="flex flex-wrap">
            <!-- Existing logo section -->
            <div class="w-full px-0 mb-8 lg:w-1/3 lg:mb-0">
                <div class="logo">
                    <a href="{{ route('home') }}" class="text-3xl text-gray-900 font-logo">
                        EquineHire
                    </a>
                </div>
                <div class="mt-4">
                    <p class="max-w-sm text-sm text-gray-500">
                        &copy; <?= date('Y') ?> EquineHire. Connecting passionate equestrians with incredible job
                        opportunities. Proudly built in Kentucky, serving the equine community.
                    </p>
                </div>
                <!-- Add Location Selector -->
                <div class="mt-4" x-data="locationSelector">
                    <div class="flex items-center space-x-2">
                        <button @click="open = !open"
                            class="flex items-center px-3 py-2 space-x-2 text-sm text-gray-600 bg-white border rounded-md hover:text-gray-900">
                            <span>{{ app(App\Services\LocationService::class)->getCountryFlag($locationService->getLocation()['country']) }}</span>
                            <span>{{ app(App\Services\LocationService::class)->getDisplayName() }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                    </div>
                    <!-- Dropdown -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute z-50 mt-2 bg-white rounded-md shadow-lg">
                        <div class="py-1 overflow-y-auto max-h-28">
                            @php
                                $countries = [
                                    'US' => 'United States',
                                    'GB' => 'United Kingdom',
                                    'CA' => 'Canada',
                                    'AT' => 'Austria',
                                    'BE' => 'Belgium',
                                    'BG' => 'Bulgaria',
                                    'HR' => 'Croatia',
                                    'CY' => 'Cyprus',
                                    'CZ' => 'Czech Republic',
                                    'DK' => 'Denmark',
                                    'EE' => 'Estonia',
                                    'FI' => 'Finland',
                                    'FR' => 'France',
                                    'DE' => 'Germany',
                                    'GR' => 'Greece',
                                    'HU' => 'Hungary',
                                    'IE' => 'Ireland',
                                    'IT' => 'Italy',
                                    'LV' => 'Latvia',
                                    'LT' => 'Lithuania',
                                    'LU' => 'Luxembourg',
                                    'MT' => 'Malta',
                                    'NL' => 'Netherlands',
                                    'PL' => 'Poland',
                                    'PT' => 'Portugal',
                                    'RO' => 'Romania',
                                    'SK' => 'Slovakia',
                                    'SI' => 'Slovenia',
                                    'ES' => 'Spain',
                                    'SE' => 'Sweden',
                                ];
                            @endphp

                            @foreach ($countries as $code => $name)
                                <button @click="setLocation('{{ $code }}')"
                                    class="flex items-center w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100">
                                    <span
                                        class="mr-2">{{ app(App\Services\LocationService::class)->getCountryFlag($code) }}</span>
                                    {{ $name }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Existing categories section -->
            <div class="w-full px-0 mb-8 lg:w-1/3 lg:mb-0">
                <h5 class="mb-2 font-bold text-gray-900">Explore Jobs</h5>
                <ul class="space-y-3 list-none footer-links">
                    @foreach (\App\Models\JobListingCategory::all() as $category)
                        <li>
                            <a href="{{ route('jobs.category', $category->slug) }}"
                                class="text-gray-600 hover:text-gray-900">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Existing company section -->
            <div class="w-full px-0 lg:w-1/3">
                <h5 class="mb-2 font-bold text-gray-900">Company</h5>
                <ul class="space-y-3 list-none footer-links">
                    <li><a href="/privacy-policy" class="text-gray-600 hover:text-gray-900">Privacy Policy</a></li>
                    <li><a href="/terms-of-service" class="text-gray-600 hover:text-gray-900">Terms of Service</a></li>
                    <li>
                        <script language="JavaScript">
                            var name = "help";
                            var domain = "equinehire.com";
                            document.write('<a href=\"mailto:' + name + '@' + domain + '\" class="text-gray-600 hover:text-gray-900">');
                            document.write('Contact</a>');
                        </script>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('locationSelector', () => ({
            open: false,

            async setLocation(country) {
                try {
                    const response = await fetch('{{ route('location.update') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            country
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        this.open = false;
                        window.location.reload();
                    }
                } catch (error) {
                    console.error('Error updating location:', error);
                }
            }
        }));
    });
</script>
