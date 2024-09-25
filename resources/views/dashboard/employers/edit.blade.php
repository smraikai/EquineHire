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
                    @if ($employer->logo)
                        <div class="flex items-center mb-2">
                            <img src="{{ $employer->logo_url }}" alt="{{ $employer->name }} logo"
                                class="max-w-[200px] max-h-[100px] object-contain">
                            <button type="button" id="replace-logo"
                                class="px-3 py-1 ml-4 text-sm text-gray-800 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Replace logo
                            </button>
                            <button type="button" id="delete-logo"
                                class="px-3 py-1 ml-2 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete logo
                            </button>
                        </div>
                    @else
                        <p class="mt-1 ml-1 text-xs text-gray-500">Upload your company logo (max 3MB)</p>
                    @endif
                    <div id="logo-uploader" class="{{ $employer->logo ? 'hidden' : '' }}"></div>
                </div>
                <input type="hidden" name="logo_path" id="logo_path" value="{{ $employer->logo }}">

                <div class="mb-6">
                    <label for="featured_image" class="block mb-2 text-sm font-medium text-gray-700">Featured Image</label>
                    @if ($employer->featured_image)
                        <div class="flex items-center mb-2">
                            <img src="{{ Storage::url($employer->featured_image) }}"
                                alt="{{ $employer->name }} featured image"
                                class="max-w-[300px] max-h-[150px] object-contain">
                            <button type="button" id="replace-featured-image"
                                class="px-3 py-1 ml-4 text-sm text-gray-800 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Replace image
                            </button>
                            <button type="button" id="delete-featured-image"
                                class="px-3 py-1 ml-2 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                Delete image
                            </button>
                        </div>
                    @else
                        <p class="mt-1 ml-1 text-xs text-gray-500">Upload a featured image to showcase your business.</p>
                    @endif
                    <div id="featured-image-uploader" class="{{ $employer->featured_image ? 'hidden' : '' }}"></div>
                </div>
                <input type="hidden" id="featured_image_path" name="featured_image_path"
                    value="{{ $employer->featured_image }}">


                <div class="flex items-center justify-between mt-8">
                    <a href="{{ route('employers.index') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Cancel
                    </a>
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const replaceLogo = document.getElementById('replace-logo');
            const replaceFeaturedImage = document.getElementById('replace-featured-image');
            const deleteLogo = document.getElementById('delete-logo');
            const deleteFeaturedImage = document.getElementById('delete-featured-image');

            if (replaceLogo) {
                replaceLogo.addEventListener('click', function() {
                    const logoUploader = document.getElementById('logo-uploader');
                    if (logoUploader) {
                        logoUploader.classList.remove('hidden');
                        this.closest('.mb-2')?.classList.add('hidden');
                    }
                });
            }

            if (replaceFeaturedImage) {
                replaceFeaturedImage.addEventListener('click', function() {
                    const featuredImageUploader = document.getElementById('featured-image-uploader');
                    if (featuredImageUploader) {
                        featuredImageUploader.classList.remove('hidden');
                        this.closest('.mb-2')?.classList.add('hidden');
                    }
                });
            }

            if (deleteLogo) {
                deleteLogo.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete the logo?')) {
                        deleteImage('logo');
                    }
                });
            }

            if (deleteFeaturedImage) {
                deleteFeaturedImage.addEventListener('click', function() {
                    if (confirm('Are you sure you want to delete the featured image?')) {
                        deleteImage('featured_image');
                    }
                });
            }

            function deleteImage(type) {
                const pathElement = document.getElementById(type === 'logo' ? 'logo_path' : 'featured_image_path');
                if (!pathElement) return;

                fetch('{{ route('upload.delete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            path: pathElement.value,
                            type: type,
                            employer_id: '{{ $employer->id }}'
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            const imgSelector =
                                `img[alt="{{ $employer->name }} ${type === 'logo' ? 'logo' : 'featured image'}"]`;
                            const img = document.querySelector(imgSelector);
                            if (img) {
                                const parentContainer = img.closest('.mb-2');
                                if (parentContainer) parentContainer.remove();
                            }

                            pathElement.value = '';

                            const uploaderId = type === 'logo' ? 'logo-uploader' : 'featured-image-uploader';
                            const uploaderElement = document.getElementById(uploaderId);
                            if (uploaderElement) {
                                uploaderElement.classList.remove('hidden');
                            } else {
                                console.error(`Uploader element with ID "${uploaderId}" not found`);
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while deleting the image. Please try again.');
                    });
            }
        });
    </script>
@endsection
