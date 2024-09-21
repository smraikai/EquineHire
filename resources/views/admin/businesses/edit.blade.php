@extends('layouts.app')

@section('scripts_css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet" />
    <!-- Filepond -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
@endsection

@section('content')
    @include('partials._admin_bar_top')

    <div class="container px-4 pt-3 pb-16 mx-auto max-w-7xl sm:px-6 lg:px-8">

        <div class="flex">
            <!-- Sidebar -->
            <div class="sticky self-start hidden w-64 py-6 mx-auto overflow-auto top-5 md:block">
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
            <div class="flex-1 p-4">
                <div class="section">
                    <div class="container px-4 mx-auto">
                        <div class="epf_form">
                            <form action="{{ route('admin.company.update', $business->id) }}" method="POST"
                                id="listing_form" enctype="multipart/form-data" data-business-id="{{ $business->id }}">
                                @csrf
                                @method('PUT')
                                <div id="details" class="p-10 bg-white border rounded-md">
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

                                <div x-data="fileUploader()">
                                    <div id="logo">@include('partials.form_inputs.logo')</div>
                                    <div id="featured">@include('partials.form_inputs.featured_image')</div>
                                </div>
                                <div id="photos">@include('partials.form_inputs.additional_photos')</div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('partials._admin_bar_bottom')

    @if ($errors->any())
        <!-- Overlay Backdrop with onClick listener for closing -->
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-600 bg-opacity-75"
            onclick="closeModal(event)">
            <!-- Modal container - stop propagation to prevent modal content clicks from closing it -->
            <div class="w-full max-w-lg mx-3 overflow-hidden bg-white rounded-lg shadow-xl"
                onclick="event.stopPropagation()">
                <!-- Modal header -->
                <div class="flex items-center justify-between px-4 py-2 bg-red-500">
                    <h2 class="text-lg font-semibold text-white">Whoops! Something went wrong.</h2>
                    <button onclick="closeModalDirectly(event)" class="text-white hover:text-red-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                </div>
                <!-- Error list -->
                <div class="p-4">
                    <ul class="text-sm text-gray-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
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
