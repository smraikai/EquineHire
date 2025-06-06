@extends('layouts.minimal')

@section('title', 'Subscription Confirmation | EquineHire')

@php
    $metaTitle = 'Subscription Confirmation | EquineHire';
    $pageTitle = 'Subscription Confirmation';
@endphp

@section('content')
    <div class="text-center">
        <div class="mb-8 text-6xl animate-bounce">🎉</div>
        <h1 class="mb-6 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
            Welcome to EquineHire!
        </h1>
        <p class="max-w-xl mx-auto mb-8 text-lg text-gray-600">
            Your subscription is now active. You're ready to start posting jobs and finding the perfect equine professionals
            for your team.
        </p>

        <div class="space-y-4 sm:space-y-0 sm:space-x-4 sm:flex sm:justify-center">
            <a href="{{ route('dashboard.employers.index') }}"
                class="inline-flex items-center px-8 py-4 text-lg font-semibold text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-600">
                Go to Dashboard
                <x-heroicon-m-arrow-right class="w-5 h-5 ml-2" />
            </a>
        </div>

        <div class="max-w-2xl p-12 mx-auto mt-12 rounded-lg bg-blue-50">
            <h3 class="mb-2 text-lg font-semibold text-gray-900">What's Next?</h3>
            <ul class="space-y-2 text-left text-gray-600">
                <li class="flex items-start">
                    <span class="mr-2 text-blue-600">1.</span>
                    Complete your employer profile with photos and company details
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-blue-600">2.</span>
                    Post your first job listing to attract qualified candidates
                </li>
                <li class="flex items-start">
                    <span class="mr-2 text-blue-600">3.</span>
                    Start receiving applications from experienced equine professionals
                </li>
            </ul>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- Confetti Animation -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <script>
        // Trigger confetti when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // First burst
            confetti({
                particleCount: 100,
                spread: 70,
                origin: {
                    y: 0.6
                }
            });

            // Second burst after a short delay
            setTimeout(() => {
                confetti({
                    particleCount: 50,
                    angle: 60,
                    spread: 55,
                    origin: {
                        x: 0
                    }
                });
                confetti({
                    particleCount: 50,
                    angle: 120,
                    spread: 55,
                    origin: {
                        x: 1
                    }
                });
            }, 200);
        });
    </script>

    <!-- Conversion Tracking for Employer Subscription -->
    @if (request()->query('subscription_completed'))
        <script>
            // Initialize the data layer if it doesn't exist
            window.dataLayer = window.dataLayer || [];

            // Prepare the data object for GA4 purchase event
            let purchaseData = {
                'event': 'purchase',
                'currency': 'USD',
                'transaction_id': '{{ $subscription->id ?? '' }}',
                'value': {{ $amount ?? 0 }},
                'items': [{
                    'item_name': '{{ $subscription->name ?? 'Subscription' }}',
                    'item_category': 'Subscription',
                    'price': {{ $amount ?? 0 }},
                    'quantity': 1
                }]
            };

            @if (Auth::check())
                purchaseData.user_id = '{{ Auth::id() }}';
            @endif

            // Push data to the data layer
            window.dataLayer.push(purchaseData);

            // Send purchase event directly to GA4
            if (typeof gtag !== 'undefined') {
                gtag('event', 'purchase', {
                    currency: purchaseData.currency,
                    transaction_id: purchaseData.transaction_id,
                    value: purchaseData.value,
                    items: purchaseData.items,
                    user_id: purchaseData.user_id
                });
            }
        </script>
    @endif
@endsection
