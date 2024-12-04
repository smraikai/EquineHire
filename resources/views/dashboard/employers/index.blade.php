@extends('layouts.app')

@php
    $metaTitle = 'Employer Profile | EquineHire';
    $pageTitle = 'Employer Profile';
@endphp

@section('content')
    <div class="container px-4 py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($employer)
                <div class="p-6 m-4 bg-white rounded-lg shadow-sm sm:m-0">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Employer Name</label>
                        <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                            <p class="px-3 py-2">{{ $employer->name }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                            <div class="px-3 py-2">{!! $employer->description !!}</div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Address</label>
                        <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                            <p class="px-3 py-2">
                                @php
                                    $addressParts = array_filter([
                                        $employer->street_address,
                                        $employer->city,
                                        $employer->state,
                                        $employer->postal_code,
                                        $employer->country,
                                    ]);
                                @endphp
                                {{ !empty($addressParts) ? implode(', ', $addressParts) : 'No address provided' }}
                            </p>
                        </div>
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        @if ($employer->website)
                            <div class="block w-full mt-1 bg-gray-100 border rounded-md">
                                <p class="px-3 py-2">
                                    {{ $employer->website }}
                                </p>
                            @else
                                <div class="block w-full mt-1">
                                    <p class="text-sm text-gray-600">No website provided</p>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Employer Logo</label>
                    <div class="block w-full mt-1">
                        @if ($employer->logo)
                            <img src="{{ Storage::url($employer->logo) }}" alt="Employer Logo"
                                class="object-cover w-32 h-32 rounded-md">
                        @else
                            <p class="text-sm text-gray-600">No logo uploaded.</p>
                        @endif
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block mb-2 text-sm font-medium text-gray-700">Cover Image</label>
                    @if ($employer->featured_image)
                        <img src="{{ Storage::url($employer->featured_image) }}" alt="Featured image"
                            class="object-cover w-64 h-32 rounded-md">
                    @else
                        <p class="text-sm text-gray-600">No cover image uploaded.</p>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('employers.show', $employer->id) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-bold text-blue-600 bg-white border border-blue-600 rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        View Profile
                    </a>
                    <a href="{{ route('employers.edit', $employer->id) }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Profile
                    </a>
                </div>
            @else
                <div class="flex flex-col items-center p-6 bg-white border rounded-md">
                    <p class="text-gray-800 text-md">Create an Employer Profile to start posting
                        your job listings.</p>
                    <a href="{{ route('employers.create') }}"
                      <div class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out border sm:w-auto sm:px-6 hover:bg-gray-100">
                        <x-heroicon-o-plus-circle class="w-6 h-6 mr-2" /> Create Employer Profile
                      </div>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
