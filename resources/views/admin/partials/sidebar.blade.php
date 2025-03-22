<!-- Admin sidebar -->
<div class="hidden shadow-lg shadow-r lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <div class="flex flex-col px-6 pb-4 overflow-y-auto bg-gray-900 grow gap-y-5">
        <div class="flex items-center h-16 shrink-0">
            <a href="{{ route('home') }}" class="text-3xl text-white font-logo">
                EquineHire <span class="text-sm font-normal">Admin</span>
            </a>
        </div>
        <nav class="flex flex-col flex-1">
            <ul role="list" class="flex flex-col flex-1 gap-y-7">
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400">Admin Dashboard</div>
                    <ul role="list" class="mt-2 -mx-2 space-y-1">
                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-home class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.users') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-users class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Users
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.employers') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-building-office
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Employers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.job-listings') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-briefcase class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Job Listings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.applications') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-document-text
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Applications
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.revenue') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-currency-dollar
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Revenue
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="mt-auto">
                    <div class="text-xs font-semibold leading-6 text-gray-400">Return to Site</div>
                    <ul role="list" class="mt-2 -mx-2 space-y-1">
                        <li>
                            <a href="{{ route('home') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-200 rounded-md hover:text-white hover:bg-gray-800 group gap-x-3">
                                <x-heroicon-o-arrow-left-circle
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-white" />
                                Back to Site
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>
