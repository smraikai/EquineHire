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
                                    <th scope="col"
                                        class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                        Reach</th>
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
                                            <a href="{{ route('employers.job-listings.edit', $jobListing->id) }}"
                                                class="mr-2 text-indigo-600 hover:text-indigo-900">Edit</a>
                                            <form action="{{ route('employers.job-listings.destroy', $jobListing->id) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this job listing?')">Delete</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($jobListing->is_boosted)
                                                <span
                                                    class="inline-flex items-center px-2 py-1 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                                    <x-heroicon-s-arrow-trending-up class="w-4 h-4 mr-1" />
                                                    Boosted
                                                </span>
                                            @else
                                                <button onclick="openBoostModal({{ $jobListing->id }})"
                                                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <x-heroicon-o-rocket-launch class="w-5 h-5 mr-2" />
                                                    Boost My Job
                                                </button>
                                            @endif
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
                        <a href="{{ route('employers.job-listings.create') }}"
                            class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out border sm:w-auto sm:px-6 hover:bg-gray-100">
                            <x-coolicon-add-plus-circle class="w-6 h-6 mr-2" /> Create Job Listing
                        </a>
                    </div>
                @endif
            @endif
        </div>
    </div>



    <!-- Boost Job Modal -->
    <div id="boostJobModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
        aria-modal="true">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-blue-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <x-heroicon-o-rocket-launch class="w-6 h-6 text-blue-600" />
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Supercharge Your Job Listing
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-700">
                                    Attract top talent and stand out from the crowd.
                                </p>
                                <ul class="mt-4 space-y-3">
                                    <li class="flex items-start">
                                        <x-heroicon-o-star class="flex-shrink-0 w-5 h-5 text-yellow-400" />
                                        <span class="ml-2 text-sm text-gray-600">Premium placement above non-boosted
                                            listings</span>
                                    </li>
                                    <li class="flex items-start">
                                        <x-heroicon-o-eye class="flex-shrink-0 w-5 h-5 text-blue-500" />
                                        <span class="ml-2 text-sm text-gray-600">Eye-catching design to stand out from the
                                            crowd</span>
                                    </li>
                                    <li class="flex items-start">
                                        <x-heroicon-o-chart-bar class="flex-shrink-0 w-5 h-5 text-green-500" />
                                        <span class="ml-2 text-sm text-gray-600">Significantly increased visibility and
                                            engagement</span>
                                    </li>
                                </ul>
                                <p class="mt-4 text-sm font-medium text-gray-700">
                                    Invest in your hiring success for just
                                    ${{ number_format(config('job_boost.price') / 100, 0) }}!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-4 py-3 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" id="confirmBoostButton"
                        class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Boost Now
                    </button>
                    <button type="button" onclick="closeBoostModal()"
                        class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Maybe Later
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let currentJobListingId;

        function openBoostModal(jobListingId) {
            currentJobListingId = jobListingId;
            document.getElementById('boostJobModal').classList.remove('hidden');
        }

        function closeBoostModal() {
            document.getElementById('boostJobModal').classList.add('hidden');
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
