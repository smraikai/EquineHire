@extends('layouts.app')


{{-- @php
    // Meta Tags
    $metaTitle = 'Find Equine Services Near You | EquineHire';
    $metaDescription =
        'Discover local boarding facilities, farriers, veterinarians, trainers, and more equine services. Connect with top professionals in your area.';

    // Contentful Setup for Home Page
    use Contentful\Delivery\Client as ContentfulClient;
    use Contentful\Delivery\Query;

    $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
    $query = new Query();
    $query->setContentType('blogPost')->setLimit(3)->orderBy('sys.createdAt', true);
    $latestPosts = $client->getEntries($query);

@endphp
--}}

@section('content')
    <section class="relative min-h-[500px] md:min-h-[750px] flex">
        <!-- Image Hero Section -->
        <div class="absolute inset-0 z-0">
            <div class="relative w-full h-full">
                <img src="{{ asset('images/home_hero.webp') }}" alt="Equine Hero Image" class="object-cover w-full h-full">
            </div>

            <div class="absolute inset-0 opacity-50 bg-gradient-to-b from-black to-transparent"></div>
            <div class="absolute inset-0 opacity-70 bg-gradient-to-r from-black to-transparent"></div>
        </div>

        <div class="container relative flex items-center max-w-screen-xl px-4 mx-auto">
            <div class="flex w-full max-w-xl text-white">
                <div class="text">
                    <h1 class="mb-4 text-4xl md:text-5xl lg:text-7xl fancy-title">Find Equine Jobs Near You</h1>
                    <p class="max-w-lg mb-6 text-lg md:text-xl lg:text-2xl">Browse through amazing career opportunities in the equine industry.</p>
                    <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('businesses.directory') }}" class="text-center text-md btn main">Post a Job</a>
                        <a href="{{ route('subscription.plans') }}" class="text-center text-md btn accent">Find a Job</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="relative px-4 py-8 -mt-10 bg-white md:py-12 lg:py-24 rounded-3xl z-1 md:px-0">

        <div class="flex flex-col items-center justify-between max-w-screen-xl mx-auto md:gap-10 md:flex-row">
            <div class="w-full mb-8 md:w-1/2 md:mb-0">
                <img src="https://EquineHire-static-assets.s3.amazonaws.com/equine_professionals.jpg" loading="lazy"
                    alt="Equine veterinarian with a horse out in a field." class="w-full h-auto rounded-lg">
            </div>
            <div class="flex flex-col justify-center w-full gap-5 md:w-1/2">
                <x-divider />
                <h2 class="text-3xl md:text-5xl fancy-title">Easily Connect with Equine Professionals Near You</h2>
                <p class="text-lg md:text-xl"><strong>Finding the right equine professional is now simple and
                        convenient.</strong> Our
                    platform connects you with farriers, veterinarians, trainers, and other experts in your area.
                </p>
                <p class="text-lg md:text-xl">Just enter your location
                    and browse through detailed profiles, complete with qualifications and expertise. Make informed
                    decisions with ease and ensure your horses get the best care from trusted professionals nearby.</p>
            </div>
        </div>
    </section>
    <section class="px-4 py-24 bg-gray-50 md:px-8">
        <div class="container mx-auto max-w-7xl">
            <div class="flex flex-col gap-5">
                <x-divider class="mx-auto" />
                <h2 class="text-3xl text-center text-gray-800 md:text-5xl fancy-title">Explore a Variety of Equine Services
                </h2>
                <p class="max-w-4xl mx-auto text-lg text-center md:text-xl">Discover a comprehensive range of professional
                    equine
                    services, from veterinary care and farrier services to training programs and boarding facilities, all on
                    one convenient platform.</p>
                <div class="grid grid-cols-2 gap-4 mt-8 sm:gap-6 lg:grid-cols-4">
                    <a href="{{ route('businesses.directory', ['categories[]' => 5]) }}"
                        class="flex flex-col items-center justify-center p-4 transition duration-300 ease-in-out border border-gray-200 rounded-lg sm:p-6 bg-gray-50 aspect-square hover:bg-white hover:shadow-lg group hover:-translate-y-2">
                        <img src="https://EquineHire-static-assets.s3.amazonaws.com/icon_farrier.svg" alt="Farriers"
                            loading="lazy" class="w-8 h-8 mb-2 sm:w-10 sm:h-10 sm:mb-4">
                        <div class="text-base font-bold text-center text-gray-900 sm:text-xl">
                            Farriers
                        </div>
                    </a>
                    <a href="{{ route('businesses.directory', ['categories[]' => 14]) }}"
                        class="flex flex-col items-center justify-center p-4 transition duration-300 ease-in-out border border-gray-200 rounded-lg sm:p-6 bg-gray-50 aspect-square hover:bg-white hover:shadow-lg group hover:-translate-y-2">
                        <img src="https://EquineHire-static-assets.s3.amazonaws.com/icon_trainers.svg" alt="Trainers"
                            loading="lazy" class="w-8 h-8 mb-2 sm:w-10 sm:h-10 sm:mb-4">
                        <div class="text-base font-bold text-center text-gray-900 sm:text-xl">
                            Trainers
                        </div>
                    </a>
                    <a href="{{ route('businesses.directory', ['categories[]' => 1]) }}"
                        class="flex flex-col items-center justify-center p-4 transition duration-300 ease-in-out border border-gray-200 rounded-lg sm:p-6 bg-gray-50 aspect-square hover:bg-white hover:shadow-lg group hover:-translate-y-2">
                        <img src="https://EquineHire-static-assets.s3.amazonaws.com/icon_boarding_facilities.svg"
                            loading="lazy" alt="Boarding Facilities" class="w-8 h-8 mb-2 sm:w-10 sm:h-10 sm:mb-4">
                        <div class="text-base font-bold text-center text-gray-900 sm:text-xl">
                            Boarding Facilities
                        </div>
                    </a>
                    <a href="{{ route('businesses.directory', ['categories[]' => 6]) }}"
                        class="flex flex-col items-center justify-center p-4 transition duration-300 ease-in-out border border-gray-200 rounded-lg sm:p-6 bg-gray-50 aspect-square hover:bg-white hover:shadow-lg group hover:-translate-y-2">
                        <img src="https://EquineHire-static-assets.s3.amazonaws.com/icon_riding_lessons.svg"
                            loading="lazy" alt="Riding Lessons" class="w-8 h-8 mb-2 sm:w-10 sm:h-10 sm:mb-4">
                        <div class="text-base font-bold text-center text-gray-900 sm:text-xl">
                            Riding Lessons
                        </div>
                    </a>
                </div>

                <div class="flex justify-center mt-8">
                    <x-eqpf-btn-primary href="/explore" text="View All Jobs" />
                </div>

            </div>
        </div>
    </section>

    <section class="relative flex flex-col gap-10 px-4 py-24 mx-auto md:flex-row max-w-7xl md:py-16">
        <div class="w-full mb-8 md:w-1/2 md:mb-0 md:order-2">
            <img src="https://EquineHire-static-assets.s3.amazonaws.com/EquineHire_section_3.jpg" loading="lazy"
                alt="Woman petting a horse's head." class="object-cover w-full h-64 md:h-full rounded-xl">
        </div>
        <div class="flex flex-col justify-center w-full gap-5 text-left md:w-1/2 md:order-1">
            <x-divider class="self-start" />
            <h2 class="text-3xl md:text-5xl fancy-title">What is EquineHire?</h2>
            <p class="text-lg font-bold text-gray-800 md:text-xl">Think of EquineHire as your one-stop resource for
                all
                your horse's needs.</p>
            <p class="text-base text-gray-600 md:text-xl">Our extensive listings ensure you can find the most suitable
                service
                provider, regardless of your horse's specific requirements.</p>
            <p class="text-base text-gray-600 md:text-xl">Whether you're seeking expert services or aiming to expand your
                equine
                business reach, EquineHire bridges the gap.</p>
            <div class="flex flex-col mt-4 space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <x-eqpf-btn-alt href="{{ route('subscription.plans') }}" text="Post a Job" />
                <x-eqpf-btn-alt href="{{ route('businesses.directory') }}" text="Find Services" />
            </div>
        </div>
    </section>

