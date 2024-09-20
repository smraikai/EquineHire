@extends('layouts.app')

@section('content')
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side: Payment completion form -->
        <div class="flex items-center justify-center w-full px-4 py-8 md:w-1/2">
            <div class="w-full max-w-xl">
                <div class="mb-8">
                    <h1 class="mb-6 text-3xl font-bold md:text-4xl fancy-title">Complete Your Subscription</h1>
                    <p class="text-base text-gray-600 md:text-lg">To activate your business listing or manage your account,
                        please update your
                        payment information and complete the transaction.</p>
                </div>

                <div class="space-y-6">
                    <a href="{{ route('subscription.plans') }}" class="block w-full text-center btn main">
                        Select a Subscription Plan
                    </a>

                    @if (auth()->user()->hasStripeId() &&
                            auth()->user()->subscription('default') &&
                            auth()->user()->subscription('default')->active())
                        <a href="{{ route('billing') }}" class="block w-full text-center btn white">
                            Manage Billing
                        </a>
                    @endif
                </div>

                <div class="mt-12">
                    <h3 class="mb-4 text-2xl font-semibold">Frequently Asked Questions</h3>
                    <div class="space-y-4">
                        <div>
                            <h4 class="font-bold">Why is my payment incomplete?</h4>
                            <p class="text-gray-600">This can happen due to insufficient funds or temporary issues with your
                                payment method.</p>
                        </div>
                        <div>
                            <h4 class="font-bold">What happens if I don't complete the payment?</h4>
                            <p class="text-gray-600">You will not be able to have an active listing on EquineHire
                                until the
                                payment is
                                completed.</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- Right side: Full-size image (hidden on mobile) -->
        <div class="relative hidden w-1/2 md:block">
            <img src="{{ asset('images/equine_pro_finder_register.jpg') }}" alt="Payment Image"
                class="object-cover w-full h-full max-h-screen">
            <div class="absolute inset-0 bg-gradient-to-br from-black/70 to-transparent"></div>
        </div>
    </div>
@endsection
