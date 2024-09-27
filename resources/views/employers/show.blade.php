@extends('layouts.site')

@section('content')
    <div class="relative">
        @if ($employer->featured_image)
            <div class="h-[300px] sm:h-[450px] w-full overflow-hidden">
                <img class="object-cover w-full h-full" src="{{ Storage::url($employer->featured_image) }}"
                    alt="{{ $employer->name }} featured image">
                <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
            </div>
        @else
            <div class="h-[300px] w-full bg-gray-100"></div>
        @endif
    </div>
    <div class="relative z-10 max-w-4xl px-4 py-4 mx-auto mb-20 -mt-20 bg-white rounded-lg sm:py-8 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                @if ($employer->logo)
                    <img class="w-16 h-16 mr-4 rounded-full" src="{{ Storage::url($employer->logo) }}"
                        alt="{{ $employer->name }} logo">
                @else
                    <div class="flex items-center justify-center w-16 h-16 mr-4 text-white bg-blue-500 rounded-full">
                        <span class="text-2xl font-semibold">{{ Str::upper(Str::substr($employer->name, 0, 2)) }}</span>
                    </div>
                @endif
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">{{ $employer->name }}</h1>
                    <p class="text-sm text-gray-500">{{ $employer->city }}, {{ $employer->state }}</p>
                    <a href="{{ $employer->website }}" target="_blank" class="text-blue-600 hover:underline">
                        {{ $employer->website }}
                    </a>
                </div>
            </div>
            <div class="text-right">
                <a href="#job-openings"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <span
                        class="mr-2 text-sm font-bold">{{ $employer->jobListings()->where('is_active', true)->count() }}</span>
                    <span>Job Opening(s)</span>
                </a>
            </div>
        </div>

        <hr class="mx-auto my-6">

        <div class="flex flex-col gap-6">
            <!-- Overview -->
            <div class="">
                <h2 class="mb-4 font-bold text-gray-500 text-md">About {{ $employer->name }}</h2>
                <div class="text-gray-800 listing-description">{!! $employer->description !!}</div>
            </div>
            <hr>

            <h2 id="job-openings" class="text-lg font-bold text-gray-800">Current Job Openings</h2>
            @forelse ($employer->jobListings()->where('is_active', true)->get() as $jobListing)
                @include('partials.jobs.list', ['job_listing' => $jobListing])
            @empty
                <p class="text-gray-600">No current job openings.</p>
            @endforelse
        </div>

    </div>
@endsection

@section('scripts')
    <script type="application/ld+json">
    {
        "@context": "http://schema.org",
        "@type": "Organization",
        "name": "{{ $employer->name }}",
        "url": "{{ $employer->website }}",
        "logo": "{{ $employer->logo_url }}",
        "address": {
            "@type": "PostalAddress",
            "addressLocality": "{{ $employer->city }}",
            "addressRegion": "{{ $employer->state }}",
            "addressCountry": "US"
        }
    }
    </script>
@endsection