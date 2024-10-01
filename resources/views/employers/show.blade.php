@extends('layouts.site')

@section('content')
    <div class="relative">
        @if ($employer->featured_image)
            <div class="h-[200px] sm:h-[300px] md:h-[450px] w-full overflow-hidden">
                <img class="object-cover w-full h-full" src="{{ Storage::url($employer->featured_image) }}"
                    alt="{{ $employer->name }} featured image">
                <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
            </div>
        @else
            <div class="h-[200px] sm:h-[300px] md:h-[450px] w-full overflow-hidden">
                <img class="object-cover w-full h-full"
                    src="https://equinehire-static-assets.s3.amazonaws.com/placeholder.jpg"
                    alt="{{ $employer->name }} placeholder image">
                <div class="absolute inset-0 bg-gray-900 opacity-50"></div>
            </div>
        @endif
    </div>
    <div
        class="relative z-10 max-w-4xl px-4 py-4 mx-auto mb-20 -mt-16 bg-white rounded-lg sm:-mt-20 sm:py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex flex-col items-center mb-4 sm:mb-0 sm:flex-row sm:items-start">
                @if ($employer->logo)
                    <img class="w-16 h-16 mb-4 rounded-full sm:w-16 sm:h-16 sm:mb-0 sm:mr-4"
                        src="{{ Storage::url($employer->logo) }}" alt="{{ $employer->name }} logo">
                @else
                    <div
                        class="flex items-center justify-center w-16 h-16 mb-4 text-white bg-blue-500 rounded-full sm:w-16 sm:h-16 sm:mb-0 sm:mr-4">
                        <span class="text-2xl font-semibold">{{ Str::upper(Str::substr($employer->name, 0, 2)) }}</span>
                    </div>
                @endif
                <div class="text-center sm:text-left">
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ $employer->name }}</h1>
                    @if ($employer->city || $employer->state)
                        <p class="text-sm text-gray-500">
                            {{ $employer->city }}{{ $employer->city && $employer->state ? ', ' : '' }}{{ $employer->state }}
                        </p>
                    @endif
                    <a href="{{ $employer->website }}" target="_blank"
                        class="text-sm text-blue-600 break-all hover:underline">
                        {{ $employer->website }}
                    </a>
                </div>
            </div>
            <div class="mt-4 text-center sm:mt-0 sm:text-right">
                <a href="#job-openings"
                    class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 whitespace-nowrap">
                    @php
                        $jobCount = $employer->jobListings()->where('is_active', true)->count();
                    @endphp
                    <span class="mr-2 text-sm font-bold">{{ $jobCount }}</span>
                    <span>Job {{ $jobCount === 1 ? 'Opening' : 'Openings' }}</span>
                </a>
            </div>
        </div>

        <hr class="mx-auto my-6">

        <div class="flex flex-col gap-6">
            <!-- Overview -->
            <div class="">
                <h2 class="mb-4 font-bold text-gray-500 text-md">About {{ $employer->name }}</h2>
                <div class="text-gray-800 listing-description">
                    @if (trim($employer->description))
                        {!! $employer->description !!}
                    @else
                        <p>No description available for this employer.</p>
                    @endif
                </div>
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
@endsection
