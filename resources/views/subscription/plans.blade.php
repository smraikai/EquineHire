@extends('layouts.site')

@php
    $metaTitle = 'Post A Job | EquineHire';
    $metaDescription = 'Find an ideal equestrian candidate for your job with EquineHire.';
@endphp

@section('content')
    <x-custom.hero-light>
        <x-slot name="kicker">Subscription Plans</x-slot>
        <x-slot name="title">Find Your Next Equine Pro</x-slot>
        <x-slot name="subtitle">
            Finding the perfect candidate shouldn't require jumping through hoops. That's why we offer a seamless job
            posting platform to connect you with your next hire.
        </x-slot>
    </x-custom.hero-light>

    <section class="!pt-0 max-w-7xl mx-auto -my-16">
        <div class="py-12 bg-white shadow-xl sm:py-24 rounded-3xl">
            <div class="px-6 mx-auto max-w-7xl lg:px-8">
                <div class="max-w-4xl mx-auto sm:text-center">
                    <x-custom.kicker-text text="Flexible Pricing Options" />
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Choose the Right Plan for
                        Your Business</p>
                </div>
                <p class="max-w-2xl mx-auto mt-6 text-lg leading-8 text-gray-600 sm:text-center">
                    With EquineHire, you can post job opportunities, connect with qualified candidates, and find the perfect
                    equine pro for your business.
                </p>

                @include('subscription._plans-component')

            </div>
        </div>
    </section>

    <section class="py-24 bg-white sm:py-32">
        <div class="px-6 mx-auto max-w-7xl lg:px-8">
            <div class="max-w-2xl mx-auto lg:text-center">
                <h2 class="text-base font-semibold leading-7 text-blue-600">Why Choose Us</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Why Post Jobs on EquineHire?</p>
                <p class="mt-6 text-lg leading-8 text-gray-600">EquineHire helps you find the perfect candidates for your
                    equine job openings. Here's how we stand out:</p>
            </div>
            <div class="max-w-2xl mx-auto mt-16 sm:mt-20 lg:mt-24 lg:max-w-4xl">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-2 lg:gap-y-16">
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute top-0 left-0 flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>
                            Optimized for Search Engines
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">
                            Our job listings are optimized for search engines like Google. When people search for jobs in
                            your area, your listing on EquineHire will appear in results, maximizing visibility.
                        </dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute top-0 left-0 flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z" />
                                </svg>
                            </div>
                            Social Media Boost
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">We share your jobs on relevant Facebook groups,
                            acting like a social media manager to help find the right candidates.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute top-0 left-0 flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3v1.5M3 21v-6m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.11.732a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" />
                                </svg>
                            </div>
                            US-Focused
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">We cater specifically to the US job market,
                            connecting you with local talent in the equine industry.</dd>
                    </div>
                    <div class="relative pl-16">
                        <dt class="text-base font-semibold leading-7 text-gray-900">
                            <div
                                class="absolute top-0 left-0 flex items-center justify-center w-10 h-10 bg-blue-600 rounded-lg">
                                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                            Equine-Specific
                        </dt>
                        <dd class="mt-2 text-base leading-7 text-gray-600">Unlike broad job sites, we reach equine job
                            seekers specifically, ensuring more relevant applicants.</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <section>
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="max-w-3xl mx-auto">
                <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Frequently Asked Questions
                </h2>
                <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                    <div class="pt-6">
                        <dt class="text-lg">
                            <button class="flex items-start justify-between w-full text-left text-gray-400"
                                aria-expanded="false">
                                <span class="font-medium text-gray-900">
                                    What is included in the subscription plans?
                                </span>
                                <span class="flex items-center ml-6 h-7">
                                    <svg class="w-6 h-6 transform rotate-0" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="pr-12 mt-2" style="display: none;">
                            <p class="text-base text-gray-500">
                                We offer three subscription plans to suit your needs. The Basic Plan ($50/month) includes 1
                                job post. Our Pro Plan ($120/3 months) allows up to 5 concurrent job posts. For unlimited
                                job posts, choose our Premium Plan ($400/year). All plans feature the option to add images
                                to your employer profile, dedicated support, newsletter features, and social media sharing.
                                You can cancel your subscription at any time.
                            </p>
                        </dd>
                    </div>

                    <div class="pt-6">
                        <dt class="text-lg">
                            <button class="flex items-start justify-between w-full text-left text-gray-400"
                                aria-expanded="false">
                                <span class="font-medium text-gray-900">
                                    How can I cancel my subscription?
                                </span>
                                <span class="flex items-center ml-6 h-7">
                                    <svg class="w-6 h-6 transform rotate-0" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="pr-12 mt-2" style="display: none;">
                            <p class="text-base text-gray-500">
                                You can cancel your subscription at any time from your account settings. Your listing will
                                remain active until the end of your current billing period.
                            </p>
                        </dd>
                    </div>

                    <div class="pt-6">
                        <dt class="text-lg">
                            <button class="flex items-start justify-between w-full text-left text-gray-400"
                                aria-expanded="false">
                                <span class="font-medium text-gray-900">
                                    What payment methods do you accept?
                                </span>
                                <span class="flex items-center ml-6 h-7">
                                    <svg class="w-6 h-6 transform rotate-0" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </span>
                            </button>
                        </dt>
                        <dd class="pr-12 mt-2" style="display: none;">
                            <p class="text-base text-gray-500">
                                We accept payments via credit card (Visa, Mastercard, American Express) through Stripe, a
                                secure and trusted payment processor. All transactions are processed on Stripe's PCI-DSS
                                compliant platform, ensuring the highest level of payment security.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
    <section class="hidden">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="lg:text-center">
                <h2 class="text-base font-semibold tracking-wide text-blue-600 uppercase">Testimonials</h2>
                <p class="mt-2 text-3xl font-extrabold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                    What our customers are saying
                </p>
            </div>

            <div class="mt-10">
                <div class="space-y-10 md:space-y-0 md:grid md:grid-cols-3 md:gap-x-8 md:gap-y-10">
                    <div>
                        <div class="mt-2 text-base text-gray-500">
                            "The customer service is top-notch. They are always quick to respond and very helpful."
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="flex-shrink-0 mr-4">
                                <div
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white bg-blue-600 rounded-md">
                                    <img class="w-12 h-12" src="https://dummyimage.com/150x150/000/fff" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-medium leading-6 text-gray-900">
                                    John Doe
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    CEO, ABC Employer
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mt-2 text-base text-gray-500">
                            "The customer service is top-notch. They are always quick to respond and very helpful."
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="flex-shrink-0 mr-4">
                                <div
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white bg-blue-600 rounded-md">
                                    <img class="w-12 h-12" src="https://dummyimage.com/150x150/000/fff" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-medium leading-6 text-gray-900">
                                    Jane Smith
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    Marketing Manager, XYZ Inc.
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mt-2 text-base text-gray-500">
                            "The customer service is top-notch. They are always quick to respond and very helpful."
                        </div>
                        <div class="flex items-center mt-4">
                            <div class="flex-shrink-0 mr-4">
                                <div
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white bg-blue-600 rounded-md">
                                    <img class="w-12 h-12" src="https://dummyimage.com/150x150/000/fff" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-medium leading-6 text-gray-900">
                                    Mike Johnson
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    Owner, 123 Store
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('dt button');
            buttons.forEach(button => {
                button.addEventListener('click', () => {
                    const dd = button.parentElement.nextElementSibling;
                    const svg = button.querySelector('svg');

                    if (button.getAttribute('aria-expanded') === 'false') {
                        dd.style.display = 'block';
                        button.setAttribute('aria-expanded', 'true');
                        svg.classList.add('rotate-180');
                    } else {
                        dd.style.display = 'none';
                        button.setAttribute('aria-expanded', 'false');
                        svg.classList.remove('rotate-180');
                    }
                });
            });
        });
    </script>
@endsection
