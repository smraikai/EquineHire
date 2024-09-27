@extends('layouts.app')

@php
    $metaTitle = 'My Account Dashboard | EquineHire';
    $pageTitle = 'My Account';
@endphp


@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                    <h2 class="mb-4 text-lg font-medium leading-6 text-gray-900 sm:text-xl">Subscription Information</h2>
                    @include('partials.dashboard._subscription_info')

                    <!-- Start: Page Views Analytics -->
                    @include('partials.dashboard._analytics')
                    <!-- End: Page Views Analytics -->

                </div>
            </div>
        </div>
    </div>


    <div id="confirmModal" class="fixed inset-0 z-10 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Confirm Deletion
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this business listing?
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.business-success-bar')
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
    <script>
        fetch('/business/analytics')
            .then(response => response.json())
            .then(data => {
                if (data.data.length > 0) {
                    document.getElementById('noDataMessage').style.display = 'none';
                    document.getElementById('pageViewsChart').style.display = 'block';
                    const ctx = document.getElementById('pageViewsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Page Views',
                                data: data.data,
                                borderColor: 'rgb(16, 185, 129)',
                                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                                tension: 0.1,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        boxWidth: 0,
                                        font: {
                                            size: 12
                                        }
                                    }
                                }
                            }
                        }

                    });
                } else {
                    document.getElementById('noDataMessage').style.display = 'block';
                    document.getElementById('pageViewsChart').style.display = 'none';
                }
            });
    </script>
@endsection
