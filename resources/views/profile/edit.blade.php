@extends('layouts.app')

@php
    $metaTitle = 'Edit Account Info | EquineHire';
@endphp


@section('content')
    <header class="text-white bg-blue-700">
        <div class="px-4 py-6 mx-auto sm:px-6 lg:px-8 max-w-7xl">
            <div class="flex items-center justify-between">
                <h1 class="text-xl font-semibold leading-tight sm:text-2xl">Edit Account Information</h1>
                <a href="{{ route('businesses.index') }}"
                    class="text-white transition duration-150 ease-in-out hover:text-gray-200">
                    <span class="mr-2">&larr;</span> Back to Dashboard
                </a>
            </div>
        </div>
    </header>

    <div class="py-12 mx-auto ">
        <div class="max-w-2xl mx-auto space-y-6 sm:px-6 lg:px-8">
            <div class="max-w-2xl py-4">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="max-w-2xl py-4">
                @include('profile.partials.update-password-form')
            </div>

            <div class="max-w-2xl py-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
@endsection
