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
    <x-modal id="loginModal" maxWidth="lg">
        <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div
                    class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                    <x-heroicon-o-user class="w-6 h-6 text-blue-600" />
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Account Required
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Please create an account or log in to apply for this position. This helps us maintain
                            high-quality job applications and allows you to track your applications.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
            <a href="{{ route('register') }}?account_type=jobseeker"
                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                Create Account
            </a>
            <a href="{{ route('login') }}"
                class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:w-auto sm:text-sm">
                Log In
            </a>
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
