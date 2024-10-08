@extends('layouts.site')

@php
    $metaTitle = 'Job Seeker Dashboard | EquineHire';
    $pageTitle = 'Job Seeker Dashboard';
@endphp

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold leading-7 text-gray-900 sm:tracking-tight">My Information
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 gap-x-8 gap-y-10 md:grid-cols-3">
                        <div class="px-4 sm:px-0">
                            <p class="mt-1 leading-6 text-gray-600 text-md">Your personal details and contact information.
                            </p>
                        </div>

                        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">
                            <dl class="divide-y divide-gray-100">
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Name</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        {{ auth()->user()->jobSeeker->name }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Email</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        {{ auth()->user()->jobSeeker->email }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Phone</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        {{ auth()->user()->jobSeeker->phone ?? 'Not provided' }}
                                    </dd>
                                </div>
                                <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium leading-6 text-gray-900">Resume</dt>
                                    <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                                        @if (auth()->user()->jobSeeker->resume_path)
                                            <a href="{{ Storage::url(auth()->user()->jobSeeker->resume_path) }}"
                                                class="font-medium text-blue-600 hover:text-blue-500" target="_blank">View
                                                Resume</a>
                                        @else
                                            Not uploaded
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 gap-x-6">
                        <div class="flex items-center justify-end mt-6 gap-x-6">
                            <a href="{{ route('job-seeker.edit') }}"
                                class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Edit Profile
                            </a>
                        </div>
                    </div>

                    <div class="pb-5 mt-8 border-b border-gray-200">
                        <h2 class="text-lg font-bold leading-7 text-gray-900 sm:tracking-tight">My Job
                            Applications</h2>
                    </div>

                    @if (auth()->user()->jobSeeker->jobApplications->count() > 0)
                        <ul role="list" class="divide-y divide-gray-100">
                            @foreach (auth()->user()->jobSeeker->jobApplications as $application)
                                <li class="flex items-center justify-between py-5">
                                    <div class="flex-1 min-w-0">
                                        @if ($application->jobListing->is_active)
                                            <a href="{{ route('jobs.show', ['job_slug' => $application->jobListing->slug, 'id' => $application->jobListing->id]) }}"
                                                class="text-sm font-semibold leading-6 text-blue-600 truncate hover:text-blue-800">
                                                {{ $application->jobListing->title }}
                                            </a>
                                        @else
                                            <p class="text-sm font-semibold leading-6 text-gray-900 truncate">
                                                {{ $application->jobListing->title }}
                                            </p>
                                        @endif
                                    </div>
                                    <p class="ml-4 text-sm leading-5 text-gray-500 whitespace-nowrap">
                                        Applied on: {{ $application->created_at->format('M d, Y') }}
                                    </p>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">You haven't submitted any job applications yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
