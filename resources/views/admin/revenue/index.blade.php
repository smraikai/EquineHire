@extends('layouts.admin')

@php
    $metaTitle = 'Revenue Analytics | EquineHire Admin';
    $pageTitle = 'Revenue Analytics';
@endphp

@section('css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Revenue Overview -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-green-600 rounded-md">
                                <x-heroicon-o-currency-dollar class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Today's Revenue</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        ${{ number_format($revenueSummary['today'], 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-blue-600 rounded-md">
                                <x-heroicon-o-currency-dollar class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Current Month</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        ${{ number_format($revenueSummary['current_month'], 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-indigo-600 rounded-md">
                                <x-heroicon-o-currency-dollar class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Previous Month</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        ${{ number_format($revenueSummary['previous_month'], 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-purple-600 rounded-md">
                                <x-heroicon-o-currency-dollar class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Revenue</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">
                                        ${{ number_format($revenueSummary['total'], 2) }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Revenue Charts -->
            <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
                <!-- Monthly Revenue Chart -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Monthly Revenue (Last 12 Months)</h2>
                        <div class="mt-6 h-80">
                            <canvas id="monthlyRevenueChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Subscription by Plan Chart -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900">Subscriptions by Plan</h2>
                        <div class="mt-6 h-80">
                            <canvas id="subscriptionsPlanChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Active Subscriptions -->
            <div class="mt-8">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Active Subscriptions</h2>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 xl:grid-cols-4">
                            @foreach ($subscriptionsByPlan as $planName => $count)
                                <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <h3 class="text-base font-medium text-gray-900">{{ $planName }}</h3>
                                    <p class="mt-2 text-3xl font-semibold text-indigo-600">{{ $count }}</p>
                                    <p class="mt-1 text-sm text-gray-500">active subscriptions</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Subscriptions Table -->
            <div class="mt-8">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-6 py-5 border-b border-gray-200">
                        <h2 class="text-lg font-medium text-gray-900">Recent Subscriptions</h2>
                    </div>
                    <div class="flow-root">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-6 pr-3 text-left text-sm font-semibold text-gray-900">
                                                Customer</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Plan</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Started
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Amount
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($recentSubscriptions as $subscription)
                                            <tr>
                                                <td class="py-4 pl-6 pr-3 text-sm whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0">
                                                            <div
                                                                class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-white bg-blue-600 rounded-full">
                                                                {{ strtoupper(substr($subscription->name, 0, 2)) }}
                                                            </div>
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="font-medium text-gray-900">{{ $subscription->name }}
                                                            </div>
                                                            <div class="text-gray-500">{{ $subscription->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ ucfirst(str_replace('_', ' ', $subscription->name)) }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $subscription->stripe_status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($subscription->stripe_status) }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ \Carbon\Carbon::parse($subscription->created_at)->format('M d, Y') }}
                                                </td>
                                                <td class="px-3 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                                    @php
                                                        // This would need to be enhanced with actual price data from another query
                                                        $plans = [
                                                            'basic_plan' => '$50.00',
                                                            'pro_plan' => '$120.00',
                                                            'unlimited_plan' => '$400.00',
                                                        ];
                                                        $amount = $plans[$subscription->name] ?? 'N/A';
                                                    @endphp
                                                    {{ $amount }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Revenue Chart
            const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
            const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
                type: 'bar',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Monthly Revenue',
                        data: @json($monthlyRevenue),
                        backgroundColor: 'rgba(79, 70, 229, 0.7)',
                        borderColor: 'rgba(79, 70, 229, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return '$' + value.toLocaleString();
                                }
                            }
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return '$' + context.raw.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });

            // Subscriptions by Plan Chart
            const subscriptionsPlanCtx = document.getElementById('subscriptionsPlanChart').getContext('2d');
            const subscriptionsPlanChart = new Chart(subscriptionsPlanCtx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(@json($subscriptionsByPlan)),
                    datasets: [{
                        data: Object.values(@json($subscriptionsByPlan)),
                        backgroundColor: [
                            'rgba(59, 130, 246, 0.7)',
                            'rgba(16, 185, 129, 0.7)',
                            'rgba(139, 92, 246, 0.7)',
                            'rgba(236, 72, 153, 0.7)',
                            'rgba(245, 158, 11, 0.7)'
                        ],
                        borderColor: [
                            'rgba(59, 130, 246, 1)',
                            'rgba(16, 185, 129, 1)',
                            'rgba(139, 92, 246, 1)',
                            'rgba(236, 72, 153, 1)',
                            'rgba(245, 158, 11, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        });
    </script>
@endsection
