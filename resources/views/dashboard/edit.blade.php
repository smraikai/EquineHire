@extends('layouts.app')

@php
    $metaTitle = 'Edit Business Listing | EquineHire';
@endphp

@section('scripts_css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />
    <style>
        .loader,
        .loader:before,
        .loader:after {
            border-radius: 50%;
            width: 2.5em;
            height: 2.5em;
            animation: bblFadInOut 1.8s infinite ease-in-out;
            animation-fill-mode: both
        }

        .loader {
            color: #10b981;
            font-size: 7px;
            position: relative;
            text-indent: -9999em;
            transform: translateZ(0);
            animation-delay: -.16s;
            display: inline-block;
            margin-right: 10px
        }

        .loader:before,
        .loader:after {
            content: '';
            position: absolute;
            top: 0
        }

        .loader:before {
            left: -3.5em;
            animation-delay: -.32s
        }

        .loader:after {
            left: 3.5em
        }

        @keyframes bblFadInOut {

            0%,
            80%,
            100% {
                box-shadow: 0 2.5em 0 -1.3em
            }

            40% {
                box-shadow: 0 2.5em 0 0
            }
        }
    </style>

    <!-- Filepond -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
@endsection

@section('content')
    @include('partials._admin_bar_top')

    <div class="container px-4 pt-3 pb-16 mx-auto my-6 sm:px-6 lg:px-8 max-w-7xl sm:my-0">

        <div class="flex">
            <!-- Sidebar -->
            <div class="sticky self-start hidden w-64 py-6 mx-auto overflow-auto top-5 lg:block">
                <h1 class="mb-4 text-xl font-bold">Quick Navigation:</h1>
                <ul class="p-0 text-gray-500">
                    <li class="mb-2">
                        <a href="#details"
                            class="flex items-center gap-1 p-2 transition duration-150 ease-in-out rounded-md hover:bg-gray-200">
                            <x-coolicon-list-unordered class="w-5" /> Details</a>
                    </li>
                    <li class="mb-2">
                        <a href="#logo"
                            class="flex items-center gap-1 p-2 transition duration-150 ease-in-out rounded-md hover:bg-gray-200">
                            <x-coolicon-image-01 class="w-5" /> Logo</a>
                    </li>
                    <li class="mb-2">
                        <a href="#featured"
                            class="flex items-center gap-1 p-2 transition duration-150 ease-in-out rounded-md hover:bg-gray-200">
                            <x-coolicon-star class="w-5" /> Featured Image</a>
                    </li>
                    <li class="mb-2">
                        <a href="#photos"
                            class="flex items-center gap-1 p-2 transition duration-150 ease-in-out rounded-md hover:bg-gray-200">
                            <x-coolicon-camera class="w-5" /> Additional Photos</a>
                    </li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="w-full lg:p-4 lg:flex-1">
                <div class="section">
                    <div class="container px-0 mx-auto sm:px-4">
                        <div class="epf_form">
                            <form action="{{ route('businesses.update', $business->id) }}" method="POST" id="listing_form"
                                enctype="multipart/form-data" data-business-id="{{ $business->id }}">
                                @csrf
                                @method('PUT')
                                <div id="details" class="p-5 bg-white border rounded-md sm:p-10">

                                    <div class="mb-8">
                                        <h2 class="block text-xl font-bold text-gray-900">Basic Details</h2>
                                        <p class="mb-4 text-gray-600 text-md">Complete your business profile with key
                                            details like name, address, and
                                            contact info. The more details you provide, the easier it is for customers to
                                            choose you over the
                                            competition.
                                        </p>
                                        <p class="text-gray-600 text-md"></p>
                                    </div>

                                    @include('partials.form_inputs.name')
                                    @include('partials.form_inputs.categories')
                                    @include('partials.form_inputs.disciplines')
                                    @include('partials.form_inputs.description')
                                    @include('partials.form_inputs.address')
                                    @include('partials.form_inputs.email_phone')
                                    @include('partials.form_inputs.website')

                                </div>


                                <div id="logo">@include('partials.form_inputs.logo')</div>
                                <div id="featured">@include('partials.form_inputs.featured_image')</div>
                                <div id="additional-photos">@include('partials.form_inputs.additional_photos')</div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="loading-overlay" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-white bg-opacity-80">
        <span class="mb-8 loader"></span>
    </div>

    @include('partials._admin_bar_bottom')

    @if ($errors->any())
        <div x-data="{ open: true }" x-show="open" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" aria-hidden="true"
                    @click="open = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div x-show="open" x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block px-4 pt-5 pb-4 overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                    <div class="absolute top-0 right-0 pt-4 pr-2 sm:block">
                        <button type="button"
                            class="text-gray-400 bg-white rounded-md hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            @click="open = false">
                            <span class="sr-only">Close</span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div class="sm:flex sm:items-start">
                        <div
                            class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">
                                Whoops! Something went wrong.
                            </h3>
                            <div class="mt-2">
                                <ul class="pl-4 mt-2 text-sm text-gray-500 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif


@endsection

@section('scripts')
    @include('partials.scripts._google-maps-edit-address')
    @include('partials.scripts._category_discipline_selector')
    @include('partials.scripts._photo_uploads')
    @include('partials.scripts._quill_editor')
    @include('partials.scripts._validation')

    <script>
        // Bottom Bar Scrolling
        document.addEventListener('scroll', function() {
            const footer = document.getElementById('scrollingFooter');
            if (window.scrollY > 100) {
                footer.classList.add('visible');
            } else {
                footer.classList.remove('visible');
            }
        });

        // Close Modal
        function closeModal(event) {
            // This function is used for the backdrop click
            if (event.target.classList.contains('inset-0')) {
                closeModalDirectly();
            }
        }

        function closeModalDirectly(event) {
            if (event) {
                event.stopPropagation(); // Stop the event from bubbling up when 'X' is clicked
            }
            document.querySelector('.fixed.inset-0').style.display = 'none';
        }
    </script>
@endsection
