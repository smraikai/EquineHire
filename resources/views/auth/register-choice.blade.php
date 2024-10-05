@extends('layouts.site')

@section('content')
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side: Registration choice -->
        <div class="flex items-center justify-center w-full px-4 py-8 md:w-1/2">
            <div class="w-full max-w-xl">
                <div class="mb-8">
                    <h1 class="mb-6 text-3xl font-bold md:text-4xl fancy-title">
                        Choose Your Account Type
                    </h1>
                    <p class="text-gray-600">
                        Select the account type that best fits your needs in the equine industry.
                    </p>
                </div>

                <div class="grid grid-cols-1 gap-6 mt-8">
                    <!-- Employer Card -->
                    <a href="{{ route('register.employer') }}"
                        class="block p-6 transition duration-300 ease-in-out bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg hover:-translate-y-1">
                        <h2 class="mb-2 text-xl font-semibold text-gray-900">For Employers</h2>
                        <p class="mb-4 text-gray-600">Find top equine talent for your business.</p>
                        <ul class="mb-6 space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                @svg('heroicon-o-check', 'w-4 h-4 mr-2 text-blue-600')
                                Post job listings
                            </li>
                            <li class="flex items-center">
                                @svg('heroicon-o-check', 'w-4 h-4 mr-2 text-blue-600')
                                Access qualified candidates
                            </li>
                            <li class="flex items-center">
                                @svg('heroicon-o-check', 'w-4 h-4 mr-2 text-blue-600')
                                Manage applications
                            </li>
                        </ul>
                        <div
                            class="w-full px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Sign Up as Employer
                        </div>
                    </a>

                    <!-- Job Seeker Card -->
                    <a href="{{ route('register.job_seeker') }}"
                        class="block p-6 transition duration-300 ease-in-out bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg hover:-translate-y-1">
                        <h2 class="mb-2 text-xl font-semibold text-gray-900">For Job Seekers</h2>
                        <p class="mb-4 text-gray-600">Discover your next career opportunity.</p>
                        <ul class="mb-6 space-y-2 text-sm text-gray-600">
                            <li class="flex items-center">
                                @svg('heroicon-o-check', 'w-4 h-4 mr-2 text-blue-600')
                                Browse job listings
                            </li>
                            <li class="flex items-center">
                                @svg('heroicon-o-check', 'w-4 h-4 mr-2 text-blue-600')
                                Create a professional profile
                            </li>
                            <li class="flex items-center">
                                @svg('heroicon-o-check', 'w-4 h-4 mr-2 text-blue-600')
                                Apply to jobs easily
                            </li>
                        </ul>
                        <div
                            class="w-full px-4 py-2 text-sm font-medium text-center text-white bg-blue-600 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Sign Up as Job Seeker
                        </div>
                    </a>
                </div>

                <div class="mt-8 text-center">
                    <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                        {{ __('Already have an account? Log in') }}
                    </a>
                </div>
            </div>
        </div>

        <!-- Right side: Full-size image (hidden on mobile) -->
        <div class="relative hidden w-1/2 md:block">
            <img src="https://equinehire-static-assets.s3.amazonaws.com/horse-barn-bw-min.jpg"
                alt="Registration Choice Image" class="object-cover w-full h-full max-h-screen">
            <div class="absolute inset-0 bg-gradient-to-br from-black/70 to-transparent"></div>
        </div>
    </div>
@endsection
