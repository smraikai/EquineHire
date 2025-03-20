@extends('layouts.app')

@php
    $metaTitle = 'Subscription Confirmation | EquineHire';
    $pageTitle = 'Subscription Confirmation';
@endphp

@section('content')
    <div class="flex items-center justify-center min-h-[calc(100vh-4rem)]">
        <div class="container px-4 py-8 mx-auto">
            <div class="max-w-2xl mx-auto text-center">
                <div class="mb-6 text-6xl animate-bounce">🎉</div>
                <h1 class="mb-4 text-3xl font-bold text-gray-900">Subscription Successful!</h1>
                <p class="mb-8 text-lg text-gray-600">
                    You're now ready to start finding the perfect candidates.
                </p>
                <a href="{{ route('dashboard.employers.index') }}"
                    class="inline-flex items-center px-6 py-3 text-base font-medium text-white transition duration-300 bg-blue-600 rounded-lg hover:bg-blue-700 hover:scale-105">
                    <x-heroicon-m-arrow-right-circle class="w-5 h-5 mr-2" />
                    Go to Dashboard
                </a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
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
