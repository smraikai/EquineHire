@extends('layouts.site')
@section('scripts_css')
@endsection

@section('content')
    <div class="container max-w-full px-4 py-2 pb-6 mx-auto sm:px-6 sm:pb-10 sm:max-w-6xl">
        <div class="mt-4">
            <div class="mt-4">
                <a href="{{ route('jobs.index') . '?' . request()->getQueryString() }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    <x-heroicon-o-arrow-left class="w-5 h-5 mr-2 -ml-1 text-gray-500" />
                    All Jobs
                </a>
            </div>
        </div>
        <div class="flex flex-wrap gap-8 py-8">
            <!-- Overview -->
            <div class="flex flex-col flex-1 gap-5">
                <div class="flex flex-col w-full">
                    <div class="flex flex-col items-center gap-3 sm:flex-row">
                        <div class="flex flex-col gap-2 text-center sm:text-left">
                            <h1 class="text-3xl font-semibold text-gray-900 sm:text-4xl fancy-title">{!! $job_listing->title !!}
                            </h1>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="mb-2 font-bold text-gray-500 text-md">Job Description</h2>
                    <div class="text-gray-800 listing-description">{!! $job_listing->description !!}</div>
                </div>

                <!-- Apply Now Button (Full Width) -->
                <a href="{{ $job_listing->application_link ?? '#' }}"
                    class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Apply Now
                </a>

            </div>

            <!-- Job Details & Employer Information -->
            <div class="sticky flex flex-col self-start gap-5 top-5 md:w-1/3">
                <!-- Job Details Section -->
                <div class="flex flex-col gap-5 p-6 border rounded-md">
                    <!-- Employer Logo and Name -->
                    <div class="flex flex-col items-center gap-1">
                        @if ($job_listing->employer->logo)
                            <img src="{{ Storage::url($job_listing->employer->logo) }}" alt="Employer Logo"
                                class="w-16 h-16 rounded-full">
                        @endif
                        <h3 class="text-xl font-semibold text-center">
                            {{ $job_listing->employer->name }}
                        </h3>
                        <div class="text-center">
                            @if ($job_listing->employer->city && $job_listing->employer->state)
                                <p>{{ $job_listing->employer->city }}, {{ $job_listing->employer->state }}</p>
                            @endif
                        </div>
                        <a class="text-xs text-gray-500" href="{{ route('employers.show', $job_listing->employer) }}">View
                            Profile</a>
                    </div>
                    <hr>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-map class="flex-none w-5 h-5 text-gray-600" />
                            <span>
                                @if ($job_listing->remote_position)
                                    Remote
                                @else
                                    {{ $job_listing->city }}, {{ $job_listing->state }}
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-chart-bar class="flex-none w-5 h-5 text-gray-600" />
                            <span>{{ $job_listing->experience_required }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-clock class="flex-none w-5 h-5 text-gray-600" />
                            <span>{{ Str::title($job_listing->job_type) }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-credit-card class="flex-none w-5 h-5 text-gray-600" />
                            <span>
                                @if ($job_listing->salary_type === 'hourly')
                                    ${{ $job_listing->hourly_rate_min }} - ${{ $job_listing->hourly_rate_max }} / hour
                                @else
                                    ${{ number_format($job_listing->salary_range_min) }} -
                                    ${{ number_format($job_listing->salary_range_max) }} / year
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-calendar class="flex-none w-5 h-5 text-gray-600" />
                            <span>Posted on {{ $job_listing->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    <!-- Apply Now Button -->
                    <a href="{{ $job_listing->application_link ?? '#' }}"
                        class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Apply Now
                    </a>
                </div>

            </div>


        </div>
    </div>
@endsection

@section('scripts')
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "JobPosting",
        "title": "{{ $job_listing->title }}",
        "description": "{{ $job_listing->description }}",
        "datePosted": "{{ $job_listing->created_at->toIso8601String() }}",
        "validThrough": "{{ $job_listing->created_at->addDays(30)->toIso8601String() }}",
        "employmentType": "{{ $job_listing->job_type }}",
        "hiringOrganization": {
            "@type": "Organization",
            "name": "{{ $job_listing->employer->name }}"
        },
        "jobLocation": {
            "@type": "Place",
            "address": {
                "@type": "PostalAddress",
                "addressLocality": "{{ $job_listing->city }}",
                "addressRegion": "{{ $job_listing->state }}",
                "addressCountry": "US"
            }
        },
        "baseSalary": {
            "@type": "MonetaryAmount",
            "currency": "USD",
            "value": {
                "@type": "QuantitativeValue",
                @if($job_listing->salary_type === 'hourly')
                "minValue": {{ $job_listing->hourly_rate_min }},
                "maxValue": {{ $job_listing->hourly_rate_max }},
                "unitText": "HOUR"
                @else
                "minValue": {{ $job_listing->salary_range_min }},
                "maxValue": {{ $job_listing->salary_range_max }},
                "unitText": "YEAR"
                @endif
            }
        },
        "experienceRequirements": "{{ $job_listing->experience_required }}",
        "jobLocationType": "{{ $job_listing->remote_position ? 'TELECOMMUTE' : 'ONSITE' }}",
        "applicantLocationRequirements": {
            "@type": "Country",
            "name": "United States"
        },
        "industry": "{{ $job_listing->category->name }}"
    }
    </script>
@endsection
