@extends('layouts.app')

@php
    $metaTitle = 'My Account Dashboard | EquineHire';
    $pageTitle = 'My Account';
    $hasEmployerProfile = \App\Models\Employer::employerProfileCheck(auth()->user());
@endphp


@section('content')
    @if (!$hasEmployerProfile)
        <div class="container px-4 py-12 mx-auto sm:py-24">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col items-center p-6 mb-8 bg-white border rounded-md">
                    <p class="text-gray-800 text-md">Create an Employer Profile to start posting
                        your job listings.</p>
                    <a href="{{ route('employers.create') }}"
                        class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out border sm:w-auto sm:px-6 hover:bg-gray-100">
                        <x-heroicon-o-plus-circle class="w-6 h-6 mr-2" /> Create Employer Profile
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="container py-12 mx-auto">
            <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Quick Actions Column -->
                    <div>
                        <h2 class="mb-4 text-lg font-medium leading-6 text-gray-900 sm:text-xl">Quick Actions</h2>
                        <div class="space-y-4 overflow-hidden bg-white border rounded-lg">
                            @include('partials.dashboard._manage_billing')
                            <hr class="max-w-[95%] mx-auto">
                            @include('partials.dashboard._manage_account')
                        </div>
                    </div>

                    <!-- Subscription Info Column -->
                    <div>
                        <h2 class="mb-4 text-lg font-medium leading-6 text-gray-900 sm:text-xl">Subscription Information
                        </h2>
                        @include('partials.dashboard._subscription_info')
                    </div>
                </div>

                <div class="my-8">
                    @include('partials.dashboard._analytics')
                </div>

                <!-- Add this after your existing job listings section -->
                <div class="mt-8">
                    @include('dashboard.partials._recent-applications')
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    <!-- Conversion Tracking for Employer Subscription -->
    @if (request()->query('subscription_completed'))
        <script>
            // Initialize the data layer if it doesn't exist
            window.dataLayer = window.dataLayer || [];

            // Prepare the data object
            let purchaseData = {
                'event': 'purchase',
                'currency': 'USD'
            };

            @if (isset($subscription))
                purchaseData.transaction_id = '{{ $subscription->id }}';
                purchaseData.subscription_id = '{{ $subscription->id }}';
                purchaseData.items = [{
                    'item_name': '{{ $subscription->name }}',
                    'item_category': 'Subscription',
                    'quantity': 1
                }];
            @endif

            @if (isset($amount))
                purchaseData.value = {{ $amount }};
                if (purchaseData.items && purchaseData.items[0]) {
                    purchaseData.items[0].price = {{ $amount }};
                }
            @endif

            @if (Auth::check())
                purchaseData.user_id = '{{ Auth::id() }}';
            @endif

            // Push data to the data layer
            window.dataLayer.push(purchaseData);
        </script>
    @endif

    <!-- Chart.js for Page Views -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection
