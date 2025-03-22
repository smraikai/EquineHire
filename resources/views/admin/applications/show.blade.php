@extends('layouts.admin')

@php
    $metaTitle = 'Application Details | EquineHire Admin';
    $pageTitle = 'Application Details';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600">
                                <x-heroicon-o-home class="w-4 h-4 mr-2" />
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                                <a href="{{ route('admin.applications') }}"
                                    class="ml-1 text-sm font-medium text-gray-500 hover:text-blue-600 md:ml-2">Applications</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <x-heroicon-o-chevron-right class="w-4 h-4 text-gray-400" />
                                <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Application Details</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                <!-- Application Details -->
                <div class="lg:col-span-2">
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-6">
                            <div class="mb-6">
                                <h2 class="text-xl font-semibold text-gray-900">Application Details</h2>
                                <div class="mt-2 text-sm text-gray-600">
                                    Submitted on {{ $application->created_at->format('F j, Y \a\t g:i a') }}
                                </div>
                            </div>

                            <div class="border-t border-gray-200 pt-4">
                                <dl class="divide-y divide-gray-200">
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
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
                                        </dd>
                                    </div>

                                    <!-- Cover Letter -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Cover Letter</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            <div class="prose max-w-none">
                                                {!! $application->cover_letter ?: '<span class="text-gray-500 italic">No cover letter provided</span>' !!}
                                            </div>
                                        </dd>
                                    </div>

                                    <!-- Experience -->
                                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                        <dt class="text-sm font-medium text-gray-500">Experience</dt>
                                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                            @if ($application->experience)
                                                <div class="prose max-w-none">
                                                    {!! $application->experience !!}
                                                </div>
                                            @else
                                                <span class="text-gray-500 italic">No experience details provided</span>
                                            @endif
                                        </dd>
                                    </div>

                                    <!-- Additional Information -->
                                    @if ($application->additional_information)
                                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                            <dt class="text-sm font-medium text-gray-500">Additional Information</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                <div class="prose max-w-none">
                                                    {!! $application->additional_information !!}
                                                </div>
                                            </dd>
                                        </div>
                                    @endif

                                    <!-- Resume/CV -->
                                    @if ($application->resume_path)
                                        <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4">
                                            <dt class="text-sm font-medium text-gray-500">Resume/CV</dt>
                                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                                <a href="{{ Storage::url($application->resume_path) }}" target="_blank"
                                                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    <x-heroicon-o-document-text class="w-5 h-5 mr-2" />
                                                    View Resume
                                                </a>
                                            </dd>
                                        </div>
                                    @endif
                                </dl>
                            </div>

                            <!-- Status Update Form -->
                            <div class="mt-6 border-t border-gray-200 pt-6">
                                <h3 class="text-lg font-medium text-gray-900">Update Status</h3>
                                <form action="{{ route('admin.applications.update-status', $application->id) }}"
                                    method="POST" class="mt-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center space-x-4">
                                        <select name="status"
                                            class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                            <option value="new" {{ $application->status === 'new' ? 'selected' : '' }}>
                                                New</option>
                                            <option value="reviewed"
                                                {{ $application->status === 'reviewed' ? 'selected' : '' }}>Reviewed
                                            </option>
                                            <option value="contacted"
                                                {{ $application->status === 'contacted' ? 'selected' : '' }}>Contacted
                                            </option>
                                            <option value="rejected"
                                                {{ $application->status === 'rejected' ? 'selected' : '' }}>Rejected
                                            </option>
                                        </select>
                                        <button type="submit"
                                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            Update Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Applicant Info -->
                    <div class="overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Applicant Information</h3>
                            @if ($application->jobSeeker && $application->jobSeeker->user)
                                <div class="mt-4 flex items-center">
                                    <div class="flex-shrink-0">
                                        <div
                                            class="flex items-center justify-center w-10 h-10 text-sm font-semibold text-white bg-blue-600 rounded-full">
                                            {{ strtoupper(substr($application->jobSeeker->user->name, 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-base font-medium text-gray-900">
                                            {{ $application->jobSeeker->user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $application->jobSeeker->user->email }}</div>
                                    </div>
                                </div>
                                @if ($application->jobSeeker->phone)
                                    <div class="mt-4">
                                        <div class="text-sm font-medium text-gray-500">Phone</div>
                                        <div class="mt-1 text-sm text-gray-900">{{ $application->jobSeeker->phone }}</div>
                                    </div>
                                @endif
                                @if ($application->jobSeeker->location)
                                    <div class="mt-4">
                                        <div class="text-sm font-medium text-gray-500">Location</div>
                                        <div class="mt-1 text-sm text-gray-900">{{ $application->jobSeeker->location }}
                                        </div>
                                    </div>
                                @endif
                            @else
                                <div class="mt-4 text-sm text-gray-500 italic">Applicant information not available</div>
                            @endif
                        </div>
                    </div>

                    <!-- Job Information -->
                    <div class="mt-6 overflow-hidden bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900">Job Information</h3>
                            @if ($application->jobListing)
                                <div class="mt-4">
                                    <div class="text-base font-medium text-gray-900">{{ $application->jobListing->title }}
                                    </div>
                                    @if ($application->jobListing->employer)
                                        <div class="mt-1 text-sm text-gray-600">
                                            {{ $application->jobListing->employer->name }}</div>
                                    @endif
                                    @if ($application->jobListing->location)
                                        <div class="mt-1 text-sm text-gray-500">{{ $application->jobListing->location }}
                                        </div>
                                    @endif
                                </div>

                                @if ($application->jobListing->salary_range)
                                    <div class="mt-4">
                                        <div class="text-sm font-medium text-gray-500">Salary Range</div>
                                        <div class="mt-1 text-sm text-gray-900">
                                            {{ $application->jobListing->salary_range }}</div>
                                    </div>
                                @endif

                                <div class="mt-4">
                                    <div class="text-sm font-medium text-gray-500">Job Type</div>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ ucfirst($application->jobListing->job_type) }}</div>
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('jobs.show', ['job_slug' => $application->jobListing->slug, 'id' => $application->jobListing->id]) }}"
                                        target="_blank" class="text-sm font-medium text-blue-600 hover:text-blue-500">
                                        View Job Listing
                                    </a>
                                </div>
                            @else
                                <div class="mt-4 text-sm text-gray-500 italic">Job information not available</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