{{-- 
    <section class="py-24 bg-gray-50">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex flex-col gap-5 text-center">
                <x-divider class="mx-auto" />
                <h2 class="text-3xl md:text-4xl fancy-title">
                    Latest Blog Posts
                </h2>
                <p class="max-w-2xl mx-auto text-xl text-gray-500">
                    Stay up to date with the latest news and insights from our blog.
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
--}}

    <section class="px-4 py-24 bg-blue-50 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-7xl">
            <div class="max-w-5xl mx-auto text-center">
                <h2 class="mb-6 text-xl text-blue-900 sm:text-2xl md:text-2xl">
                    "EquineHire is a game-changer for the equine industry. As a horse trainer, I'm thrilled about its
                    potential to connect me with new clients and grow my business. The platform makes it incredibly easy for
                    horse enthusiasts to find professionals like me. I highly recommend it to any equine professional
                    looking to expand their client base!"
                </h2>
                <div class="mt-6">
                    <img class="inline-block w-20 h-20 rounded-full sm:w-24 sm:h-24"
                        src="https://EquineHire-static-assets.s3.amazonaws.com/dynamic-drassage-llc-min.jpg"
                        alt="Dynamic Drassage owner riding a horse." />
                    <p class="mt-4 text-base font-medium text-gray-900 sm:text-lg">Rebekah Mingari-Stought</p>
                    <p class="text-sm text-gray-600 sm:text-base">Dynamic Dressage LLC</p>
                </div>
            </div>
        </div>
    </section>
    <section
        class="relative flex flex-col md:flex-row max-h-full md:max-h-[675px] max-w-7xl mx-auto gap-10 px-4 py-24 md:py-16">
        <div class="w-full mb-8 md:w-1/2 md:mb-0 md:order-2">
            <img src="https://EquineHire-static-assets.s3.amazonaws.com/EquineHire_section_4.jpg" loading="lazy"
                alt="Woman walking with a horse." class="object-cover w-full h-64 md:h-full rounded-xl aspect-square">
        </div>
        <div class="flex flex-col justify-center w-full gap-5 md:w-1/2 md:order-1">
            <x-divider />
            <div>
                <span class="text-sm md:text-md fancy-subtitle">Attract New Clients</span>
                <h2 class="mt-2 text-4xl md:text-6xl fancy-title">Join the EquineHire Network</h2>
            </div>

            <p class="text-lg text-gray-800 md:text-xl"><strong>Reach a network of dedicated horse owners actively seeking
                    qualified
                    professionals like you!</strong> Equine Finder Pro connects horse enthusiasts with the very best in
                equine care.</p>
            <div class="flex flex-col space-y-4 sm:flex-row sm:space-y-0 sm:space-x-4">
                <x-eqpf-btn-primary href="{{ route('subscription.plans') }}" text="Post a Job" />
                <x-eqpf-btn-outline href="{{ route('our.story') }}" text="Our Story" />
            </div>
        </div>
    </section>
@endsection
