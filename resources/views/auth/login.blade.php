@extends('layouts.app')

@php
    $metaTitle = 'Login | EquineHire';
@endphp

@section('content')
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side: Login form -->
        <div class="flex items-center justify-center w-full px-4 py-8 md:w-1/2">
            <div class="w-full max-w-xl">
                <p class="mb-8 text-sm md:text-base">Not a business owner? <a href="{{ route('jobs.index') }}"
                        class="text-blue-600 hover:text-blue-800">Explore Equine services in
                        your area</a>.</p>

                <div class="mb-8">
                    <h1 class="mb-2 text-3xl font-bold md:text-4xl fancy-title">Business Owner Login</h1>
                    <p class="text-base text-gray-600 md:text-lg">Log in to access your account and manage your services.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-4">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block w-full mt-1" type="email" name="email"
                            :value="old('email')" required autofocus autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required
                            autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="block mb-4">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500"
                                name="remember">
                            <span class="text-sm text-gray-600 ms-2">{{ __('Remember me') }}</span>
                        </label>
                    </div>

                    <div class="flex flex-col mt-6">
                        <x-secondary-button class="justify-center mb-4">
                            {{ __('Log in') }}
                        </x-secondary-button>

                        <div class="flex items-center justify-between">
                            @if (Route::has('password.request'))
                                <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                                    {{ __('Forgot your password?') }}
                                </a>
                            @endif
                            <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('register') }}">
                                {{ __('Need an account?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right side: Full-size image (hidden on mobile) -->
        <div class="relative hidden w-1/2 md:block">
            <img src="https://EquineHire-static-assets.s3.amazonaws.com/equine_pro_finder_register.jpg" alt="Login Image"
                class="object-cover w-full h-full max-h-screen">
            <div class="absolute inset-0 bg-gradient-to-br from-black/70 to-transparent"></div>
        </div>
    </div>
@endsection
