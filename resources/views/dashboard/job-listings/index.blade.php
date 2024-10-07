@extends('layouts.app')

@php
    $metaTitle = 'My Job Listings | EquineHire';
    $pageTitle = 'My Job Listings';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24 px-4">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (auth()->user()->employer)
                @if ($jobListings->isNotEmpty())
                    <div class="flex flex-col gap-5 px-4 sm:px-6 lg:px-8">
                        <div class="order-2 sm:order-1 sm:flex sm:items-center sm:justify-between">
                            <div class="flex justify-end">
                                <a href="{{ route('employers.job-listings.create') }}"
                                    class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path
                                            d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                                    </svg>
                                    Add Job Listing
                                </a>
                            </div>
                        </div>
                        <div class="order-1 flow-root sm:order-2">
                            <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                        Job Details</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Creation Date</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Status</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Actions</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Reach</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($jobListings as $jobListing)
                                                    <tr>
                                                        <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                            <div class="font-medium text-gray-900">{{ $jobListing->title }}
                                                            </div>
                                                            <div class="text-gray-500">
                                                                {{ $jobListing->remote_position ? 'Remote' : $jobListing->city . ', ' . $jobListing->state }}
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-4 text-sm text-gray-500">
                                                            {{ $jobListing->created_at->format('M d, Y') }}
                                                        </td>
                                                        <td class="px-3 py-4 text-sm text-gray-500">
                                                            <span
                                                                class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $jobListing->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                                {{ $jobListing->is_active ? 'Active' : 'Inactive' }}
                                                            </span>
                                                        </td>
                                                        <td class="px-3 py-4 text-sm text-gray-500">
                                                            <a href="{{ route('jobs.show', ['job_slug' => Str::slug($jobListing->title), 'id' => $jobListing->id]) }}"
                                                                class="text-blue-600 hover:text-blue-900">View</a>
                                                            <a href="{{ route('employers.job-listings.edit', $jobListing->id) }}"
                                                                class="ml-2 text-blue-600 hover:text-blue-900">Edit</a>
                                                            <form
                                                                action="{{ route('employers.job-listings.destroy', $jobListing->id) }}"
                                                                method="POST" class="inline ml-2">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-red-600 hover:text-red-900"
                                                                    onclick="return confirm('Are you sure you want to delete this job listing?')">Delete</button>
                                                            </form>
                                                        </td>
                                                        <td class="px-3 py-4 text-sm text-gray-500">
                                                            @if ($jobListing->is_boosted)
                                                                <span
                                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">
                                                                    <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                                                                    Boosted
                                                                </span>
                                                            @else
                                                                <button onclick="openBoostModal({{ $jobListing->id }})"
                                                                    class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 hover:text-blue-700 hover:border-blue-700 transition-colors duration-200 ease-in-out min-w-[150px]">
                                                                    <x-heroicon-o-rocket-launch class="w-4 h-4 mr-1.5" />
                                                                    Boost My Listing
                                                                </button>
                                                            @endif
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
                    <div class="mt-4">
                        {{ $jobListings->links() }}
                    </div>
                @else
                    <div class="flex flex-col items-center p-6 bg-white border rounded-md">
                        <p class="text-sm text-gray-600">You haven't created any job listings yet.</p>
                        <a href="{{ route('employers.job-listings.create') }}"
                            class="inline-flex items-center justify-center px-4 py-2 mt-4 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            <x-coolicon-add-plus-circle class="w-5 h-5 mr-2" /> Create Job Listing
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>

    @include('partials.dashboard._boost-listing-modal')

@endsection

@section('scripts')
    <script>
        let currentJobListingId;

        function openBoostModal(jobListingId) {
            currentJobListingId = jobListingId;
            document.getElementById('boostJobModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); // Prevent scrolling
        }


        function closeBoostModal() {
            document.getElementById('boostJobModal').classList.add('hidden');
            document.body.classList.remove('overflow-hidden'); // Re-enable scrolling
        }

        document.getElementById('confirmBoostButton').addEventListener('click', function() {
            boostJob(currentJobListingId);
        });

        function boostJob(jobListingId) {
            fetch(`/job-listings/${jobListingId}/boost`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.checkout_url) {
                        window.location.href = data.checkout_url;
                    } else {
                        alert('Error creating checkout session. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }
    </script>
@endsection
