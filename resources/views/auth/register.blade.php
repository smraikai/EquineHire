@extends('layouts.site')

@php
    $metaTitle = 'Register | EquineHire';
@endphp

@section('content')
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side: Registration form -->
        <div class="flex items-center justify-center w-full px-4 py-8 md:w-1/2">
            <div class="w-full max-w-xl">
                <div class="mb-8">
                    <h1 class="mb-6 text-3xl font-bold md:text-4xl fancy-title">Create Your Account</h1>
                </div>

                @if (session('error'))
                    <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" id="registrationForm">
                    @csrf

                    <!-- Step 1: User Type Selection -->
                    <div id="step1" class="step {{ $hasPlanSelected ? 'hidden' : '' }}">
                        <h2 class="mb-4 text-xl font-semibold">Are you a job seeker or employer?</h2>
                        <div class="space-y-4">
                            <label class="flex items-center p-4 border rounded cursor-pointer">
                                <input type="radio" name="is_employer" value="0" class="mr-2" required>
                                <span>Job Seeker</span>
                            </label>
                            <label class="flex items-center p-4 border rounded cursor-pointer">
                                <input type="radio" name="is_employer" value="1" class="mr-2" required
                                    {{ $hasPlanSelected ? 'checked' : '' }}>
                                <span>Employer</span>
                            </label>
                        </div>
                        <div class="mt-6">
                            <x-secondary-button type="button" onclick="nextStep(1, 2)" class="justify-center w-full">
                                {{ __('Next') }}
                            </x-secondary-button>
                        </div>
                    </div>

                    <!-- Step 2: Account Details and Password -->
                    <div id="step2" class="hidden step">
                        <p class="mb-6 text-base text-gray-600 md:text-lg">Create an account to start listing your job.</p>

                        <!-- Name -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" class="block w-full mt-1" type="text" name="name"
                                :value="old('name')" required autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Email Address -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block w-full mt-1" type="email" name="email"
                                :value="old('email')" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <x-input-label for="password" :value="__('Password')" />
                            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                                autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                            <x-text-input id="password_confirmation" class="block w-full mt-1" type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        <div class="flex justify-between mt-6">
                            <x-secondary-button type="button" onclick="prevStep(2, 1)" class="justify-center">
                                {{ __('Previous') }}
                            </x-secondary-button>
                            <x-secondary-button type="submit" class="justify-center">
                                {{ __('Register') }}
                            </x-secondary-button>
                        </div>
                    </div>

                    <div class="mt-6 text-center">
                        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right side: Full-size image (hidden on mobile) -->
        <div class="relative hidden w-1/2 md:block">
            <img src="https://equinehire-static-assets.s3.amazonaws.com/horse-barn-bw-min.jpg" alt="Registration Image"
                class="object-cover w-full h-full max-h-screen">
            <div class="absolute inset-0 bg-gradient-to-br from-black/70 to-transparent"></div>
        </div>
    </div>

    <script>
        function nextStep(currentStep, nextStep) {
            document.getElementById(`step${currentStep}`).classList.add('hidden');
            document.getElementById(`step${nextStep}`).classList.remove('hidden');
        }

        function prevStep(currentStep, prevStep) {
            document.getElementById(`step${currentStep}`).classList.add('hidden');
            document.getElementById(`step${prevStep}`).classList.remove('hidden');
        }

        // Auto-select employer and move to next step if plan is selected
        document.addEventListener('DOMContentLoaded', function() {
            @if ($hasPlanSelected)
                var employerRadio = document.querySelector('input[name="is_employer"][value="1"]');
                if (employerRadio) {
                    employerRadio.checked = true;
                }
                nextStep(1, 2);
            @endif
        });
    </script>
@endsection
