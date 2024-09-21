@extends('layouts.app')
@section('scripts_css')
@endsection

@section('content')
    <div class="container max-w-full px-4 pb-6 mx-auto sm:px-6 sm:pb-10 sm:max-w-7xl">

        <div class="flex flex-row mx-auto max-h-[460px] overflow-hidden rounded-md mt-8">

            <!-- Featured Image -->
            <div
                class="relative flex-shrink-0 w-full {{ $business->photos->isEmpty() ? 'sm:w-full' : 'sm:w-4/5' }} min-h-[200px] sm:min-h-[300px]">
                @if ($business->featured_image)
                    <img src="{{ $business->featured_image }}" alt="Featured Image"
                        class="object-cover object-center w-full h-full">
                @else
                    <div class="flex items-center justify-center w-full h-full bg-gray-100">
                        <img src="https://EquineHire-static-assets.s3.amazonaws.com/equine_pro_finder_placeholder.jpg"
                            alt="Placeholder Image" class="object-cover object-center w-full h-full">
                    </div>
                @endif
            </div>

            @if ($business->photos->count() > 0)
                <div class="relative flex-col justify-between flex-grow flex-shrink ml-1" x-data="{ showModal: false }"
                    x-init="$watch('showModal', value => document.body.style.overflow = value ? 'hidden' : '')" @keydown.escape="showModal = false">

                    @if ($business->photos->isNotEmpty())
                        <button @click="showModal = true"
                            class="absolute flex items-center justify-center px-2 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm bottom-2 right-3 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:hidden whitespace-nowrap">
                            <x-coolicon-more-grid-small class="flex-shrink-0 w-4 h-4 mr-2" />
                            <span>View Gallery</span>
                        </button>
                    @endif

                    <!-- Gallery, showing only 3 images -->
                    <!-- Thumbnails for the gallery -->
                    <div class="flex-1 h-full space-y-1 overflow-hidden">
                        @foreach ($business->photos->take(3) as $index => $photo)
                            <div
                                class="w-full {{ $business->photos->count() === 1 ? 'h-full' : ($business->photos->count() === 2 ? 'h-1/2' : 'h-1/3') }}">
                                <a href="#"
                                    @click.prevent="showModal = true; openModalAndScroll({{ $index }})">
                                    <img src="{{ $photo->path }}" alt="Gallery Image"
                                        class="object-cover object-center w-full h-full orientation-fix">

                                </a>
                            </div>
                        @endforeach
                    </div>

                    <!-- View Gallery Button -->
                    @if ($business->photos->isNotEmpty())
                        <button @click="showModal = true"
                            class="absolute bottom-2 right-2 rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50  items-center hidden sm:flex">
                            <x-coolicon-more-grid-small class="w-4 h-4 mr-2" />
                            View Gallery
                        </button>
                    @endif

                    <!-- Modal Popup -->
                    <div x-show="showModal" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform translate-y-full"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-200"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform translate-y-full"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-white">
                        <div class="w-full h-full overflow-auto">

                            <!-- Back to Listing Bar -->
                            <div class="fixed top-0 left-0 right-0 z-50 flex items-center p-4 bg-gray-100 shadow-lg">
                                <button @click="showModal = false"
                                    class="flex items-center text-sm text-gray-800 hover:opacity-70">
                                    <x-coolicon-arrow-circle-left class="w-6 h-6 mr-2" />
                                    Back to Listing
                                </button>
                            </div>

                            <!-- Images Container -->
                            <div class="max-w-screen-lg px-5 pb-5 mx-auto">
                                <div class="flex flex-col gap-4 p-10">
                                    @foreach ($business->photos as $index => $photo)
                                        <div x-ref="galleryPhoto{{ $index + 1 }}">
                                            <img src="{{ $photo->path }}" alt="Image" class="w-full">
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="flex flex-col w-full py-8 space-y-4 sm:py-8">
            <div class="flex flex-col items-center gap-3 sm:flex-row">
                <!-- Business Logo -->
                @if ($business->logo)
                    <div>
                        <img src="{{ $business->logo }}" alt="Logo"
                            class="object-cover object-center w-24 h-24 border rounded-full">
                    </div>
                @endif
                <div class="flex flex-col gap-2 text-center sm:text-left">
                    <!-- Main title -->
                    <h1 class="text-3xl font-semibold text-gray-900 sm:text-4xl fancy-title">{!! $business->name !!}</h1>
                    <!-- City and State -->
                    <p class="text-sm text-blue-800 fancy-subtitle">{!! $business->city !!}, {!! $business->state !!}</p>
                </div>
            </div>
            <!-- Buttons on a new row -->
            <div class="flex justify-center sm:justify-start">
                <!-- Edit Button if Owner is Viewing Listing -->
                @if ($isOwner)
                    <a href="{{ route('businesses.edit', $business->id) }}"
                        class="px-4 py-2 font-bold bg-gray-200 rounded hover:bg-gray-300">
                        Edit My Listing
                    </a>
                @endif
            </div>
        </div>


        <div class="flex flex-wrap gap-8">
            <!-- Overview -->
            <div class="flex flex-col flex-1 gap-5">
                <h2 class="font-bold text-gray-800 text-md">Overview</h2>
                <div class="text-gray-800 listing-description">{!! $business->description !!}</div>
                <!-- Categories -->
                <div class="flex flex-col gap-5 p-8 border rounded-md">
                    <div class="flex flex-row items-center gap-3">
                        <x-coolicon-tag class="w-5 h-5" />
                        <div class="font-semibold text-md">Categories</div>
                    </div>
                    <!-- Categories as horizontal tags -->
                    <div class="flex items-center justify-start">
                        <div id="categoryContainer" class="flex flex-wrap gap-2 pt-1">
                            @foreach ($business->categories as $key => $category)
                                <span
                                    class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $category->name }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Disciplines -->
                @if ($business->disciplines && $business->disciplines->isNotEmpty())
                    <div class="flex flex-col gap-5 p-8 border rounded-md">
                        <div class="flex flex-row items-center gap-3">
                            <x-coolicon-wavy-check class="w-5 h-5" />
                            <div class="font-semibold text-md">Disciplines</div>
                        </div>
                        <!-- Disciplines as horizontal tags -->
                        <div class="flex items-center justify-start">
                            <div id="categoryContainer" class="flex flex-wrap gap-2 pt-1">
                                @foreach ($business->disciplines as $key => $discipline)
                                    <span
                                        class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">{{ $discipline->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Location & Details -->
            <div class="sticky flex flex-col self-start gap-5 top-5 md:w-1/3">
                <div class="flex flex-col gap-5 p-6 border rounded-md">
                    <div class="font-bold text-md">Location</div>
                    <div id="map" class="w-full bg-gray-200 rounded-md h-96"></div>
                    <div class="space-y-4">
                        @if ($business->address)
                            <div class="flex items-center gap-3">
                                <x-coolicon-map class="flex-none w-5 h-5 text-gray-600" />
                                <span>{{ $business->address }}, {{ $business->city }}, {{ $business->state }}
                                    {{ $business->zip_code }}</span>
                            </div>
                        @endif
                        @if ($business->website)
                            <div class="flex items-center gap-3">
                                <x-coolicon-link class="flex-none w-5 h-5 text-gray-600" />
                                <a href="{{ $business->website }}" target="\_blank"
                                    class="text-blue-600 hover:underline">{{ $business->website }}</a>
                            </div>
                        @endif

                        @if ($business->email)
                            <div class="flex items-center gap-3">
                                <x-coolicon-mail class="flex-none w-5 h-5 text-gray-600" />
                                <a href="mailto:{{ $business->email }}"
                                    class="text-blue-600 hover:underline">{{ $business->email }}</a>
                            </div>
                        @endif

                        @if ($business->phone)
                            <div class="flex items-center gap-3">
                                <x-coolicon-phone class="flex-none w-5 h-5 text-gray-600" /> {{ $business->phone }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>


        </div>

    </div>

    @include('partials.business-success-bar')
@endsection

@section('scripts')
    <script>
        function openModalAndScroll(photoIndex) {
            setTimeout(() => {
                const photoElement = document.querySelector(`[x-ref="galleryPhoto${photoIndex + 1}"]`);
                if (photoElement) {
                    const scrollPosition = photoElement.offsetTop - 150;
                    photoElement.scrollIntoView({
                        top: scrollPosition,
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }, 100);
        }
    </script>
    <script>
        async function initMap() {
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary('marker');

            var address =
                "{{ $business->address }}, {{ $business->city }}, {{ $business->state }} {{ $business->zip_code }}";
            var geocoder = new google.maps.Geocoder();

            geocoder.geocode({
                address: address
            }, function(results, status) {
                if (status === 'OK') {
                    var mapOptions = {
                        center: results[0].geometry.location,
                        zoom: 14,
                        mapId: "DEMO_MAP_ID" // Ensure this map ID is set up in your Google Cloud Console
                    };

                    var map = new google.maps.Map(document.getElementById('map'), mapOptions);
                    var marker = new AdvancedMarkerElement({
                        position: results[0].geometry.location,
                        map: map,
                        title: 'Your Business Location'
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

        window.addEventListener('load', initMap);
    </script>

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "{{ $business->name }}",
        "image": "{{ $business->logo }}",
        "description": "{{ $business->description }}",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "{{ $business->address }}",
            "addressLocality": "{{ $business->city }}",
            "addressRegion": "{{ $business->state }}",
            "postalCode": "{{ $business->zip_code }}",
            "addressCountry": "US"
        },
        "telephone": "{{ $business->phone }}",
        "url": "{{ route('jobs.index.show', ['state_slug' => $business->state_slug, 'slug' => $business->slug, 'id' => $business->id]) }}",
        "hasMap": "{{ $business->google_maps_url }}",
        "sameAs": [
            "{{ $business->facebook_url }}",
            "{{ $business->instagram_url }}"
        ],
        "serviceArea": {
            "@type": "GeoCircle",
            "geoMidpoint": {
            "@type": "GeoCoordinates",
            "latitude": {{ $business->latitude }},
            "longitude": {{ $business->longitude }}
            },
            "geoRadius": "50000"
        }
        }
    </script>
@endsection
