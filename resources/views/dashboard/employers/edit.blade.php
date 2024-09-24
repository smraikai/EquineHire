@extends('layouts.app')

@php
    $hasName = isset($employer) && !empty($employer->name);
    $metaTitle = $hasName ? 'Edit Employer Profile | EquineHire' : 'Add New Employer | EquineHire';
    $pageTitle = $hasName ? 'Edit Employer Profile' : 'Create Employer Profile';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <form action="{{ route('employers.update', $employer->id) }}" method="POST" enctype="multipart/form-data"
                class="p-6 bg-white rounded-lg shadow-sm">
                @csrf
                @method('PUT')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Employer Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                        value="{{ old('name', $employer->name ?? '') }}" required
                        placeholder="Enter your company or organization name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description <span
                            class="text-red-500">*</span></label>
                    <div id="quill_editor"
                        class="block w-full mt-1 border-gray-300 rounded-b-md rounded-t-none shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror"
                        style="height: 200px;"></div>
                    <input type="hidden" name="description" id="description"
                        value="{{ old('description', $employer->description ?? '') }}" required>
                    @error('description')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 mb-6 sm:grid-cols-2">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700">City <span
                                class="text-red-500">*</span></label>
                        <input type="text" name="city" id="city"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('city') border-red-500 @enderror"
                            value="{{ old('city', $employer->city ?? '') }}" required
                            placeholder="Enter your company's city">
                        @error('city')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700">State <span
                                class="text-red-500">*</span></label>
                        <select name="state" id="state"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('state') border-red-500 @enderror"
                            required>
                            <option value="">Select your company's state</option>
                            @foreach ($states as $abbr => $name)
                                <option value="{{ $abbr }}"
                                    {{ old('state', $employer->state ?? '') == $abbr ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('state')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-6">
                    <label for="website" class="block text-sm font-medium text-gray-700">Website</label>
                    <input type="url" name="website" id="website"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('website') border-red-500 @enderror"
                        value="{{ old('website', $employer->website ?? '') }}" placeholder="https://www.yourcompany.com">
                    <p class="mt-1 ml-1 text-xs text-gray-500">https:// is required</p>
                    @error('website')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">Employer Logo</label>
                    <div id="logo-uploader"></div>
                    <p class="mt-1 ml-1 text-xs text-gray-500">Upload your company logo (max 3MB)</p>
                </div>
                <input type="hidden" name="logo_path" id="logo_path">

                <div class="mb-6">
                    <label for="featured_image" class="block mb-2 text-sm font-medium text-gray-700">Featured Image</label>
                    <div id="featured-image-uploader"></div>
                    <p class="mt-1 ml-1 text-xs text-gray-500">Upload up a featured image to showcase your business.</p>
                </div>
                <input type="hidden" id="featured_image_path" name="featured_image_path">

                <div class="flex items-center justify-end mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
                        {{ isset($employer) && $employer->exists ? 'Update Employer Profile' : 'Create Profile' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts_css')
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
    <link href="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script src="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.js"></script>
    @include('dashboard.employers.scripts.uppy')
    @include('partials.scripts._quill_editor', [
        'placeholder' => 'Describe your company, its mission, and what makes it a great place to work',
    ])
    <script>
        // Auto prepend https:// to website input
        const websiteInput = document.getElementById('website');
        websiteInput.addEventListener('blur', function() {
            if (websiteInput.value && !websiteInput.value.startsWith('http://') && !websiteInput.value
                .startsWith('https://')) {
                websiteInput.value = 'https://' + websiteInput.value;
            }
        });
    </script>
@endsection
