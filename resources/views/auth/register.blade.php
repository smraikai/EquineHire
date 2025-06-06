@extends('layouts.auth')

@php
    $metaTitle = 'Register | EquineHire';
@endphp

@section('content')
    <div class="p-8 bg-white border rounded-lg">
        <div class="mb-8">
            <h1 class="mb-6 text-2xl font-bold md:text-2xl fancy-title">Account Registration</h1>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Account Type Selection -->
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-700">Account Type</label>
                <div class="grid grid-cols-1 gap-4 mt-4 sm:grid-cols-2">
                    <label
                        class="relative flex flex-col p-4 bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500">
                        <span class="flex items-center justify-between mb-4">
                            <span class="block text-sm font-medium text-gray-900">Employer</span>
                            <input type="radio" name="account_type" value="employer"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" required
                                {{ session()->has('selected_plan') || request()->query('type') === 'employer' ? 'checked' : '' }}>
                        </span>
                        <span class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Post jobs and find candidates
                        </span>
                    </label>

                    <label
                        class="relative flex flex-col p-4 bg-white border border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 focus-within:ring-2 focus-within:ring-blue-500">
                        <span class="flex items-center justify-between mb-4">
                            <span class="block text-sm font-medium text-gray-900">Job Seeker</span>
                            <input type="radio" name="account_type" value="jobseeker"
                                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500" required
                                {{ request()->query('account_type') === 'jobseeker' ? 'checked' : '' }}>
                        </span>
                        <span class="flex items-center text-sm text-gray-500">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            Find and apply for jobs
                        </span>
                    </label>
                </div>
                <x-input-error :messages="$errors->get('account_type')" class="mt-2" />
            </div>

            <!-- Name -->
            <div class="mb-4">
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')"
                    required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email')"
                    required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                    autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex flex-col mt-6">
                <x-secondary-button class="justify-center mb-4">
                    {{ __('Sign Up') }}
                </x-secondary-button>
            </div>
        </form>
    </div>

    <div class="mt-4 text-center">
        <p class="text-sm text-gray-600">
            Already have an account?
            <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:underline">Log in</a>
        </p>
    </div>
@endsection
