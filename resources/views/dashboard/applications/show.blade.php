@extends('layouts.app')

@section('content')
    <div class="min-h-screen py-8 bg-gray-50">
        <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-4">
                <a href="{{ route('employer.applications.index') }}"
                    class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
                    <x-heroicon-m-arrow-left class="w-4 h-4 mr-1" />
                    Back to Applications
                </a>
            </div>

            <!-- Main Card -->
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <!-- Profile Header -->
                <div class="border-b border-gray-200">
                    <div class="px-4 py-4 sm:px-6 sm:py-5">
                        <div
                            class="flex flex-col items-center space-y-4 sm:flex-row sm:items-center sm:justify-between sm:space-y-0">
                            <div
                                class="flex flex-col items-center text-center sm:flex-row sm:items-center sm:space-x-5 sm:text-left">
                                <!-- Avatar placeholder -->
                                <div
                                    class="flex items-center justify-center w-16 h-16 mb-3 bg-gray-200 rounded-full sm:w-20 sm:h-20 sm:mb-0">
                                    <x-heroicon-o-user class="w-8 h-8 text-gray-400 sm:w-12 sm:h-12" />
                                </div>
                                <div>
                                    <h1 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $jobApplication->name }}</h1>
                                    <p class="text-sm text-gray-500">
                                        {{ $jobApplication->jobListing ? 'Application for ' . $jobApplication->jobListing->title : 'Job listing no longer available' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Status Update Form -->
                            <div class="flex items-center justify-center w-full sm:w-auto sm:justify-start">
                                <form action="{{ route('employer.applications.update-status', $jobApplication) }}"
                                    method="POST" class="flex items-center space-x-2">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status"
                                        class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-blue-600 sm:text-sm sm:leading-6">
                                        <option value="new" {{ $jobApplication->status === 'new' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="reviewed"
                                            {{ $jobApplication->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                        <option value="contacted"
                                            {{ $jobApplication->status === 'contacted' ? 'selected' : '' }}>Contacted
                                        </option>
                                        <option value="rejected"
                                            {{ $jobApplication->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    <button type="submit"
                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content Grid -->
                <div class="grid grid-cols-1 divide-y divide-gray-200 lg:grid-cols-3 lg:divide-y-0 lg:divide-x">
                    <!-- Sidebar -->
                    <div class="p-6 space-y-6">
                        <!-- Contact Information -->
                        <div>
                            <h2 class="mb-4 text-lg font-medium text-gray-900">Contact Information</h2>
                            <div class="space-y-4">
                                <div class="flex items-center space-x-3">
                                    <x-heroicon-o-envelope class="w-5 h-5 text-gray-400" />
                                    <a href="mailto:{{ $jobApplication->email }}"
                                        class="text-sm text-blue-600 hover:text-blue-900">
                                        {{ $jobApplication->email }}
                                    </a>
                                </div>
                                @if ($jobApplication->phone)
                                    <div class="flex items-center space-x-3">
                                        <x-heroicon-s-device-phone-mobile class="w-5 h-5 text-gray-400" />
                                        <span class="text-sm text-gray-900">{{ $jobApplication->phone }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Resume -->
                        @if ($jobApplication->resume_path)
                            <div>
                                <h2 class="mb-4 text-lg font-medium text-gray-900">Resume</h2>
                                <a href="{{ Storage::url($jobApplication->resume_path) }}" target="_blank"
                                    class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                    <x-heroicon-o-document-text class="w-5 h-5 mr-2" />
                                    View Resume
                                </a>
                            </div>
                        @endif
                    </div>

                    <!-- Cover Letter -->
                    <div class="p-6 lg:col-span-2">
                        <h2 class="mb-4 text-lg font-medium text-gray-900">Cover Letter</h2>
                        <div class="prose max-w-none">
                            {!! nl2br(e($jobApplication->cover_letter)) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
