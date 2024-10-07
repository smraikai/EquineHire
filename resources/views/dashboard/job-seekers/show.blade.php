<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Job Seeker Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="mb-2 text-lg font-semibold">Skills</h3>
                    <p class="mb-4">{{ $jobSeeker->skills }}</p>

                    <h3 class="mb-2 text-lg font-semibold">Experience</h3>
                    <p class="mb-4">{{ $jobSeeker->experience }}</p>

                    <h3 class="mb-2 text-lg font-semibold">Resume</h3>
                    <a href="{{ Storage::url($jobSeeker->resume_path) }}" class="text-blue-600 hover:underline"
                        target="_blank">View Resume</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
