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
