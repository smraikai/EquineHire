@extends('layouts.app')

@php
    $metaTitle = 'Employer Profile | EquineHire';
    $pageTitle = 'Employer Profile';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if ($employer)
                <div class="p-6 bg-white rounded-lg shadow-sm">
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Employer Name</label>
                        <div class="block w-full mt-1">
                            <p class="px-3 py-2">{{ $employer->name }}</p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <div class="block w-full mt-1 min-h-[200px]">
                            <div class="px-3 py-2">{!! $employer->description !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">City</label>
                            <div class="block w-full mt-1">
                                <p class="px-3 py-2">{{ $employer->city }}</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">State</label>
                            <div class="block w-full mt-1">
                                <p class="px-3 py-2">{{ $employer->state }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">Website</label>
                        <div class="block w-full mt-1">
                            <p class="px-3 py-2 text-blue-500"><a
                                    href="{{ $employer->website }}">{{ $employer->website }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Employer Logo</label>
                        <div class="block w-full mt-1">
                            @if ($employer->logo_url)
                                <img src="{{ $employer->logo_url }}" alt="Employer Logo"
                                    class="object-cover w-32 h-32 rounded-md">
                            @else
                                <p class="text-sm text-gray-600">No logo uploaded.</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Additional Photos</label>
                        @if ($employer->photos->isNotEmpty())
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                                @foreach ($employer->photos as $photo)
                                    <div class="block w-full mt-1">
                                        <img src="{{ $photo->url }}" alt="Additional Photo"
                                            class="w-full h-32 rounded-md">
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-600">No additional photos uploaded.</p>
                        @endif
                    </div>

                    <!-- Edit Button -->
                    <div class="flex justify-end">
                        <a href="{{ route('employers.edit', $employer->id) }}"
                            class="inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Edit Profile
                        </a>
                    </div>
                </div>
            @else
                <div class="flex flex-col items-center p-6 bg-white border rounded-md">
                    <p class="text-sm text-gray-600">You don't have an employer profile yet.</p>
                    <a href="{{ route('employers.create') }}"
                        class="inline-flex items-center justify-center w-full px-4 py-2 mt-4 text-sm font-bold transition-colors duration-200 ease-in-out bordersm:w-auto sm:px-6 hover:bg-gray-100">
                        <x-coolicon-add-plus-circle class="w-6 h-6 mr-2" /> Create Employer Profile
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
