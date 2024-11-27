@extends('layouts.app')

@php
    $metaTitle = 'My Account Dashboard | EquineHire';
    $pageTitle = 'My Account';
@endphp


@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (auth()->user()->employer)
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Quick Actions Column -->
                    <div>
                        <h2 class="mb-4 text-lg font-medium leading-6 text-gray-900 sm:text-xl">Quick Actions</h2>
                        <div class="space-y-4 overflow-hidden bg-white border rounded-lg">
                            @include('partials.dashboard._create_job_listing')
                            <hr class="max-w-[95%] mx-auto">
                            @include('partials.dashboard._manage_account')
                        </div>
                    </div>

                    <!-- Subscription Info Column -->
                    <div>
                        <h2 class="mb-4 text-lg font-medium leading-6 text-gray-900 sm:text-xl">Subscription & Billing</h2>
                        @include('partials.dashboard._subscription_info')
                        @include('partials.dashboard._manage_billing')
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
    @else
        <div class="text-center">
            <div class="p-8 bg-white border rounded-lg shadow-sm">
                <div class="mx-auto">
                    <x-heroicon-o-building-office class="w-12 h-12 mx-auto text-gray-400" />
                </div>
                <h3 class="mt-4 text-lg font-semibold text-gray-900">Ready to Post a Job?</h3>
                <p class="mt-2 text-sm text-gray-600">Create an employer profile to get started.</p>
                <div class="mt-6">
                    <a href="{{ route('employers.create') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                        <x-heroicon-m-plus class="w-5 h-5 mr-2" />
                        Create Employer Profile
                    </a>
                </div>
            </div>
        </div>
        @endif
    </div>
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
