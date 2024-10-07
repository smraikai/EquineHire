@extends('layouts.app')

@php
    $metaTitle = 'Job Seeker Profile | EquineHire';
    $pageTitle = 'Job Seeker Profile';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($jobSeeker)
                <div class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                <p class="px-3 py-2">{{ $jobSeeker->full_name }}</p>
                            </div>
                        </div>

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

                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">City</label>
                                <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                    <p class="px-3 py-2">{{ $jobSeeker->city }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">State</label>
                                <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                    <p class="px-3 py-2">{{ $jobSeeker->state }}</p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                <div class="px-3 py-2 bio">{!! $jobSeeker->bio !!}</div>
                            </div>
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Profile Picture</label>
                            @if ($jobSeeker->profile_picture_url)
                                <div class="flex flex-col items-start mb-2 sm:flex-row sm:items-center">
                                    <img src="{{ Storage::url($jobSeeker->profile_picture_url) }}"
                                        alt="{{ $jobSeeker->full_name }} profile picture"
                                        class="object-cover w-32 h-32 mb-2 rounded-full sm:mb-0">
                                </div>
                            @else
                                <p class="text-sm text-gray-600">No profile picture uploaded.</p>
                            @endif
                        </div>

                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">Resume</label>
                            @if ($jobSeeker->resume_url)
                                <div class="flex items-center justify-between p-4 border rounded-md">
                                    <div class="flex items-center">
                                        <x-heroicon-o-document-text class="w-8 h-8 text-blue-500" />
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-gray-900">Resume on File</h3>
                                            <p class="text-sm text-gray-500">Current resume is uploaded and ready.</p>
                                        </div>
                                    </div>
                                    <a href="{{ Storage::url($jobSeeker->resume_url) }}" target="_blank"
                                        class="px-3 py-1 text-sm text-blue-600 bg-white border border-blue-300 rounded shadow-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        View Resume
                                    </a>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">No resume uploaded.</p>
                            @endif
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col-reverse items-end justify-end gap-4 sm:flex-row">
                            <form action="{{ route('job-seekers.destroy', $jobSeeker->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to delete your profile? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-4 py-2 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    Delete Profile
                                </button>
                            </form>
                            <a href="{{ route('job-seekers.edit', $jobSeeker->id) }}"
                                class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold tracking-widest text-white transition bg-blue-600 border border-transparent rounded-md sm:w-auto hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
                                Edit Profile
                            </a>
                        </div>

                    </div>
                </div>
            @else
                <div class="flex flex-col items-center p-6 bg-white border rounded-md">
                    <p class="text-gray-800 text-md">Create a profile to start applying for jobs.</p>
                    <a href="{{ route('job-seekers.create') }}"
                        class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out border sm:w-auto sm:px-6 hover:bg-gray-100">
                        <x-heroicon-o-plus-circle class="w-6 h-6 mr-2" /> Create My Profile
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
