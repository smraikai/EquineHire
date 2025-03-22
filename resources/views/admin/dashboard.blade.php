@extends('layouts.admin')

@php
    $metaTitle = 'Admin Dashboard | EquineHire';
    $pageTitle = 'Admin Dashboard';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-blue-600 rounded-md">
                                <x-heroicon-o-users class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Total Users</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['total_users'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-green-600 rounded-md">
                                <x-heroicon-o-building-office class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Employers</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['employers'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-indigo-600 rounded-md">
                                <x-heroicon-o-briefcase class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Job Listings</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['job_listings'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 p-3 text-white bg-purple-600 rounded-md">
                                <x-heroicon-o-document-text class="w-6 h-6" />
                            </div>
                            <div class="flex-1 w-0 ml-5">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Applications</dt>
                                    <dd class="text-3xl font-semibold text-gray-900">{{ $stats['applications'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Content Sections -->
            <div class="grid grid-cols-1 gap-6 mt-8 lg:grid-cols-2">
                <!-- Recent Users -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-900">Recent Users</h2>
                            <a href="{{ route('admin.users') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                        <div class="flow-root mt-6">
                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                @foreach ($stats['recent_users'] as $user)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <div
                                                    class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-white bg-blue-600 rounded-full">
                                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                                </div>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}
                                                </p>
                                                <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                                            </div>
                                            <div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->employer ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                                    {{ $user->employer ? 'Employer' : 'Job Seeker' }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Recent Job Listings -->
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-900">Recent Job Listings</h2>
                            <a href="{{ route('admin.job-listings') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                        <div class="flow-root mt-6">
                            <ul role="list" class="-my-5 divide-y divide-gray-200">
                                @foreach ($stats['recent_job_listings'] as $jobListing)
                                    <li class="py-4">
                                        <div class="flex items-center space-x-4">
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $jobListing->title }}</p>
                                                <p class="text-sm text-gray-500 truncate">
                                                    @if ($jobListing->employer)
                                                        {{ $jobListing->employer->name }}
                                                    @else
                                                        <span class="italic">No employer</span>
                                                    @endif
                                                </p>
                                            </div>
                                            <div>
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $jobListing->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ ucfirst($jobListing->status) }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Applications -->
            <div class="mt-8">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <h2 class="text-lg font-medium text-gray-900">Recent Applications</h2>
                            <a href="{{ route('admin.applications') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                View all
                            </a>
                        </div>
                        <div class="mt-6 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full align-middle md:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Applicant</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Job
                                                Listing</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Employer
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($stats['recent_applications'] as $application)
                                            <tr>
                                                <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="font-medium text-gray-900">
                                                                @if ($application->jobSeeker && $application->jobSeeker->user)
                                                                    {{ $application->jobSeeker->user->name }}
                                                                @else
                                                                    <span class="italic text-gray-500">Unknown
                                                                        applicant</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-gray-500">
                                                                @if ($application->jobSeeker && $application->jobSeeker->user)
                                                                    {{ $application->jobSeeker->user->email }}
                                                                @else
                                                                    <span class="italic">No email available</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    @if ($application->jobListing)
                                                        {{ $application->jobListing->title }}
                                                    @else
                                                        <span class="italic">Deleted job listing</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $application->status === 'new'
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($application->status === 'reviewed'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($application->status === 'contacted'
                                                            ? 'bg-green-100 text-green-800'
                                                            : 'bg-red-100 text-red-800')) }}">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    @if ($application->jobListing && $application->jobListing->employer)
                                                        {{ $application->jobListing->employer->name }}
                                                    @else
                                                        <span class="italic">Unknown employer</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ $application->created_at->format('M d, Y') }}</td>
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
