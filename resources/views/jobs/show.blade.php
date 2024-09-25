@extends('layouts.site')
@section('scripts_css')
@endsection

@section('content')
    <div class="container max-w-full px-4 pb-6 mx-auto sm:px-6 sm:pb-10 sm:max-w-7xl">
        <div class="flex flex-wrap gap-8 py-20">
            <!-- Overview -->
            <div class="flex flex-col flex-1 gap-5">
                <div class="flex flex-col w-full py-8 space-y-4 sm:py-8">
                    <div class="flex flex-col items-center gap-3 sm:flex-row">
                        <div class="flex flex-col gap-2 text-center sm:text-left">
                            <h1 class="text-3xl font-semibold text-gray-900 sm:text-4xl fancy-title">{!! $job_listing->title !!}
                            </h1>
                        </div>
                    </div>
                    <!-- Edit Button if Owner is Viewing Listing -->
                    @if ($isOwner)
                        <div class="flex justify-center sm:justify-start">
                            <a href="{{ route('employer.edit', $job_listing->id) }}"
                                class="px-4 py-2 font-bold bg-gray-200 rounded hover:bg-gray-300">
                                Edit My Listing
                            </a>
                        </div>
                    @endif
                </div>
                <h2 class="font-bold text-gray-800 text-md">Job Overview</h2>
                <div class="text-gray-800 listing-description">{!! $job_listing->description !!}</div>

                <!-- Apply Now Button (Full Width) -->
                <a href="{{ $job_listing->application_link ?? '#' }}"
                    class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                    Apply Now
                </a>

            </div>

            <!-- Employer Details & Job Information -->
            <div class="sticky flex flex-col self-start gap-5 top-5 md:w-1/3">
                <div class="flex flex-col gap-5 p-6 border rounded-md">
                    <!-- Employer Logo and Name -->
                    <div class="flex items-center gap-4">
                        @if ($job_listing->employer->logo)
                            <img src="{{ $job_listing->employer->logo }}" alt="Employer Logo"
                                class="w-16 h-16 rounded-full">
                        @endif
                        <h3 class="text-xl font-semibold">{{ $job_listing->employer->name }}</h3>
                    </div>

                    <!-- Job Details -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <x-coolicon-map class="flex-none w-5 h-5 text-gray-600" />
                            <span>{{ $job_listing->city }}, {{ $job_listing->state }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-coolicon-chart-bar-vertical-01 class="flex-none w-5 h-5 text-gray-600" />
                            <span>{{ $job_listing->experience_required }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-coolicon-clock class="flex-none w-5 h-5 text-gray-600" />
                            <span>{{ $job_listing->job_type }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <x-coolicon-credit-card-01 class="flex-none w-5 h-5 text-gray-600" />
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
                            <x-coolicon-calendar class="flex-none w-5 h-5 text-gray-600" />
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

    @include('partials.business-success-bar')
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
