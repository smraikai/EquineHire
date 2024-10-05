@extends('layouts.site')

@section('content')
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side: Registration form -->
        <div class="flex items-center justify-center w-full px-4 py-8 md:w-1/2">
            <div class="w-full max-w-xl">
                <div class="mb-8">
                    <h1 class="mb-6 text-3xl font-bold md:text-4xl fancy-title">
                        {{ $is_employer ? 'Create Employer Account' : 'Create Job Seeker Account' }}
                    </h1>
                    <p class="text-gray-600">
                        @if ($is_employer)
                            Register as an employer to post job listings and find the perfect candidates for your equine
                            business.
                        @else
                            Create your job seeker account to explore exciting opportunities in the equine industry and
                            connect with potential employers.
                        @endif
                    </p>
                </div>

                @if (session('error'))
                    <div class="relative px-4 py-3 mb-4 text-red-700 bg-red-100 border border-red-400 rounded" role="alert">
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="is_employer" value="{{ $is_employer ? '1' : '0' }}">

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

                    <div class="mt-6">
                        <x-secondary-button type="submit" class="justify-center w-full">
                            {{ __('Register') }}
                        </x-secondary-button>
                    </div>

                    <div class="mt-6 text-center">
                        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                            {{ __('Already registered?') }}
                        </a>
                        @if ($is_employer)
                            <span class="mx-2">|</span>
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('register.job_seeker') }}">
                                {{ __('Not an employer?') }}
                            </a>
                        @endif
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
@endsection
