@extends('layouts.site')

@php
    $applyLink = $job_listing->application_link;

    // Add UTM parameters to the apply link
    if ($applyLink) {
        $utmParams = http_build_query([
            'utm_source' => 'equinehire',
            'utm_medium' => 'job_listing',
            'utm_campaign' => 'job_application',
        ]);

        $applyLink .= (parse_url($applyLink, PHP_URL_QUERY) ? '&' : '?') . $utmParams;
    }
@endphp

@section('content')
    <div class="container max-w-full px-4 py-2 pb-6 mx-auto sm:px-6 sm:pb-10 sm:max-w-6xl">
        <div class="mt-4">
            <div class="mt-4">
                <a href="{{ route('jobs.index') . '?' . request()->getQueryString() }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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
                @if (auth()->check())
                    <a href="{{ $applyLink ?? route('job-applications.create', $job_listing) }}"
                        class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Apply Now
                    </a>
                @else
                    <button type="button" onclick="showLoginModal()"
                        class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Apply Now
                    </button>
                @endif

            </div>

            <!-- Job Details & Employer Information -->
            <div class="sticky flex flex-col self-start w-full gap-5 top-5 sm:w-1/3">
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
                                    @if ($job_listing->city || $job_listing->state || $job_listing->country)
                                        {{ collect([
                                            $job_listing->city,
                                            // Only show state if it's different from the city
                                            $job_listing->state !== $job_listing->city ? $job_listing->state : null,
                                            $job_listing->country,
                                        ])->filter()->join(', ') }}
                                    @else
                                        Location not specified
                                    @endif
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
                        @if ($job_listing->salary_type)
                            <div class="flex items-center gap-3">
                                <x-heroicon-o-credit-card class="flex-none w-5 h-5 text-gray-600" />
                                <span>
                                    @if ($job_listing->salary_type === 'hourly')
                                        {{ App\Models\JobListing::CURRENCIES[$job_listing->currency ?? 'USD']['symbol'] }}{{ number_format($job_listing->hourly_rate_min, 0) }}
                                        -
                                        {{ App\Models\JobListing::CURRENCIES[$job_listing->currency ?? 'USD']['symbol'] }}{{ number_format($job_listing->hourly_rate_max, 0) }}
                                        / hour
                                    @elseif ($job_listing->salary_type === 'salary')
                                        {{ App\Models\JobListing::CURRENCIES[$job_listing->currency ?? 'USD']['symbol'] }}{{ number_format($job_listing->salary_range_min, 0) }}
                                        -
                                        {{ App\Models\JobListing::CURRENCIES[$job_listing->currency ?? 'USD']['symbol'] }}{{ number_format($job_listing->salary_range_max, 0) }}
                                        / year
                                    @endif
                                </span>
                            </div>
                        @endif
                        <div class="flex items-center gap-3">
                            <x-heroicon-o-calendar class="flex-none w-5 h-5 text-gray-600" />
                            <span>Posted on {{ $job_listing->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>

                    <!-- Apply Now Button -->
                    @if (auth()->check())
                        <a href="{{ $applyLink ?? route('job-applications.create', $job_listing) }}"
                            class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Apply Now
                        </a>
                    @else
                        <button type="button" onclick="showLoginModal()"
                            class="w-full px-4 py-2 text-center text-white bg-blue-600 rounded-md hover:bg-blue-700">
                            Apply Now
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Login Required Modal -->
    <x-modal id="loginModal" maxWidth="4xl">
        <div class="relative bg-white">
            <!-- Close button -->
            <button type="button" onclick="showLoginModal()"
                class="absolute right-4 top-4 z-10 text-white hover:text-gray-200 focus:outline-none">
                <span class="sr-only">Close</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div class="flex flex-col sm:flex-row">
                <!-- Left side - Image -->
                <div class="w-full sm:w-1/2 bg-blue-600 relative overflow-hidden">
                    <img src="https://equinehire.s3.amazonaws.com/eqh-old/equine-hire-c.webp" alt="Equine Hire Community"
                        class="absolute inset-0 w-full h-full object-cover">
                </div>

                <!-- Right side - Content -->
                <div class="w-full sm:w-1/2 p-8">
                    <div class="max-w-sm mx-auto">
                        <h3 class="text-2xl font-semibold text-gray-900">Create Your Free Account</h3>
                        <p class="mt-3 text-sm text-gray-600">Get started with these features:</p>

                        <ul class="mt-8 space-y-6">
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-medium text-gray-900">Apply to Jobs</p>
                                    <p class="mt-1 text-sm text-gray-500">Submit applications to top equine positions</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-medium text-gray-900">Track Your Applications</p>
                                    <p class="mt-1 text-sm text-gray-500">Keep track of all jobs you've applied to</p>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-7 w-7 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-base font-medium text-gray-900">Upload Your Resume</p>
                                    <p class="mt-1 text-sm text-gray-500">Store and manage your professional resume</p>
                                </div>
                            </li>
                        </ul>

                        <div class="mt-10 space-y-4">
                            <a href="{{ route('register') }}?account_type=jobseeker"
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Create Free Account
                            </a>
                            <a href="{{ route('login') }}"
                                class="w-full inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Sign In
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-modal>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Job listing page loaded');

            function showLoginModal() {
                console.log('Showing login modal');
                const modal = document.getElementById('loginModal');
                if (modal) {
                    modal.classList.remove('hidden');
                } else {
                    console.error('Login modal element not found');
                }
            }

            // Make showLoginModal available globally
            window.showLoginModal = showLoginModal;

            // Close modal when clicking outside
            const modal = document.getElementById('loginModal');
            if (modal) {
                modal.addEventListener('click', function(e) {
                    if (e.target === this) {
                        this.classList.add('hidden');
                    }
                });
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modal = document.getElementById('loginModal');
                    if (modal) {
                        modal.classList.add('hidden');
                    }
                }
            });
        });
    </script>
@endpush
