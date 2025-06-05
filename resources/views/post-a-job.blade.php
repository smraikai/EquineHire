@extends('layouts.landing')

@section('content')
    <!-- Hero Section with Image -->
    <section class="relative overflow-hidden bg-blue-950">
        <!-- Transparent Navigation -->
        <nav class="absolute top-0 left-0 z-20 w-full bg-transparent">
            <div class="w-full px-4 py-3 mx-auto lg:px-6">
                <div class="flex items-center justify-between h-12 sm:h-16">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-2xl text-white sm:text-3xl font-logo">
                            EquineHire
                        </a>
                    </div>
                    <!-- Buttons -->
                    <div class="flex items-center space-x-2 sm:space-x-4">
                        <a href="{{ route('jobs.index') }}"
                            class="items-center hidden px-4 py-2 text-sm font-semibold tracking-widest text-center text-white border border-white rounded-md sm:inline-flex hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Looking for a job?
                        </a>
                        <a href="https://equinehire.test/register"
                            class="inline-flex items-center px-3 py-2 text-xs font-semibold tracking-widest text-center text-blue-600 bg-white border border-transparent rounded-md sm:text-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                            Post a Job
                        </a>
                    </div>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-7xl">
            <div class="pb-0 lg:max-w-2xl lg:w-full">
                <main class="px-4 pt-16 mx-auto sm:pt-20 max-w-7xl sm:px-6 md:pt-28 lg:pt-32 lg:px-8 xl:pt-40">
                    <div class="text-center lg:text-left">
                        <div class="text-xs font-black tracking-widest text-blue-100 uppercase sm:text-sm">
                            The Best Way to Hire Equine Professionals
                        </div>
                        <h1
                            class="mt-2 text-3xl font-extrabold tracking-tight text-white sm:mt-4 sm:text-4xl md:text-5xl lg:text-6xl fancy-title text-balance">
                            <span class="">Find </span>
                            <span class="text-emerald-500 ">Qualified Equine Talent</span>
                            <span class="block sm:inline">Without the Hassle</span>
                        </h1>
                        <p
                            class="mt-3 text-sm text-blue-100 sm:mt-5 sm:text-lg sm:max-w-xl text-balance sm:mx-auto md:mt-5 md:text-xl lg:mx-0">
                            Stop wasting time on generic job boards. EquineHire connects you directly with experienced horse
                            professionals who understand your industry.
                        </p>
                        <div class="mt-5 space-y-3 sm:mt-8 sm:space-y-0 sm:flex sm:justify-center lg:justify-start">
                            <div class="rounded-md shadow">
                                <a href="https://equinehire.test/register"
                                    class="flex items-center justify-center w-full px-6 py-3 text-sm font-medium text-blue-600 bg-white border border-transparent rounded-md sm:px-8 sm:text-base hover:bg-gray-50 md:py-4 md:text-lg md:px-10">
                                    Post a Job
                                </a>
                            </div>
                            <div class="sm:ml-3">
                                <a href="#pricing"
                                    class="flex items-center justify-center w-full px-6 py-3 text-sm font-medium text-white bg-transparent border border-white rounded-md sm:px-8 sm:text-base hover:border-blue-700 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                    View Pricing Plans
                                </a>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <div class="hidden lg:block lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
            <img class="object-cover w-full h-full" src="{{ asset('images/barn-manager.jpeg') }}"
                alt="Professional equine trainer working with horse">
        </div>
    </section>

    @include('partials.sections.trust')

    <!-- The Value You Get Section -->
    <section class="py-12 sm:py-16 md:py-20 lg:py-24">
        <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col gap-5 text-center">
                <h2 class="text-2xl sm:text-3xl md:text-4xl fancy-title">What You Get With EquineHire</h2>
                <x-divider class="mx-auto" />
                <p class="max-w-2xl mx-auto text-base text-gray-600 sm:text-lg md:text-xl">
                    More than just a job board - a complete hiring solution designed specifically for the equine industry
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6 mt-8 sm:gap-8 sm:mt-12 md:mt-16 sm:grid-cols-2 lg:grid-cols-3">
                <!-- Equine-Specific Targeting -->
                <div class="p-8 text-center bg-white border rounded-lg shadow-lg">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                            <x-heroicon-o-megaphone class="w-8 h-8 text-blue-600" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-bold">Equine-Specific Targeting</h3>
                    <p class="text-gray-600">Unlike broad job sites, we reach equine job seekers specifically, ensuring more
                        relevant applicants.</p>
                </div>

                <!-- SEO Optimized -->
                <div class="p-8 text-center bg-white border rounded-lg shadow-lg">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                            <x-heroicon-o-magnifying-glass class="w-8 h-8 text-blue-600" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-bold">Optimized for Search Engines</h3>
                    <p class="text-gray-600">Our job listings are optimized for search engines like Google. When people
                        search for jobs in your area, your listing on EquineHire will appear in results, maximizing
                        visibility.</p>
                </div>

                <!-- Social Promotion -->
                <div class="p-8 text-center bg-white border rounded-lg shadow-lg">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                            <x-heroicon-o-share class="w-8 h-8 text-blue-600" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-bold">Social Media Boost</h3>
                    <p class="text-gray-600">We share your jobs on relevant Facebook groups, acting like a social media
                        manager to help find the right candidates.</p>
                </div>

                <!-- US-Focused -->
                <div class="p-8 text-center bg-white border rounded-lg shadow-lg">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                            <x-heroicon-o-flag class="w-8 h-8 text-blue-600" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-bold">US-Focused</h3>
                    <p class="text-gray-600">We cater specifically to the US job market, connecting you with local talent in
                        the equine industry.</p>
                </div>

                <!-- Applicant Management -->
                <div class="p-8 text-center bg-white border rounded-lg shadow-lg">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                            <x-heroicon-o-clipboard-document-list class="w-8 h-8 text-blue-600" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-bold">Easy Applicant Management</h3>
                    <p class="text-gray-600">Review applications, track status, and manage candidates all in one organized
                        dashboard.</p>
                </div>

                <!-- Employer Branding -->
                <div class="p-8 text-center bg-white border rounded-lg shadow-lg">
                    <div class="flex justify-center mb-4">
                        <div class="flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full">
                            <x-heroicon-o-building-office class="w-8 h-8 text-blue-600" />
                        </div>
                    </div>
                    <h3 class="mb-2 text-xl font-bold">Professional Employer Profile</h3>
                    <p class="text-gray-600">Showcase your farm or business with photos and detailed information to attract
                        top talent.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ROI Section -->
    <section class="relative px-4 py-12 sm:py-16 md:py-20 lg:py-24 bg-blue-50 md:px-0">
        <div class="flex flex-col items-center justify-between max-w-screen-xl mx-auto md:gap-10 md:flex-row">
            <div class="w-full mb-8 md:w-1/2 md:mb-0">
                <img src="https://equinehire.s3.amazonaws.com/eqh-old/equine-hire-a.webp" loading="lazy"
                    alt="Equine professional working with horses" class="w-full h-auto rounded-lg">
            </div>
            <div class="flex flex-col justify-center w-full gap-5 md:w-1/2">
                <h2 class="text-2xl sm:text-3xl md:text-5xl fancy-title text-pretty">Efficient Equine Hiring Solutions</h2>
                <x-divider class="self-start" />
                <p class="text-base sm:text-lg md:text-xl">Traditional recruiting agencies are expensive and generic job
                    boards often
                    deliver unqualified candidates. EquineHire provides targeted equine recruitment designed specifically
                    for your industry needs.</p>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 mr-4 text-blue-500">
                            <x-heroicon-o-banknotes class="w-full h-full" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Affordable Pricing</h3>
                            <p class="text-gray-600">Starting at just $50/month - a cost-effective solution for finding
                                quality talent</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 mr-4 text-blue-500">
                            <x-heroicon-o-user-group class="w-full h-full" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Equine-Specific Candidates</h3>
                            <p class="text-gray-600">Unlike broad job sites, we reach equine job seekers specifically,
                                ensuring more relevant applicants</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 mr-4 text-blue-500">
                            <x-heroicon-o-magnifying-glass class="w-full h-full" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Enhanced Visibility</h3>
                            <p class="text-gray-600">Our job listings are optimized for search engines like Google to
                                maximize visibility when candidates search for equine jobs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-12 bg-white sm:py-16 md:py-20 lg:py-24">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col gap-5 text-center">
                <h2 class="text-2xl sm:text-3xl md:text-4xl fancy-title">Investment That Pays for Itself</h2>
                <x-divider class="mx-auto" />
                <p class="max-w-md mx-auto text-base text-gray-600 sm:text-lg md:text-xl">
                    One great hire can transform your business. Choose the plan that fits your needs.
                </p>
            </div>

            <!-- Plans Container -->
            <div class="!pt-0 max-w-7xl sm:mx-auto mx-4 mt-10">
                <div class="grid max-w-md grid-cols-1 gap-8 mx-auto mt-10 isolate lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    <!-- Basic Plan -->
                    <div class="p-8 bg-white shadow-md rounded-3xl ring-1 ring-gray-200 xl:p-10">
                        <div class="flex items-center justify-between gap-x-4">
                            <h3 class="text-lg font-semibold leading-8 text-gray-900">Basic Plan</h3>
                        </div>
                        <p class="flex items-baseline mt-6 gap-x-1">
                            <span class="text-4xl font-bold tracking-tight text-gray-900">$50</span>
                            <span class="text-sm font-semibold leading-6 text-gray-600">/month</span>
                        </p>
                        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                1 Concurrent Job Post
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Employer Profile with Images
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Dedicated support
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Featured in our newsletter
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Shared on social media
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cancel Any Time
                            </li>
                        </ul>
                        <a href="{{ route('subscription.plans') }}"
                            class="block w-full px-3 py-2 mt-8 text-sm font-semibold leading-6 text-center text-white bg-blue-600 rounded-md shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 hover:bg-blue-700 focus-visible:outline-blue-600">
                            Choose Plan
                        </a>
                    </div>

                    <!-- Pro Plan -->
                    <div class="p-8 bg-white shadow-md rounded-3xl ring-2 ring-blue-500 xl:p-10">
                        <div class="flex items-center justify-between gap-x-4">
                            <h3 class="text-lg font-semibold leading-8 text-gray-900">Pro Plan</h3>
                            <p class="rounded-full bg-blue-600 px-2.5 py-1 text-xs font-semibold leading-5 text-white">Most
                                popular</p>
                        </div>
                        <p class="flex items-baseline mt-6 gap-x-1">
                            <span class="text-4xl font-bold tracking-tight text-gray-900">$120</span>
                            <span class="text-sm font-semibold leading-6 text-gray-600">/quarter</span>
                        </p>
                        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Up to 5 Concurrent Job Posts
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Employer Profile with Images
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Dedicated support
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Featured in our newsletter
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Shared on social media
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cancel Any Time
                            </li>
                        </ul>
                        <a href="{{ route('subscription.plans') }}"
                            class="block w-full px-3 py-2 mt-8 text-sm font-semibold leading-6 text-center text-white bg-blue-600 rounded-md shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 hover:bg-blue-700 focus-visible:outline-blue-600">
                            Choose Plan
                        </a>
                    </div>

                    <!-- Unlimited Plan -->
                    <div class="p-8 bg-white shadow-md rounded-3xl ring-1 ring-gray-200 xl:p-10">
                        <div class="flex items-center justify-between gap-x-4">
                            <h3 class="text-lg font-semibold leading-8 text-gray-900">Unlimited Plan</h3>
                        </div>
                        <p class="flex items-baseline mt-6 gap-x-1">
                            <span class="text-4xl font-bold tracking-tight text-gray-900">$400</span>
                            <span class="text-sm font-semibold leading-6 text-gray-600">/year</span>
                        </p>
                        <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Unlimited Job Posts
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Employer Profile with Images
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Dedicated support
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Featured in our newsletter
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Shared on social media
                            </li>
                            <li class="flex gap-x-3">
                                <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                    aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                        clip-rule="evenodd" />
                                </svg>
                                Cancel Any Time
                            </li>
                        </ul>
                        <a href="{{ route('subscription.plans') }}"
                            class="block w-full px-3 py-2 mt-8 text-sm font-semibold leading-6 text-center text-white bg-blue-600 rounded-md shadow-sm focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 hover:bg-blue-700 focus-visible:outline-blue-600">
                            Choose Plan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- What Our Customers Say Section -->
    <section class="relative flex flex-col gap-10 px-4 py-12 mx-auto sm:py-16 md:py-20 lg:py-24 md:flex-row max-w-7xl">
        <div class="w-full mb-8 md:w-1/2 md:mb-0 md:order-2">
            <img src="https://equinehire.s3.amazonaws.com/eqh-old/equine-hire-c.webp" loading="lazy"
                alt="Happy equine employer with their team" class="object-cover w-full h-64 md:h-full rounded-xl">
        </div>
        <div class="flex flex-col justify-center w-full gap-5 text-left md:w-1/2 md:order-1">
            <h2 class="text-2xl sm:text-3xl md:text-5xl fancy-title">Trusted by Equine Employers</h2>
            <x-divider class="self-start" />
            <blockquote class="text-base text-gray-800 sm:text-lg md:text-xl">
                "EquineHire helped us find an amazing barn manager within two weeks. The quality of candidates was
                exceptional and they all truly understood horses."
            </blockquote>
            <cite class="text-base text-gray-600 md:text-lg">
                <strong>Sarah Mitchell</strong><br>
                Owner, Sunset Stables, Texas
            </cite>
            <div class="flex flex-col mt-6 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <x-buttons.primary-outline href="{{ route('register') }}" text="Start Hiring Today" />
                <x-buttons.secondary-outline href="{{ route('jobs.index') }}" text="View Job Examples" />
            </div>
        </div>
    </section>

    <!-- Final CTA Section -->
    <section class="py-16 bg-blue-600 sm:py-20 md:py-24 lg:py-32">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="max-w-2xl mx-auto text-center">
                <h2 class="text-2xl font-bold tracking-tight text-white sm:text-3xl md:text-4xl fancy-title">Ready to Find
                    Your Next
                    Hire?</h2>
                <p class="max-w-xl mx-auto mt-4 text-base leading-8 text-blue-100 sm:mt-6 sm:text-lg">
                    Join hundreds of equine employers who have found their perfect team members through EquineHire.
                </p>
                <div class="flex flex-col mt-10 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4 sm:justify-center">
                    <a href="https://equinehire.test/register"
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 bg-white border border-transparent rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                        Get Started Free
                        <x-heroicon-m-chevron-right class="w-5 h-5 ml-2" />
                    </a>
                    <a href="{{ route('jobs.index') }}"
                        class="inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white border border-white rounded-md hover:bg-white hover:text-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white">
                        Browse Job Examples
                    </a>
                </div>
                <p class="mt-4 text-sm text-blue-200">Create an account for free • Cancel anytime</p>
            </div>
        </div>
    </section>
@endsection
