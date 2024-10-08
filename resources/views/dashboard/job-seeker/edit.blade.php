@extends('layouts.site')

@php
    $metaTitle = 'Edit Profile | EquineHire';
    $pageTitle = 'Edit Profile';
@endphp

@section('content')
    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 space-y-8">
                    <div class="mb-5">
                        <h2 class="text-lg font-bold leading-7 text-gray-900 sm:tracking-tight">Edit My Information</h2>
                        <p class="mt-1 text-sm leading-6 text-gray-600">Update your personal details and contact information.
                        </p>
                    </div>

                    <form action="{{ route('job-seeker.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                                <div class="mt-2">
                                    <input type="text" name="name" id="name"
                                        value="{{ auth()->user()->jobSeeker->name }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email
                                    address</label>
                                <div class="mt-2">
                                    <input type="email" name="email" id="email"
                                        value="{{ auth()->user()->jobSeeker->email }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <label for="phone" class="block text-sm font-medium leading-6 text-gray-900">Phone
                                    number</label>
                                <div class="mt-2">
                                    <input type="tel" name="phone" id="phone"
                                        value="{{ auth()->user()->jobSeeker->phone }}"
                                        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-blue-600 sm:text-sm sm:leading-6">
                                </div>
                            </div>

                            <div>
                                <label for="resume"
                                    class="block text-sm font-medium leading-6 text-gray-900">Resume</label>
                                <div class="mt-2">
                                    @if (auth()->user()->jobSeeker->resume_path)
                                        <div id="current-resume">
                                            <p class="mb-2 text-sm text-gray-500">Current resume:</p>
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
                                                    <svg class="w-5 h-5 mr-2 text-gray-400"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                                    </svg>
                                                    <a href="{{ Storage::url(auth()->user()->jobSeeker->resume_path) }}"
                                                        class="font-medium text-blue-600 hover:text-blue-500"
                                                        target="_blank">
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
                                        class="mt-2 {{ auth()->user()->jobSeeker->resume_path ? 'hidden' : '' }}"></div>
                                    <input type="hidden" id="resume_path" name="resume_path"
                                        value="{{ auth()->user()->jobSeeker->resume_path }}">
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end mt-6 gap-x-6">
                            <a href="{{ route('dashboard.job-seeker.index') }}"
                                class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
                            <button type="submit"
                                class="px-3 py-2 text-sm font-semibold text-white bg-blue-600 rounded-md shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <link href="https://releases.transloadit.com/uppy/v3.3.1/uppy.min.css" rel="stylesheet">
@endsection

@section('scripts')
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
                    height: 200,
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
