@extends('layouts.admin')

@php
    $metaTitle = 'Job Listings | EquineHire Admin';
    $pageTitle = 'Manage Job Listings';
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
                            <h2 class="text-lg font-medium text-gray-900">Job Listings</h2>
                            <p class="mt-2 text-sm text-gray-700">A list of all job listings in the system.</p>
                        </div>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Title</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Employer
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                Applications</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($jobListings as $jobListing)
                                            <tr>
                                                <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                                    <div class="font-medium text-gray-900">{{ $jobListing->title }}</div>
                                                    <div class="text-gray-500">
                                                        {{ Str::limit($jobListing->description_plain, 50) }}</div>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($jobListing->employer)
                                                        {{ $jobListing->employer->name }}
                                                    @else
                                                        <span class="italic">No employer</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($jobListing->location)
                                                        {{ $jobListing->location }}
                                                    @else
                                                        <span class="italic">No location</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $jobListing->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                        {{ ucfirst($jobListing->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 text-center">
                                                    {{ $jobListing->jobApplications()->count() }}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    <form method="POST" action="{{ route('admin.job-listings.update-created-at', $jobListing) }}" class="flex items-center space-x-2">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="date" 
                                                               name="created_at" 
                                                               value="{{ $jobListing->created_at->format('Y-m-d') }}"
                                                               class="text-xs border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                                        <button type="submit" 
                                                                class="px-2 py-1 text-xs text-white bg-blue-600 rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            Update
                                                        </button>
                                                    </form>
                                                </td>
                                                <td
                                                    class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                    <a href="{{ route('jobs.show', ['job_slug' => $jobListing->slug, 'id' => $jobListing->id]) }}"
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
                        {{ $jobListings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
