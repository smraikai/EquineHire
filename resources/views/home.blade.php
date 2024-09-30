@extends('layouts.site')

@php
    // Contentful Setup for Home Page
    use Contentful\Delivery\Client as ContentfulClient;
    use Contentful\Delivery\Query;

    $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
    $query = new Query();
    $query->setContentType('blogPost')->setLimit(3)->orderBy('sys.createdAt', true);
    $latestPosts = $client->getEntries($query);

@endphp

@section('content')
    <section class="relative min-h-[500px] md:min-h-[900px] flex">
        <!-- Image Hero Section -->
        <div class="absolute inset-0 z-0">
            <div class="relative w-full h-full">
                <img src="https://equinehire.s3.amazonaws.com/eqh-old/equine-vet.webp" alt="Equine Hero Image"
                    class="object-cover w-full h-full">
            </div>

            <div class="absolute inset-0 opacity-65 bg-gradient-to-b from-black to-transparent"></div>
            <div class="absolute inset-0 opacity-65 bg-gradient-to-r from-black to-transparent"></div>
        </div>

        <div class="container relative flex items-center max-w-screen-xl px-4 mx-auto">
            <div class="flex w-full max-w-xl text-white">
                <div class="text">
                    <h1 class="mb-4 text-4xl md:text-5xl lg:text-7xl fancy-title">Find Equine Jobs Near You</h1>
                    <p class="max-w-lg mb-6 text-lg md:text-xl lg:text-2xl">Browse through amazing career opportunities in
                        the equine industry.</p>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('subscription.plans') }}" class="text-center text-md btn accent">Post a Job</a>
                        <a href="{{ route('jobs.index') }}" class="text-center text-md btn main">Find a Job</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- divider -->
        <svg class="absolute bottom-0 w-full h-16 text-white md:h-24" preserveAspectRatio="none" viewBox="0 0 100 100">
            <path d="M0,0 C50,100 80,100 100,0 L100,100 L0,100 Z" fill="currentColor"></path>
        </svg>
        <!-- /divider -->
    </section>

    <section class="py-10 bg-white">
        <div class="px-4 py-2 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <h3 class="mb-8 font-black tracking-widest text-center text-gray-600 uppercase text-md">Trusted By</h3>
            <div class="grid grid-cols-2 gap-8 md:grid-cols-6 lg:grid-cols-5">
                <div class="flex justify-center col-span-1 md:col-span-2 lg:col-span-1">
                    <img class="object-contain h-16 opacity-65 sm:h-20 md:h-24 filter grayscale"
                        src="https://equinehire-static-assets.s3.amazonaws.com/cornell-vet.jpg" alt="Cornell Vet">
                </div>
                <div class="flex justify-center col-span-1 md:col-span-2 lg:col-span-1">
                    <img class="object-contain h-16 opacity-65 sm:h-20 md:h-24 filter grayscale"
                        src="https://equinehire.s3.amazonaws.com/eqh-old/WEC-Logo-no-background.gif" alt="WEC">
                </div>
                <div class="flex justify-center col-span-2 md:col-span-3 lg:col-span-1">
                    <img class="object-contain h-16 opacity-65 sm:h-20 md:h-24 filter grayscale"
                        src="https://equinehire-static-assets.s3.amazonaws.com/allison-springer-logo.jpg"
                        alt="Allison Springer Logo">
                </div>
                <div class="flex justify-center col-span-1 md:col-span-3 lg:col-span-1">
                    <img class="object-contain h-16 opacity-65 sm:h-20 md:h-24 filter grayscale"
                        src="https://equinehire.s3.amazonaws.com/eqh-old/unnamed-2.png" alt="American Summer Camps">
                </div>
                <div class="flex justify-center col-span-1 md:col-span-2 lg:col-span-1">
                    <img class="object-contain h-16 opacity-65 sm:h-20 md:h-24 filter grayscale"
                        src="https://equinehire-static-assets.s3.amazonaws.com/penn-vet.png" alt="Penn Vet">
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Latest Job Opportunities
                </h2>
                <p class="max-w-2xl mx-auto mt-3 text-xl text-gray-500 sm:mt-4">
                    Explore the most recent job listings in the equine industry
                </p>
            </div>
            <div class="mt-12 space-y-4">
                @foreach (\App\Models\JobListing::latest()->take(10)->get() as $job_listing)
                    @include('partials.jobs.list', ['job_listing' => $job_listing])
                @endforeach
            </div>
            <div class="mt-10 text-center">
                <x-buttons.primary href="{{ route('jobs.index') }}" text="View All Jobs" />
            </div>
        </div>
    </section>

    <section class="relative px-4 bg-blue-50 md:px-0">
        <div class="flex flex-col items-center justify-between max-w-screen-xl mx-auto md:gap-10 md:flex-row">
            <div class="w-full mb-8 md:w-1/2 md:mb-0">
                <img src="https://equinehire.s3.amazonaws.com/eqh-old/equine-hire-a.webp" loading="lazy"
                    alt="Equine veterinarian with a horse out in a field." class="w-full h-auto rounded-lg">
            </div>
            <div class="flex flex-col justify-center w-full gap-5 md:w-1/2">
                <h2 class="text-3xl md:text-5xl fancy-title">Find A Fullfilling Career</h2>
                <x-divider class="self-start" />
                <p class="text-lg md:text-xl">Find amazing career opportunities in the equine industry with EquineHire,
                    ranging from training and
                    riding to healthcare and breeding.
                </p>

                <div class="space-y-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 mr-4 text-blue-500">
                            <x-heroicon-o-briefcase class="w-full h-full" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Explore Jobs in the Horse Industry</h3>
                            <p class="text-gray-600">Browse exciting equine job opportunities.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 mr-4 text-blue-500">
                            <x-heroicon-o-magnifying-glass class="w-full h-full" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Discover Your Perfect Fit</h3>
                            <p class="text-gray-600">Use our search filters to find the exact job you are looking for.</p>
                        </div>
                    </div>

                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-8 h-8 mr-4 text-blue-500">
                            <x-heroicon-o-rocket-launch class="w-full h-full" />
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Get Noticed</h3>
                            <p class="text-gray-600">Boost your application power with free career resources.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <section class="relative flex flex-col gap-10 px-4 mx-auto md:flex-row max-w-7xl">
        <div class="w-full mb-8 md:w-1/2 md:mb-0 md:order-2">
            <img src="https://equinehire.s3.amazonaws.com/eqh-old/equine-hire-c.webp" loading="lazy"
                alt="Woman petting a horse's head." class="object-cover w-full h-64 md:h-full rounded-xl">
        </div>
        <div class="flex flex-col justify-center w-full gap-5 text-left md:w-1/2 md:order-1">

            <h2 class="text-3xl md:text-5xl fancy-title">What is EquineHire?</h2>
            <x-divider class="self-start" />
            <p class="text-lg text-gray-800 md:text-xl">EquineHire is passionate about connecting passionate
                equestrians with <strong>incredible equine jobs.</strong></p>
            <p class="text-base text-gray-600 md:text-xl">Our mission is to create a <strong>seamless, user-friendly
                    online platform</strong> where equine businesses can showcase their job openings, and job seekers can
                <strong>effortlessly discover and engage with these opportunities.</strong>
            </p>
            <p class="text-base text-gray-600 md:text-xl">Whether you're looking to grow your team or find your dream job
                in the equine world, EquineHire is your go-to platform for connecting talent with opportunity.</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                    <x-buttons.primary-outline href="{{ route('subscription.plans') }}" text="Post a Job" />
                    <x-buttons.secondary-outline href="{{ route('jobs.index') }}" text="Find a Job" />
                </div>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col gap-5 text-center">
                <h2 class="text-3xl md:text-4xl fancy-title">
                    Top Articles for Equestrian Job Seekers
                </h2>
                <x-divider class="mx-auto" />
                <p class="max-w-2xl mx-auto text-xl text-gray-500">
                    Discover expert tips on resume writing, interviewing, and salary negotiation for equestrians.
                </p>
            </div>
            <div class="grid grid-cols-1 gap-8 mt-10 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($latestPosts as $post)
                    <a href="{{ route('blog.show', $post->get('slug')) }}" class="block h-full">
                        <article
                            class="relative flex flex-col justify-end h-full px-8 pt-64 pb-8 overflow-hidden transition duration-300 ease-in-out transform bg-gray-900 rounded-lg shadow isolate sm:pt-48 lg:pt-64 hover:-translate-y-2 hover:shadow-lg group">
                            @if ($post->has('featuredImage'))
                                <img src="{{ $post->get('featuredImage')->getFile()->getUrl() }}"
                                    alt="{{ $post->get('title') }}"
                                    class="absolute inset-0 object-cover w-full h-full -z-10" loading="lazy">
                            @endif
                            <div class="absolute inset-0 -z-10 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                            <div class="mt-auto">
                                <h3 class="mb-2 text-lg font-semibold leading-6 text-white">
                                    {{ $post->get('title') }}
                                </h3>
                                <div
                                    class="flex items-center text-sm text-gray-200 transition-all duration-300 transform translate-y-full opacity-0 group-hover:translate-y-0 group-hover:opacity-100">
                                    Read More<x-coolicon-chevron-right-md class="w-4 h-4" />
                                </div>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta.job-alerts')
@endsection
