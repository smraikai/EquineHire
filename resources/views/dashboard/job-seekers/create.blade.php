@extends('layouts.app')

@php
    $metaTitle = 'Create Your Profile | EquineHire';
    $pageTitle = 'Create Your Profile';
@endphp

@section('content')
    <div class="container relative py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('dashboard.job_seekers.store') }}" method="POST" enctype="multipart/form-data"
                class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name</label>
                        <input type="text" name="full_name" id="full_name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required value="{{ old('full_name') }}">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="email"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required value="{{ old('email') }}">
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
                        <input type="tel" name="phone_number" id="phone_number"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required value="{{ old('phone_number') }}">
                    </div>

                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <input type="text" name="location" id="location"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required value="{{ old('location') }}">
                    </div>

                    <div>
                        <label for="bio" class="block text-sm font-medium text-gray-700">Bio</label>
                        <textarea name="bio" id="bio" rows="3"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            required>{{ old('bio') }}</textarea>
                    </div>

                    <div>
                        <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        <input type="file" name="profile_picture" id="profile_picture" class="block w-full mt-1"
                            accept="image/*">
                    </div>

                    <div>
                        <label for="resume" class="block text-sm font-medium text-gray-700">Resume</label>
                        <input type="file" name="resume" id="resume" class="block w-full mt-1" required
                            accept=".pdf,.doc,.docx">
                    </div>

                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25">
                            Create Profile
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
