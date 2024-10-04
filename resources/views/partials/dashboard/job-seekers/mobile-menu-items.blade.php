<div class="flex flex-col flex-1 px-4 py-6">
    <nav class="flex flex-col flex-1">
        <ul role="list" class="flex flex-col flex-1 gap-y-7">
            <!-- Dashboard section -->
            <li>
                <div class="text-xs font-semibold leading-6 text-gray-400">Dashboard</div>
                <ul role="list" class="mt-2 space-y-1">
                    <li>
                        <a href="{{ route('job-seekers.index') }}"
                            class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                            <x-heroicon-o-home class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                            Dashboard Home
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Profile section -->
            <li>
                <div class="text-xs font-semibold leading-6 text-gray-400">Profile</div>
                <ul role="list" class="mt-2 space-y-1">
                    @if (auth()->user()->jobSeeker)
                        <li>
                            <a href="{{ route('job-seekers.show', auth()->user()->jobSeeker) }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-user class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                View Profile
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-document-text
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                My Resume
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('job-seekers.create') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-plus-circle
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Create Profile
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            <!-- Job Search section -->
            <li>
                <div class="text-xs font-semibold leading-6 text-gray-400">Job Search</div>
                <ul role="list" class="mt-2 space-y-1">
                    <li>
                        <a href="#"
                            class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                            <x-heroicon-o-magnifying-glass
                                class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                            Find Jobs
                        </a>
                    </li>
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
                </ul>
            </li>
        </ul>
    </nav>
</div>
