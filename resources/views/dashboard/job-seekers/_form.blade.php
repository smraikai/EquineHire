@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        <label for="full_name" class="block text-sm font-medium text-gray-700">Full Name <span
                class="text-red-500">*</span></label>
        <input type="text" name="full_name" id="full_name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('full_name') border-red-500 @enderror"
            value="{{ old('full_name', $jobSeeker->full_name ?? '') }}" required placeholder="Enter your full name">
        @error('full_name')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">Email <span
                    class="text-red-500">*</span></label>
            <input type="email" name="email" id="email"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email') border-red-500 @enderror"
                value="{{ old('email', $jobSeeker->email ?? '') }}" required placeholder="Enter your email address">
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="phone_number" class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('phone_number') border-red-500 @enderror"
                value="{{ old('phone_number', $jobSeeker->phone_number ?? '') }}" placeholder="Enter your phone number">
            @error('phone_number')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">City <span
                    class="text-red-500">*</span></label>
            <input type="text" name="city" id="city"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('city') border-red-500 @enderror"
                value="{{ old('city', $jobSeeker->city ?? '') }}" required placeholder="Enter your city">
            @error('city')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="state" class="block text-sm font-medium text-gray-700">State <span
                    class="text-red-500">*</span></label>
            <select name="state" id="state"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('state') border-red-500 @enderror"
                required>
                <option value="">Select your state</option>
                @foreach ($states as $abbr => $name)
                    <option value="{{ $abbr }}"
                        {{ old('state', $jobSeeker->state ?? '') == $abbr ? 'selected' : '' }}>
                        {{ $name }}
                    </option>
                @endforeach
            </select>
            @error('state')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>


    <div>
        <label for="bio" class="block mb-2 text-sm font-medium text-gray-700">Bio</label>
        <div id="bio_editor"></div>
        <input type="hidden" name="bio" id="bio" value="{{ old('bio', $jobSeeker->bio ?? '') }}">
        @error('bio')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>


    <div>
        <label for="profile_picture" class="block mb-2 text-sm font-medium text-gray-700">Profile Picture</label>
        @if ($jobSeeker->profile_picture_url)
            <div class="flex flex-col items-start mb-2 sm:flex-row sm:items-center">
                <img src="{{ Storage::url($jobSeeker->profile_picture_url) }}"
                    alt="{{ $jobSeeker->full_name }} profile picture"
                    class="object-cover w-32 h-32 mb-2 rounded-full sm:mb-0">
                <div class="flex flex-wrap gap-2 sm:ml-4">
                    <button type="button" id="replace-profile-picture"
                        class="px-3 py-1 text-sm text-gray-800 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Replace picture
                    </button>
                    <button type="button" id="delete-profile-picture"
                        class="px-3 py-1 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete picture
                    </button>
                </div>
            </div>
        @endif
        <div id="profile-picture-uploader" class="{{ $jobSeeker->profile_picture_url ? 'hidden' : '' }}"></div>
    </div>
    <input type="hidden" name="profile_picture_url" id="profile_picture_url"
        value="{{ $jobSeeker->profile_picture_url }}">
    <div>
        <label for="resume" class="block mb-2 text-sm font-medium text-gray-700">Resume</label>
        @if ($jobSeeker->resume_url)
            <div class="flex items-center justify-between p-4 border rounded-md">
                <div class="flex items-center">
                    <x-heroicon-o-document-text class="w-8 h-8 text-blue-500" />
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900">Resume on File</h3>
                        <p class="text-sm text-gray-500">Your current resume is uploaded and ready.</p>
                    </div>
                </div>
                <div class="flex space-x-2">
                    <button type="button" id="replace-resume"
                        class="px-3 py-1 text-sm text-gray-800 bg-white border border-gray-300 rounded shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Replace resume
                    </button>
                    <button type="button" id="delete-resume"
                        class="px-3 py-1 text-sm text-red-600 bg-white border border-red-300 rounded shadow-sm hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        Delete resume
                    </button>
                </div>
            </div>
        @endif
        <div id="resume-uploader" class="{{ $jobSeeker->resume_url ? 'hidden' : '' }}"></div>
    </div>

    <input type="hidden" id="resume_url" name="resume_url" value="{{ $jobSeeker->resume_url }}">

    <div class="flex flex-col-reverse items-end justify-end gap-4 sm:flex-row">
        <a href="{{ route('dashboard.job-seekers.index') }}"
            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm sm:w-auto hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Cancel
        </a>
        <button type="submit"
            class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition bg-blue-600 border border-transparent rounded-md sm:w-auto hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
            {{ isset($jobSeeker) && $jobSeeker->exists ? 'Update Profile' : 'Create Profile' }}
        </button>
    </div>
</div>
