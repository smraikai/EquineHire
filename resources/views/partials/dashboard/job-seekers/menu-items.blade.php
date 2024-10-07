<li>
    <div class="text-xs font-semibold leading-6 text-gray-400">Profile</div>
    <ul role="list" class="mt-2 -mx-2 space-y-1">
        @if (auth()->user()->jobSeeker)
            <li>
                <a href="{{ route('dashboard.job-seekers.index', auth()->user()->jobSeeker) }}"
                    class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                    <x-heroicon-o-pencil-square class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                    My Profile
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('job-seekers.create') }}"
                    class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                    <x-heroicon-o-plus-circle class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                    Create Profile
                </a>
            </li>
        @endif
    </ul>
</li>

<li>
    <div class="text-xs font-semibold leading-6 text-gray-400">Job Search</div>
    <ul role="list" class="mt-2 -mx-2 space-y-1">
        <li>
            <a href="#"
                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                <x-heroicon-o-magnifying-glass class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                Find Jobs
            </a>
        </li>
        {{-- WAIT: Dashboard Edit
        
        <li>
            <a href="#"
                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                <x-heroicon-o-bookmark class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                Saved Jobs
            </a>
        </li>
        <li>
            <a href="#"
                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                <x-heroicon-o-clipboard-document-list
                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                Applications
            </a>
        </li>
        --}}
    </ul>
</li>
