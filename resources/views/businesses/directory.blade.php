@extends('layouts.app')

@php
    // Meta Tags
    $metaTitle = 'Explore Equine Services | EquineHire';
    $metaDescription =
        'Browse our comprehensive directory of equine professionals. Easily locate and connect with farriers, veterinarians, trainers, boarding facilities, and more in your area.';
@endphp

@section('content')
    <div class="container p-4 mx-auto mt-10 sm:p-10 max-w-7xl">
        <div class="flex flex-col gap-2">
            <div class="flex items-center text-sm">
                <a href="{{ route('home') }}" class="text-emerald-600 hover:text-emerald-700">Home</a>
                <x-coolicon-chevron-right-md class="w-5 h-5 mx-2 text-gray-400" />
                <span class="text-gray-600">Find Services</span>
            </div>
            <h1 class="mb-5 text-2xl font-bold text-gray-800">Find Services</h1>
        </div>
        <div class="flex flex-col justify-around gap-5 md:flex-row">
            <div class="order-2 w-full md:w-3/4 md:order-1">
                @include('partials.directory.results')
            </div>
            <div x-data="{ isOpen: false }" class="order-1 w-full mb-5 md:w-1/4 md:order-2 md:mb-0">
                <div class="sticky p-4 bg-white border rounded-md top-5 sm:p-8">
                    <button @click="isOpen = !isOpen" class="flex items-center justify-between w-full md:hidden">
                        <span class="font-bold">Filters</span>
                        <svg x-show="!isOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                        <svg x-show="isOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                        </svg>
                    </button>
                    <div x-show="isOpen || window.innerWidth >= 768" class="mt-4 md:mt-0" x-transition>
                        @include('partials.directory.facets')
                    </div>
                </div>
            </div>


        </div>

    </div>
@endsection

@section('scripts')
@endsection
