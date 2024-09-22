@extends('layouts.site')

@php
    $metaTitle = 'Our Story | EquineHire';
    $metaDescription =
        'Learn about the journey and mission behind EquineHire, the platform connecting horse owners with equine professionals.';
@endphp

@section('content')
    <div class="py-24 bg-white sm:py-32">
        <div class="max-w-3xl px-6 mx-auto lg:px-8">
            <div class="max-w-2xl mx-auto lg:mx-0">
                <h1 class="text-5xl font-bold tracking-tight text-gray-900 sm:text-6xl fancy-title">Our Story</h1>
                <p class="mt-6 text-2xl leading-8 text-gray-600">
                    EquineHire was born out of a passion for horses and a desire to simplify the process of connecting
                    horse owners with qualified equine professionals.
                </p>
            </div>
            <div class="max-w-2xl mx-auto mt-16 lg:mx-0 lg:max-w-none">
                <div class="grid grid-cols-1 gap-x-8 gap-y-16 lg:grid-cols-2">
                    <div class="p-10 rounded-lg bg-slate-100">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">The Challenge</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            We noticed that horse owners often struggled to find reliable professionals for various equine
                            services. At the same time, talented equine professionals had difficulty marketing their
                            services effectively.
                        </p>
                    </div>
                    <div class="p-10 rounded-lg bg-slate-100">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Our Solution</h2>
                        <p class="mt-4 text-lg text-gray-600">
                            EquineHire was created to bridge this gap, providing a user-friendly platform where horse
                            owners can easily connect with vetted equine professionals across various specialties.
                        </p>
                    </div>
                </div>
                <div class="mt-16">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Our Mission</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        Our mission is clear: we're transforming the equine industry by providing a solution that's long
                        overdue. We firmly believe that equine professionals deserve better tools to grow their businesses
                        and increase their visibility.
                    </p>
                    <p class="mt-4 text-lg text-gray-600">
                        Simultaneously, we're committed to empowering horse owners with an
                        efficient, reliable way to find exceptional equine services in their area. By bridging this gap,
                        we're not just connecting services - we're elevating the entire equine community, driving growth,
                        and setting new standards for quality and accessibility in horse care.
                    </p>
                </div>
                <div class="mt-16">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Looking Forward</h2>
                    <p class="mt-4 text-lg text-gray-600">
                        As we continue to grow, we remain committed to improving and expanding our platform to better serve
                        the equine community. We're excited about the future and the positive impact EquineHire will
                        have on horse care and equine businesses worldwide.
                    </p>
                </div>
            </div>
        </div>
    </div>
    @include('partials.footer_cta')
@endsection
