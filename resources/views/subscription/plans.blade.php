@extends('layouts.app')

@php
    $metaTitle = 'List Your Equine Business | EquineHire';
    $metaDescription =
        'Showcase your equine services, connect with potential clients, and grow your business. Choose a subscription plan to list your services on EquineHire.';
@endphp

@section('content')
    <section>
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div x-data="{ annual: true }" class="bg-white">
                <div class="px-6 mx-auto max-w-7xl lg:px-8">
                    <div class="text-center">
                        <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                            <span class="block xl:inline">List Your Business</span>
                        </h1>
                        <p class="max-w-md mx-auto mt-3 text-base text-gray-500 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                            With EquineHire, you can showcase your services, connect with potential clients, and take
                            your
                            equine business to the next level.
                        </p>
                    </div>

                    <div class="flex justify-center mt-10">
                        <div class="relative flex items-center p-1 bg-gray-100 rounded-full">
                            <button @click="annual = true"
                                :class="{ 'bg-blue-600 text-white': annual, 'text-slate-700': !annual }"
                                class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-full focus:outline-none">Annual</button>
                            <button @click="annual = false"
                                :class="{ 'bg-blue-600 text-white': !annual, 'text-slate-700': annual }"
                                class="px-4 py-2 text-sm font-medium transition-colors duration-200 rounded-full focus:outline-none">Monthly</button>
                        </div>
                    </div>

                    <div
                        class="max-w-2xl mx-auto mt-16 rounded-3xl ring-1 ring-gray-200 sm:mt-10 lg:mx-0 lg:flex lg:max-w-none">
                        <div class="p-8 sm:p-10 lg:flex-auto">
                            <h3 class="text-2xl font-bold tracking-tight text-gray-900">Showcase Your Unique Offerings</h3>
                            <p class="mt-6 text-base leading-7 text-gray-600">Our platform is designed to help you maximize
                                exposure and display your
                                unique services to help you stand out in the equine industry.</p>

                            <div class="flex items-center mt-10 gap-x-4">
                                <h4 class="flex-none text-sm font-semibold leading-6 text-blue-600">What's included</h4>
                                <div class="flex-auto h-px bg-gray-100"></div>
                            </div>
                            <ul role="list"
                                class="grid grid-cols-1 gap-4 mt-8 text-sm leading-6 text-gray-600 sm:grid-cols-2 sm:gap-6">
                                <li class="flex gap-x-3">
                                    <x-coolicon-check class="flex-none w-5 h-6 text-blue-600" />
                                    Showcase your equine services
                                </li>
                                <li class="flex gap-x-3">
                                    <x-coolicon-check class="flex-none w-5 h-6 text-blue-600" />
                                    Connect with potential clients
                                </li>
                                <li class="flex gap-x-3">
                                    <x-coolicon-check class="flex-none w-5 h-6 text-blue-600" />
                                    Boost your business visibility
                                </li>
                                <li class="flex gap-x-3">
                                    <x-coolicon-check class="flex-none w-5 h-6 text-blue-600" />
                                    Access to dedicated support
                                </li>
                                <li class="flex gap-x-3">
                                    <x-coolicon-check class="flex-none w-5 h-6 text-blue-600" />
                                    Build your online reputation
                                </li>
                                <li class="flex gap-x-3">
                                    <x-coolicon-check class="flex-none w-5 h-6 text-blue-600" />
                                    Expand your equine business reach
                                </li>
                            </ul>

                        </div>
                        <div class="p-2 -mt-2 lg:mt-0 lg:w-full lg:max-w-md lg:flex-shrink-0">
                            <div
                                class="h-full py-10 text-center rounded-2xl bg-gray-50 ring-1 ring-inset ring-gray-900/5 lg:flex lg:flex-col lg:justify-center lg:py-16">
                                <div class="max-w-xs px-8 mx-auto">
                                    <p class="text-base font-semibold text-gray-600">Get started today</p>
                                    <p class="flex items-baseline justify-center mt-6 gap-x-2">
                                        <span x-text="annual ? '${{ $plans[1]['price'] }}' : '${{ $plans[0]['price'] }}'"
                                            class="text-5xl font-bold tracking-tight text-gray-900"></span>
                                        <span x-text="annual ? '/year' : '/month'"
                                            class="text-sm font-semibold leading-6 tracking-wide text-gray-600"></span>
                                    </p>
                                    <form action="{{ route('subscription.store-plan') }}" method="POST" class="mt-10">
                                        @csrf
                                        <input type="hidden"
                                            x-bind:value="annual ? '{{ $plans[1]['id'] }}' : '{{ $plans[0]['id'] }}'"
                                            name="plan">
                                        <button type="submit"
                                            class="block w-full px-3 py-2 text-sm font-semibold text-center text-white rounded-md shadow-sm bg-blue-600 hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Subscribe</button>
                                    </form>
                                    <p class="mt-6 text-xs leading-5 text-gray-600">Secure payment processing through
                                        Stripe. Cancel
                                        anytime.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <section class="py-12 ">
        <div class="p-12 mx-auto bg-gray-100 max-w-7xl sm:px-6 lg:px-8 rounded-2xl">
            <div class="lg:text-center">
                <h2 class="mt-2 text-3xl font-extrabold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                    Why Join EquineHire?
                </h2>
                <p class="max-w-2xl mt-4 text-xl text-gray-500 lg:mx-auto">
                    EquineHire helps equine service providers connect with new customers and grow their business.
                    Here's how:
                </p>
            </div>

            <div class="mt-10">
                <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-10">
                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center w-12 h-12 text-white rounded-md bg-blue-500">
                                <x-coolicon-user-add class="w-6 h-6" />
                            </div>
                            <p class="ml-16 text-lg font-medium leading-6 text-gray-900">Reach New Customers</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Get your equine services in front of thousands of potential customers actively searching for
                            providers like you.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center w-12 h-12 text-white rounded-md bg-blue-500">
                                <x-coolicon-trending-up class="w-6 h-6" />
                            </div>
                            <p class="ml-16 text-lg font-medium leading-6 text-gray-900">Grow Your Business</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Attract new clients and increase your revenue with a professional listing showcasing your
                            services and expertise.
                        </dd>
                    </div>

                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center w-12 h-12 text-white rounded-md bg-blue-500">
                                <x-coolicon-book-open class="w-6 h-6" />
                            </div>
                            <p class="ml-16 text-lg font-medium leading-6 text-gray-900">
                                Access Growth Resources
                                <span
                                    class="inline-flex items-center px-2 py-1 ml-2 text-xs font-medium text-yellow-800 bg-yellow-200 rounded-md">Coming
                                    Soon!</span>
                            </p>

                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Gain exclusive access to our library of educational materials and guides
                            designed to help you expand and optimize your equine business.
                        </dd>
                    </div>


                    <div class="relative">
                        <dt>
                            <div
                                class="absolute flex items-center justify-center w-12 h-12 text-white rounded-md bg-blue-500">
                                <x-coolicon-chat-circle-check class="w-6 h-6" />
                            </div>
                            <p class="ml-16 text-lg font-medium leading-6 text-gray-900">Get Expert Support</p>
                        </dt>
                        <dd class="mt-2 ml-16 text-base text-gray-500">
                            Our dedicated support team is here to help you make the most of your listing and achieve your
                            business goals.
                        </dd>
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
                                    What is included in the subscription?
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
                                The subscription includes a professional listing to showcase your services, allowing
                                potential clients to find your business through search engines. This maximizes your exposure
                                and helps you gain new clients by increasing your online visibility.</p>
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
                <h2 class="text-base font-semibold tracking-wide uppercase text-blue-600">Testimonials</h2>
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
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white rounded-md bg-blue-500">
                                    <img class="w-12 h-12" src="https://dummyimage.com/150x150/000/fff" alt="">
                                </div>
                            </div>
                            <div>
                                <div class="text-lg font-medium leading-6 text-gray-900">
                                    John Doe
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    CEO, ABC Company
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
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white rounded-md bg-blue-500">
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
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white rounded-md bg-blue-500">
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
