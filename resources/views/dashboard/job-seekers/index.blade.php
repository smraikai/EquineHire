@extends('layouts.app')

@php
    $metaTitle = 'Job Seeker Profile | EquineHire';
    $pageTitle = 'Job Seeker Profile';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($jobSeeker)
                <div class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Full Name</label>
                        <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                            <p class="px-3 py-2">{{ $jobSeeker->full_name }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Bio</label>
                        <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                            <div class="px-3 py-2">{!! $jobSeeker->bio !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                <p class="px-3 py-2">{{ $jobSeeker->email }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                <p class="px-3 py-2">{{ $jobSeeker->phone_number }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Location</label>
                        <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                            <p class="px-3 py-2">{{ $jobSeeker->location }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Profile Picture</label>
                        <div class="block w-full mt-1">
                            @if ($jobSeeker->profile_picture_url)
                                <img src="{{ Storage::url($jobSeeker->profile_picture_url) }}" alt="Profile Picture"
                                    class="object-cover w-32 h-32 rounded-md">
                            @else
                                <p class="text-sm text-gray-600">No profile picture uploaded.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Resume</label>
                        @if ($jobSeeker->resume_url)
                            <a href="{{ Storage::url($jobSeeker->resume_url) }}" target="_blank"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Resume
                            </a>
                        @else
                            <p class="text-sm text-gray-600">No resume uploaded.</p>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('job-seekers.show', $jobSeeker->id) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-bold text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Profile
                        </a>
                        <a href="{{ route('job-seekers.edit', $jobSeeker->id) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Edit Profile
                        </a>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center p-6 bg-white border rounded-md">
                    <p class="text-gray-800 text-md">Create a profile to start applying for jobs.</p>
                    <a href="{{ route('job-seekers.create') }}"
                        class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out border sm:w-auto sm:px-6 hover:bg-gray-100">
                        <x-coolicon-add-plus-circle class="w-6 h-6 mr-2" /> Create My Profile
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
