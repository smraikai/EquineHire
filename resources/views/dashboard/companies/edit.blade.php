@extends('layouts.app')

@php
    $metaTitle = isset($company) ? 'Edit Company | EquineHire' : 'Add New Company | EquineHire';
    $pageTitle = isset($company) ? 'Edit Company' : 'Add New Company';
@endphp

@section('content')
    <div class="container py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <h1 class="mb-6 text-xl font-semibold text-gray-900">{{ $pageTitle }}</h1>

            <form action="{{ isset($company) ? route('companies.update', $company) : route('companies.store') }}"
                method="POST" class="p-6 bg-white rounded-lg shadow-sm" enctype="multipart/form-data">
                @csrf
                @if (isset($company))
                    @method('PUT')
                @endif

                @if ($errors->any())
                    <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Company Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('name') border-red-500 @enderror"
                        value="{{ old('name', $company->name ?? '') }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700">Description <span
                            class="text-red-500">*</span></label>
                    <div id="quill_editor"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror"
                        style="height: 200px;"></div>
                    <input type="hidden" name="description" id="description"
                        value="{{ old('description', $company->description ?? '') }}" required>
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
                            value="{{ old('city', $company->city ?? '') }}" required>
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
                            <option value="">Select a state</option>
                            @foreach ($states as $abbr => $name)
                                <option value="{{ $abbr }}"
                                    {{ old('state', $company->state ?? '') == $abbr ? 'selected' : '' }}>
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
                        value="{{ old('website', $company->website ?? '') }}">
                    @error('website')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="logo" class="block mb-2 text-sm font-medium text-gray-700">Company Logo</label>
                    <input type="file" name="logo" id="logo" class="filepond" accept="image/*">
                    @error('logo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="photos" class="block mb-2 text-sm font-medium text-gray-700">Additional Photos</label>
                    <input type="file" name="photos[]" id="photos" multiple class="filepond" accept="image/*">
                    @error('photos')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="is_active" class="inline-flex items-center">
                        <input type="checkbox" name="is_active" id="is_active"
                            class="text-blue-600 border-gray-300 rounded shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                            value="1" {{ old('is_active', $company->is_active ?? false) ? 'checked' : '' }}>
                        <span class="ml-2 text-sm text-gray-600">Active</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-8">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
                        {{ isset($company) ? 'Update Company' : 'Create Company' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts_css')
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.0/dist/quill.snow.css" rel="stylesheet">
@endsection

@section('scripts')
    @include('partials.scripts._quill_editor')
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginFileValidateType);
            FilePond.registerPlugin(FilePondPluginImagePreview);

            // Logo upload
            FilePond.create(document.querySelector('input[name="logo"]'), {
                acceptedFileTypes: ['image/*'],
                server: {
                    process: '/upload-temp',
                    revert: '/remove-temp',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });

            // Additional photos upload
            FilePond.create(document.querySelector('input[name="photos[]"]'), {
                acceptedFileTypes: ['image/*'],
                allowMultiple: true,
                server: {
                    process: '/upload-temp',
                    revert: '/remove-temp',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            });
        });
    </script>
@endsection
