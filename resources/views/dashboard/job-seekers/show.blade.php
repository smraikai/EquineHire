<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Seeker Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-2">Skills</h3>
                    <p class="mb-4">{{ $jobSeeker->skills }}</p>

                    <h3 class="text-lg font-semibold mb-2">Experience</h3>
                    <p class="mb-4">{{ $jobSeeker->experience }}</p>

                    <h3 class="text-lg font-semibold mb-2">Resume</h3>
                    <a href="{{ Storage::url($jobSeeker->resume_path) }}" class="text-blue-600 hover:underline"
                        target="_blank">View Resume</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
