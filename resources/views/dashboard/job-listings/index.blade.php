@extends('layouts.app')

@php
    $metaTitle = 'My Job Listings | EquineHire';
    $pageTitle = 'My Job Listings';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (auth()->user()->employer)
                @if ($jobListings->isNotEmpty())
                    <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Job Details</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Creation Date</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Status</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($jobListings as $jobListing)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $jobListing->title }}</div>
                                            <div class="text-sm text-gray-500">
                                                {{ $jobListing->remote_position ? 'Remote' : $jobListing->city . ', ' . $jobListing->state }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $jobListing->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $jobListing->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $jobListing->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-medium whitespace-nowrap">
                                            <a href="{{ route('jobs.show', ['job_slug' => Str::slug($jobListing->title), 'id' => $jobListing->id]) }}"
                                                class="mr-2 text-indigo-600 hover:text-indigo-900">View</a>
                                            <a href="{{ route('dashboard.job-listings.edit', $jobListing->id) }}"
                                                class="mr-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('dashboard.job-listings.destroy', $jobListing->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this job listing?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $jobListings->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center p-6 bg-white border rounded-md">
                        <p class="text-sm text-gray-600">You haven't created any job listings yet.</p>
                        <a href="{{ route('dashboard.job-listings.create') }}"
                            class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out border sm:w-auto sm:px-6 hover:bg-gray-100">
                            <x-coolicon-add-plus-circle class="w-6 h-6 mr-2" /> Create Job Listing
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
