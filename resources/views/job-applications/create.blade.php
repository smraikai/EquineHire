@extends('layouts.job-application')

@section('content')
    <div class="">
        <div class="max-w-3xl px-4 py-8 mx-auto sm:px-6 sm:py-12 lg:px-8">
            <div class="space-y-8">
                <div class="space-y-2">
                    <div class="space-y-1">
                        <p class="text-sm font-semibold tracking-wide text-center text-blue-600 uppercase">Apply For
                        </p>
                        <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-center text-gray-900 sm:text-4xl">
                            {{ $jobListing->title }}</h1>
                    </div>
                    <div class="flex items-center justify-center space-x-6">
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-building-office class="w-5 h-5 text-gray-600" />
                            <p class="text-lg text-gray-500">{{ $jobListing->employer->name }}</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-heroicon-o-map-pin class="w-5 h-5 text-gray-600" />
                            <p class="text-lg text-gray-500">
                                @if ($jobListing->remote_position)
                                    Remote
                                @else
                                    {{ $jobListing->city }}, {{ $jobListing->state }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <form action="{{ route('job-applications.store', $jobListing) }}" method="POST"
                    enctype="multipart/form-data" class="p-8 bg-white border rounded-lg shadow-sm">
                    @csrf

                    @if ($errors->any())
                        <div class="p-4 mb-6 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <p class="font-bold">Please correct the following errors:</p>
                            <ul class="mt-2 ml-4 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                        <div class="sm:col-span-6">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1">
                                <input type="text" name="name" id="name" autocomplete="name"
                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                    required placeholder="Enter your full name"
                                    value="{{ auth()->check() && !auth()->user()->is_employer ? auth()->user()->jobSeeker->name ?? auth()->user()->name : old('name') }}">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6 sm:col-span-6 sm:grid-cols-2">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <div class="mt-1">
                                    <input type="email" name="email" id="email" autocomplete="email"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        required placeholder="your.email@example.com"
                                        value="{{ auth()->check() && !auth()->user()->is_employer ? auth()->user()->jobSeeker->email ?? auth()->user()->email : old('email') }}">
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                <div class="mt-1">
                                    <input type="tel" name="phone" id="phone" autocomplete="tel"
                                        class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                        placeholder="(123) 456-7890"
                                        value="{{ auth()->check() && !auth()->user()->is_employer && auth()->user()->jobSeeker ? auth()->user()->jobSeeker->phone : old('phone') }}">
                                </div>
                            </div>
                        </div>


                        <div class="sm:col-span-6">
                            <label for="cover_letter" class="block text-sm font-medium text-gray-700">Cover
                                Letter</label>
                            <div class="mt-1">
                                <textarea id="cover_letter" name="cover_letter" rows="3"
                                    class="block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm min-h-[100px] max-h-[300px] overflow-y-auto"
                                    placeholder="Write a few sentences about why you're a great fit for this role." required
                                    oninput="this.style.height = ''; this.style.height = Math.min(this.scrollHeight, 300) + 'px'">{{ old('cover_letter') }}</textarea>
                            </div>
                        </div>

                        @guest
                            <div class="mb-4 space-y-4 sm:col-span-6">
                                <div class="flex items-start">
                                    <input id="create_account" name="create_account" type="checkbox" value="1"
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <div class="ml-3 text-sm">
                                        <label for="create_account" class="font-medium text-gray-700">Create an account
                                            to easily apply for future jobs.</label>
                                    </div>
                                </div>

                                <div id="account_fields" class="hidden sm:col-span-6">
                                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-6">
                                        <div class="sm:col-span-3">
                                            <label for="password"
                                                class="block text-sm font-medium text-gray-700">Password</label>
                                            <div class="mt-1">
                                                <input type="password" name="password" id="password"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                        </div>

                                        <div class="sm:col-span-3">
                                            <label for="password_confirmation"
                                                class="block text-sm font-medium text-gray-700">Confirm
                                                Password</label>
                                            <div class="mt-1">
                                                <input type="password" name="password_confirmation" id="password_confirmation"
                                                    class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endguest

                        <div class="sm:col-span-6">
                            <label for="resume" class="block mb-2 text-sm font-medium text-gray-700">
                                @if (auth()->check() &&
                                        !auth()->user()->is_employer &&
                                        auth()->user()->jobSeeker &&
                                        auth()->user()->jobSeeker->resume_path)
                                    Resume
                                @else
                                    Upload Resume
                                @endif
                            </label>
                            <div class="mt-2">
                                @if (auth()->check() &&
                                        !auth()->user()->is_employer &&
                                        auth()->user()->jobSeeker &&
                                        auth()->user()->jobSeeker->resume_path)
                                    <div id="current-resume">
                                        @php
                                            $resumeExtension = pathinfo(
                                                auth()->user()->jobSeeker->resume_path,
                                                PATHINFO_EXTENSION,
                                            );
                                        @endphp
                                        @if (strtolower($resumeExtension) === 'pdf')
                                            <div class="mb-4">
                                                <iframe src="{{ Storage::url(auth()->user()->jobSeeker->resume_path) }}"
                                                    class="w-full border border-gray-300 rounded-md h-96">
                                                </iframe>
                                            </div>
                                        @else
                                            <div class="flex items-center mb-4">
                                                <svg class="w-5 h-5 mr-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                                    fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                </svg>
                                                <a href="{{ Storage::url(auth()->user()->jobSeeker->resume_path) }}"
                                                    class="font-medium text-blue-600 hover:text-blue-500" target="_blank">
                                                    View Resume
                                                </a>
                                            </div>
                                        @endif
                                        <button type="button" id="replace-resume-btn"
                                            class="inline-flex items-center px-3 py-2 text-sm font-medium leading-4 text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-5 h-5 mr-2 -ml-1 text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                            </svg>
                                            Replace Resume
                                        </button>
                                    </div>
                                @endif
                                <div id="uppy-drop-target"
                                    class="{{ auth()->check() && !auth()->user()->is_employer && auth()->user()->jobSeeker && auth()->user()->jobSeeker->resume_path ? 'hidden' : '' }}">
                                </div>
                                <input type="hidden" id="resume_path" name="resume_path"
                                    value="{{ auth()->check() && !auth()->user()->is_employer && auth()->user()->jobSeeker ? auth()->user()->jobSeeker->resume_path : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="pt-5">
                        <div class="flex justify-end">
                            <button type="submit"
                                class="inline-flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Submit Application
                            </button>
                        </div>
                    </div>
                </form>

                <div class="mt-2 text-center">
                    <p class="text-sm font-medium text-gray-700">
                        By creating an account or submitting this form, you agree to our
                        <a href="{{ route('terms-of-service') }}" class="text-blue-600 hover:underline">Terms</a> and
                        <a href="{{ route('privacy-policy') }}" class="text-blue-600 hover:underline">Privacy Policy</a>.
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.css" rel="stylesheet">
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            if (phoneInput) {
                phoneInput.addEventListener('input', function(e) {
                    let x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,3})(\d{0,4})/);
                    e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
                });
            }

            // Email formatting
            const emailInput = document.getElementById('email');
            if (emailInput) {
                emailInput.addEventListener('blur', function(e) {
                    let email = e.target.value.trim().toLowerCase();
                    e.target.value = email;
                });
            }

            // Password fields visibility
            const createAccountCheckbox = document.getElementById('create_account');
            const accountFields = document.getElementById('account_fields');
            if (createAccountCheckbox && accountFields) {
                createAccountCheckbox.addEventListener('change', function() {
                    accountFields.classList.toggle('hidden', !this.checked);
                });
            }
        });
    </script>

    <script src="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uppy = new Uppy.Uppy({
                    debug: true,
                    autoProceed: true,
                    restrictions: {
                        maxFileSize: 5 * 1024 * 1024, // 5MB
                        allowedFileTypes: ['.pdf', '.doc', '.docx'],
                        maxNumberOfFiles: 1
                    }
                })
                .use(Uppy.Dashboard, {
                    inline: true,
                    target: '#uppy-drop-target',
                    proudlyDisplayPoweredByUppy: false,
                    width: '100%',
                    height: 300,
                    showProgressDetails: true,
                    hideCancelButton: true,
                    hideUploadButton: true,
                    hideRetryButton: true,
                    hidePauseResumeButton: true,
                    hideProgressAfterFinish: true,
                    singleFileFullScreen: false,
                    disableStatusBar: true,
                    disableInformer: false,
                    disableThumbnailGenerator: true,
                    showRemoveButtonAfterComplete: true
                })
                .use(Uppy.XHRUpload, {
                    endpoint: '{{ route('upload.resume') }}',
                    fieldName: 'resume',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });

            const currentResumeElement = document.getElementById('current-resume');
            const uppyDropTarget = document.getElementById('uppy-drop-target');
            const replaceResumeBtn = document.getElementById('replace-resume-btn');
            const resumePathInput = document.getElementById('resume_path');

            if (replaceResumeBtn) {
                replaceResumeBtn.addEventListener('click', function() {
                    currentResumeElement.classList.add('hidden');
                    uppyDropTarget.classList.remove('hidden');
                });
            }

            uppy.on('upload-success', (file, response) => {
                console.log('File uploaded successfully:', file.name);
                console.log('Server response:', response);
                resumePathInput.value = response.body.path;

                if (currentResumeElement) {
                    currentResumeElement.classList.add('hidden');
                }
                uppyDropTarget.classList.remove('hidden');
            });

            uppy.on('upload-error', (file, error, response) => {
                console.log('Error uploading file:', file.name);
                console.log('Error:', error);
                alert('Error uploading resume. Please try again.');
            });

            uppy.on('file-removed', (file, reason) => {
                console.log('File removed:', file.name);
                resumePathInput.value = '';

                if (currentResumeElement) {
                    currentResumeElement.classList.remove('hidden');
                    uppyDropTarget.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
