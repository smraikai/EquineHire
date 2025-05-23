@extends('layouts.admin')

@php
    $metaTitle = 'Employers | EquineHire Admin';
    $pageTitle = 'Manage Employers';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-medium text-gray-900">Employers</h2>
                            <p class="mt-2 text-sm text-gray-700">A list of all employers registered in the system.</p>
                        </div>
                    </div>
                    
                    <!-- Filters -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <form method="GET" action="{{ route('admin.employers') }}" class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                <!-- Search -->
                                <div>
                                    <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                           placeholder="Name or description..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <!-- Subscription Status Filter -->
                                <div>
                                    <label for="subscription_status" class="block text-sm font-medium text-gray-700">Subscription Status</label>
                                    <select name="subscription_status" id="subscription_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">All Statuses</option>
                                        <option value="active" {{ request('subscription_status') === 'active' ? 'selected' : '' }}>Active Subscription</option>
                                        <option value="inactive" {{ request('subscription_status') === 'inactive' ? 'selected' : '' }}>Inactive Subscription</option>
                                        <option value="no_user" {{ request('subscription_status') === 'no_user' ? 'selected' : '' }}>No User</option>
                                    </select>
                                </div>
                                
                                <!-- Location Filter -->
                                <div>
                                    <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                                    <input type="text" name="location" id="location" value="{{ request('location') }}" 
                                           placeholder="City, state, or country..."
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <!-- Job Listings Filter -->
                                <div>
                                    <label for="job_listings" class="block text-sm font-medium text-gray-700">Job Listings</label>
                                    <select name="job_listings" id="job_listings" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                        <option value="">All</option>
                                        <option value="has_listings" {{ request('job_listings') === 'has_listings' ? 'selected' : '' }}>Has Job Listings</option>
                                        <option value="no_listings" {{ request('job_listings') === 'no_listings' ? 'selected' : '' }}>No Job Listings</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                <!-- Date From -->
                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-700">Created From</label>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <!-- Date To -->
                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-700">Created To</label>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                </div>
                                
                                <!-- Filter Actions -->
                                <div class="flex items-end space-x-2">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Filter
                                    </button>
                                    <a href="{{ route('admin.employers') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Employer</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact
                                                Info</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Listings
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Subscription Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($employers as $employer)
                                            <tr>
                                                <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($employer->logo)
                                                                <img class="h-10 w-10 rounded-full"
                                                                    src="{{ Storage::url($employer->logo) }}"
                                                                    alt="">
                                                            @else
                                                                <div
                                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                                    <x-heroicon-o-building-office class="h-6 w-6" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="font-medium text-gray-900">{{ $employer->name }}
                                                            </div>
                                                            <div class="text-gray-500">
                                                                @if ($employer->user)
                                                                    {{ $employer->user->name }}
                                                                @else
                                                                    <span class="italic">No user</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($employer->user)
                                                        <div>{{ $employer->user->email }}</div>
                                                    @else
                                                        <span class="italic">No email</span>
                                                    @endif
                                                    @if ($employer->website)
                                                        <div>{{ $employer->website }}</div>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @php
                                                        $address = array_filter([
                                                            $employer->city,
                                                            $employer->state,
                                                            $employer->country,
                                                        ]);
                                                    @endphp
                                                    {{ !empty($address) ? implode(', ', $address) : 'No location' }}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 text-center">
                                                    {{ $employer->jobListings()->count() }}
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                    @if ($employer->user)
                                                        @if ($employer->user->hasActiveSubscription())
                                                            <span
                                                                class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">Active</span>
                                                        @else
                                                            <span
                                                                class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Inactive</span>
                                                        @endif
                                                    @else
                                                        <span
                                                            class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-700 ring-1 ring-inset ring-gray-600/20">No
                                                            User</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ $employer->created_at->format('M d, Y') }}
                                                </td>
                                                <td
                                                    class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                    <a href="{{ route('employers.show', $employer->id) }}"
                                                        class="text-blue-600 hover:text-blue-900">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        {{ $employers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
