@csrf

@if ($errors->any())
    <div class="p-4 mb-6 text-red-700 bg-red-100 border border-red-400 rounded">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="space-y-6">
    <div>
        <label for="title" class="block text-sm font-medium text-gray-700">Job Title <span
                class="text-red-500">*</span></label>
        <input type="text" name="title" id="title"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('title') border-red-500 @enderror"
            value="{{ old('title', $jobListing->title ?? '') }}" placeholder="Enter job title" required>
        @error('title')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category <span
                class="text-red-500">*</span></label>
        <select name="category_id" id="category_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('category_id') border-red-500 @enderror"
            required>
            <option value="">Select a category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $jobListing->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700">Description <span
                class="text-red-500">*</span></label>
        <div id="quill_editor"
            class="max-h-[500px] overflow-auto ]mt-1 block w-full rounded-t-none rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('description') border-red-500 @enderror">
        </div>
        <input type="hidden" name="description" id="description"
            value="{{ old('description', $jobListing->description ?? '') }}" required>
        @error('description')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    @include('dashboard.job-listings._listing-strength')

    <div>
        <label class="block text-sm font-medium text-gray-700">Remote Position <span
                class="text-red-500">*</span></label>
        <div class="mt-2 space-y-2 sm:space-y-0 sm:flex sm:space-x-4">
            <div class="flex items-center">
                <input type="radio" id="remote_position_yes" name="remote_position" value="1"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('remote_position', $jobListing->remote_position ?? '') == '1' ? 'checked' : '' }} required>
                <label for="remote_position_yes" class="ml-2 text-sm text-gray-600">Yes</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="remote_position_no" name="remote_position" value="0"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('remote_position', $jobListing->remote_position ?? '') == '0' ? 'checked' : '' }} required>
                <label for="remote_position_no" class="ml-2 text-sm text-gray-600">No</label>
            </div>
        </div>
        @error('remote_position')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="location_fields" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4" style="display: none;">
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700">City <span
                    class="text-red-500">*</span></label>
            <input type="text" name="city" id="city"
                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('city') border-red-500 @enderror"
                value="{{ old('city', $jobListing->city ?? '') }}">
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
                <option value="">Select a state</option>
                @foreach ($states as $abbr => $name)
                    <option value="{{ $abbr }}"
                        {{ old('state', $jobListing->state ?? '') == $abbr ? 'selected' : '' }}>
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
        <label for="job_type" class="block text-sm font-medium text-gray-700">Job Type <span
                class="text-red-500">*</span></label>
        <select name="job_type" id="job_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('job_type') border-red-500 @enderror"
            required>
            <option value="">Select Job Type</option>
            <option value="full-time"
                {{ old('job_type', $jobListing->job_type ?? '') == 'full-time' ? 'selected' : '' }}>Full Time</option>
            <option value="part-time"
                {{ old('job_type', $jobListing->job_type ?? '') == 'part-time' ? 'selected' : '' }}>Part Time</option>
            <option value="contract"
                {{ old('job_type', $jobListing->job_type ?? '') == 'contract' ? 'selected' : '' }}>Contract</option>
            <option value="temporary"
                {{ old('job_type', $jobListing->job_type ?? '') == 'temporary' ? 'selected' : '' }}>Temporary</option>
        </select>
        @error('job_type')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="experience_required" class="block text-sm font-medium text-gray-700">Experience Required <span
                class="text-red-500">*</span></label>
        <select name="experience_required" id="experience_required"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('experience_required') border-red-500 @enderror"
            required>
            <option value="">Select Experience</option>
            <option value="0-1 Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '0-1 Years' ? 'selected' : '' }}>
                0-1 Years</option>
            <option value="1-2 Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '1-2 Years' ? 'selected' : '' }}>
                1-2 Years</option>
            <option value="2-5 Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '2-5 Years' ? 'selected' : '' }}>
                2-5 Years</option>
            <option value="5+ Years"
                {{ old('experience_required', $jobListing->experience_required ?? '') == '5+ Years' ? 'selected' : '' }}>
                5+ Years</option>
        </select>
        @error('experience_required')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="salary_type" class="block text-sm font-medium text-gray-700">Salary Type</label>
        <select name="salary_type" id="salary_type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('salary_type') border-red-500 @enderror">
            <option value="">Select Salary Type</option>
            <option value="hourly"
                {{ old('salary_type', $jobListing->salary_type ?? '') == 'hourly' ? 'selected' : '' }}>Hourly</option>
            <option value="salary"
                {{ old('salary_type', $jobListing->salary_type ?? '') == 'salary' ? 'selected' : '' }}>Salary</option>
        </select>
        @error('salary_type')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="hourly_rate_fields" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4"
        style="display: none;">
        <div>
            <label for="hourly_rate_min" class="block text-sm font-medium text-gray-700">Hourly Rate Min <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">$</span>
                <select name="hourly_rate_min" id="hourly_rate_min"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm">
                    <option value="">Select minimum rate</option>
                    @for ($i = 10; $i <= 100; $i += 5)
                        <option value="{{ $i }}"
                            {{ old('hourly_rate_min', $jobListing->hourly_rate_min ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }}.00</option>
                    @endfor
                </select>
            </div>
            @error('hourly_rate_min')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="hourly_rate_max" class="block text-sm font-medium text-gray-700">Hourly Rate Max <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">$</span>
                <select name="hourly_rate_max" id="hourly_rate_max"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm">
                    <option value="">Select maximum rate</option>
                    @for ($i = 15; $i <= 200; $i += 5)
                        <option value="{{ $i }}"
                            {{ old('hourly_rate_max', $jobListing->hourly_rate_max ?? '') == $i ? 'selected' : '' }}>
                            {{ $i }}.00</option>
                    @endfor
                </select>
            </div>
            @error('hourly_rate_max')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div id="annual_salary_fields" class="space-y-4 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-4"
        style="display: none;">
        <div>
            <label for="salary_range_min" class="block text-sm font-medium text-gray-700">Salary Range Min <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">$</span>
                <select name="salary_range_min" id="salary_range_min"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm">
                    <option value="">Select minimum salary</option>
                    @for ($i = 10000; $i <= 100000; $i += 10000)
                        <option value="{{ $i }}"
                            {{ old('salary_range_min', $jobListing->salary_range_min ?? '') == $i ? 'selected' : '' }}>
                            {{ number_format($i) }}</option>
                    @endfor
                </select>
            </div>
            @error('salary_range_min')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="salary_range_max" class="block text-sm font-medium text-gray-700">Salary Range Max <span
                    class="text-red-500">*</span></label>
            <div class="flex mt-1 rounded-md shadow-sm">
                <span
                    class="inline-flex items-center px-3 text-sm text-gray-500 border border-r-0 border-gray-300 rounded-l-md bg-gray-50">$</span>
                <select name="salary_range_max" id="salary_range_max"
                    class="flex-1 block w-full border-gray-300 rounded-none focus:ring-indigo-500 focus:border-indigo-500 rounded-r-md sm:text-sm">
                    <option value="">Select maximum salary</option>
                    @for ($i = 20000; $i <= 200000; $i += 10000)
                        <option value="{{ $i }}"
                            {{ old('salary_range_max', $jobListing->salary_range_max ?? '') == $i ? 'selected' : '' }}>
                            {{ number_format($i) }}</option>
                    @endfor
                </select>
            </div>
            @error('salary_range_max')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Application Type <span
                class="text-red-500">*</span></label>
        <div class="mt-2 space-y-2 sm:space-y-0 sm:flex sm:space-x-4">
            <div class="flex items-center">
                <input type="radio" id="application_type_link" name="application_type" value="link"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('application_type', $jobListing->application_type ?? '') == 'link' ? 'checked' : '' }}
                    required>
                <label for="application_type_link" class="ml-2 text-sm text-gray-600">External Link</label>
            </div>
            <div class="flex items-center">
                <input type="radio" id="application_type_email" name="application_type" value="email"
                    class="text-blue-600 border-gray-300 focus:ring-blue-500"
                    {{ old('application_type', $jobListing->application_type ?? '') == 'email' ? 'checked' : '' }}
                    required>
                <label for="application_type_email" class="ml-2 text-sm text-gray-600">Email</label>
            </div>
        </div>
        @error('application_type')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="application_link_container" style="display: none;">
        <label for="application_link" class="block text-sm font-medium text-gray-700">Application URL <span
                class="text-red-500">*</span></label>
        <input type="url" name="application_link" id="application_link"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('application_link') border-red-500 @enderror"
            value="{{ old('application_link', $jobListing->application_link ?? '') }}"
            placeholder="https://example.com/apply">
        @error('application_link')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div id="email_link_container" style="display: none;">
        <label for="email_link" class="block text-sm font-medium text-gray-700">Application Email <span
                class="text-red-500">*</span></label>
        <input type="email" name="email_link" id="email_link"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 @error('email_link') border-red-500 @enderror"
            value="{{ old('email_link', $jobListing->email_link ?? '') }}" placeholder="apply@example.com">
        @error('email_link')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center justify-end mt-8">
        <button type="submit"
            class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-white uppercase transition bg-blue-600 border border-transparent rounded-md hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-800 focus:ring focus:ring-blue-300 disabled:opacity-25">
            {{ isset($jobListing) ? 'Update Job Listing' : 'Create Job Listing' }}
        </button>
    </div>
</div>
