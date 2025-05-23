@extends('layouts.admin')

@php
    $metaTitle = 'Job Listings | EquineHire Admin';
    $pageTitle = 'Manage Job Listings';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
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
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Employer
                                                Email
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
                                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $jobListing->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $jobListing->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($jobListing->employer && $jobListing->employer->user)
                                                        {{ $jobListing->employer->user->email }}
                                                    @else
                                                        <span class="italic">N/A</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 text-center">
                                                    {{ $jobListing->jobApplications()->count() }}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ $jobListing->created_at->format('M d, Y') }}
                                                </td>
                                                <td
                                                    class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                    <a href="{{ route('jobs.show', ['job_slug' => $jobListing->slug, 'id' => $jobListing->id]) }}"
                                                        class="text-blue-600 hover:text-blue-900">View</a>
                                                    <button type="button" x-data="{}"
                                                        x-on:click="$dispatch('open-modal', { id: 'publish-date-modal-{{ $jobListing->id }}', jobListingId: {{ $jobListing->id }}, currentPublishDate: '{{ $jobListing->created_at->format('Y-m-d') }}' })"
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900">
                                                        Edit Date
                                                    </button>
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

    <!-- Publish Date Modal -->
    <div x-data="{ show: false, jobListingId: null, publishDate: '' }"
        x-on:open-modal.window="if ($event.detail.id === 'publish-date-modal-' + $event.detail.jobListingId) { show = true; jobListingId = $event.detail.jobListingId; publishDate = $event.detail.currentPublishDate; }"
        x-show="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="show" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div x-show="show" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                x-on:click.away="show = false">
                <div class="px-4 pt-5 pb-4 bg-white sm:p-6 sm:pb-4">
                    <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                        Modify Publish Date
                    </h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">
                            Enter the new publish date for this job listing.
                        </p>
                        <form
                            x-on:submit.prevent="
                            console.log('Sending update request for JobListing ID:', jobListingId, 'with date:', publishDate);
                            fetch('/admin/job-listings/' + jobListingId + '/publish-date', {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({ publish_date: publishDate })
                            })
                            .then(response => {
                                console.log('Raw response:', response);
                                if (!response.ok) {
                                    // If response is not OK (e.g., 4xx or 5xx), parse error message
                                    return response.json().then(err => { throw err; });
                                }
                                return response.json();
                            })
                            .then(data => {
                                console.log('Parsed data:', data);
                                if (data.success) {
                                    window.location.reload(); // Reload to show updated date
                                } else {
                                    alert('Error: ' + (data.message || 'Could not update publish date.'));
                                }
                            })
                            .catch(error => {
                                console.error('Fetch error:', error);
                                alert('An error occurred while updating the publish date. Check console for details.');
                            })
                            .finally(() => show = false);
                        ">
                            <div class="mt-4">
                                <label for="publish_date" class="block text-sm font-medium text-gray-700">Publish
                                    Date</label>
                                <input type="date" x-model="publishDate" id="publish_date" name="publish_date"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div class="px-4 py-3 mt-5 bg-gray-50 sm:px-6 sm:flex sm:flex-row-reverse">
                                <button type="submit"
                                    class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                                    Update Date
                                </button>
                                <button type="button" x-on:click="show = false"
                                    class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
