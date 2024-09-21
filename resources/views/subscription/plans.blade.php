@extends('layouts.app')

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
        <div class="py-12 bg-white shadow shadow-xl sm:py-24 rounded-3xl">
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

                <div class="grid max-w-md grid-cols-1 gap-8 mx-auto mt-10 isolate lg:mx-0 lg:max-w-none lg:grid-cols-3">
                    @foreach ($plans as $index => $plan)
                        <div
                            class="rounded-3xl p-8 ring-1 {{ $index === 1 ? 'ring-blue-500 ring-2' : 'ring-gray-200' }} bg-white xl:p-10">
                            <div class="flex items-center justify-between gap-x-4">
                                <h3 id="{{ $plan['id'] }}" class="text-lg font-semibold leading-8 text-gray-900">
                                    {{ $plan['name'] }}
                                </h3>
                                @if ($index === 1)
                                    <p
                                        class="rounded-full bg-blue-500 px-2.5 py-1 text-xs font-semibold leading-5 text-white">
                                        Most popular</p>
                                @endif
                            </div>
                            <p class="mt-4 text-sm leading-6 text-gray-600">
                                {{ $plan['name'] }} plan for growing businesses.
                            </p>
                            <p class="flex items-baseline mt-6 gap-x-1">
                                <span class="text-4xl font-bold tracking-tight text-gray-900">
                                    ${{ $plan['price'] }}
                                </span>
                                <span class="text-sm font-semibold leading-6 text-gray-600">
                                    /{{ $plan['interval'] }}
                                </span>
                            </p>
                            <ul role="list" class="mt-8 space-y-3 text-sm leading-6 text-gray-600">
                                @foreach ($plan['features'] as $feature)
                                    <li class="flex gap-x-3">
                                        <svg class="flex-none w-5 h-6 text-blue-600" viewBox="0 0 20 20" fill="currentColor"
                                            aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                            <form action="{{ route('subscription.store-plan') }}" method="POST" class="mt-8">
                                @csrf
                                <input type="hidden" value="{{ $plan['id'] }}" name="plan">
                                <button type="submit"
                                    class="w-full rounded-md px-3 py-2 text-center text-sm font-semibold leading-6 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 
                    {{ $index === 1
                        ? 'bg-blue-600 text-white shadow-sm hover:bg-blue-500 focus-visible:outline-blue-600'
                        : 'bg-blue-50 text-blue-700 shadow-sm hover:bg-blue-100 focus-visible:outline-blue-600' }}">
                                    Subscribe to {{ $plan['name'] }}
                                </button>
                            </form>
                        </div>
                    @endforeach
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
                                class="absolute flex items-center justify-center w-12 h-12 text-white bg-blue-500 rounded-md">
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
                                class="absolute flex items-center justify-center w-12 h-12 text-white bg-blue-500 rounded-md">
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
                                class="absolute flex items-center justify-center w-12 h-12 text-white bg-blue-500 rounded-md">
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
                                class="absolute flex items-center justify-center w-12 h-12 text-white bg-blue-500 rounded-md">
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
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white bg-blue-500 rounded-md">
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
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white bg-blue-500 rounded-md">
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
                                    class="flex items-center justify-center w-12 h-12 overflow-hidden text-white bg-blue-500 rounded-md">
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
