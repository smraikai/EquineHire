<!-- Static sidebar for desktop -->
<div class="hidden shadow-lg shadow-r lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <!-- Sidebar component -->
    <div class="flex flex-col px-6 pb-4 overflow-y-auto bg-white grow gap-y-5">
        <div class="flex items-center h-16 shrink-0">
            <a href="{{ route('home') }}" class="text-3xl text-gray-900 font-logo">
                EquineHire
            </a>
        </div>
        <nav class="flex flex-col flex-1">
            <ul role="list" class="flex flex-col flex-1 gap-y-7">
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400">Dashboard</div>
                    <ul role="list" class="mt-2 -mx-2 space-y-1">
                        <li>
                            <a href="{{ route('dashboard.employers.index') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-home class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Dashboard Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employers.index') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-building-office
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Employer Profile
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400">Job Listings</div>
                    <ul role="list" class="mt-2 -mx-2 space-y-1">
                        <li>
                            <a href="{{ route('employers.job-listings.index') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-briefcase
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Manage Job Listings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('employers.job-listings.create') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-plus-circle
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Create Job Listing
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="text-xs font-semibold leading-6 text-gray-400">Billing</div>
                    <ul role="list" class="mt-2 -mx-2 space-y-1">
                        <li>
                            <a href="{{ route('billing') }}" target="_blank"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-credit-card
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Manage Billing
                            </a>
                        </li>
                        <li>
                            <button onclick="document.getElementById('change-plan-modal').classList.remove('hidden')"
                                class="flex w-full p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-arrow-path
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Change Plan
                            </button>
                        </li>
                    </ul>
                </li>
                <li class="mt-auto">
                    <a href="{{ route('profile.edit') }}"
                        class="flex p-2 -mx-2 text-sm font-semibold leading-6 text-gray-700 rounded-md group gap-x-3 hover:bg-gray-50 hover:text-blue-600">
                        <x-heroicon-o-cog-6-tooth class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                        Account Settings
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
<div x-data="{ isOpen: false }" x-on:toggle-sidebar.window="isOpen = !isOpen; $dispatch('sidebar-toggled', { isOpen })"
    class="relative z-40 lg:hidden" role="dialog" aria-modal="true"
    x-effect="isOpen ? document.body.style.overflow = 'hidden' : document.body.style.overflow = 'auto'">

    <!-- Background overlay -->
    <div x-show="isOpen" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-50"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-50"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50" @click="isOpen = false"></div>

    <div x-show="isOpen" x-transition:enter="transition ease-in-out duration-300 transform"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300 transform" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" class="fixed inset-0 z-50 flex">

        <div class="relative flex flex-col w-full max-w-xs overflow-y-auto bg-white shadow-xl"
            @click.away="isOpen = false">
            <div class="flex items-center justify-between px-4 pt-5 pb-2">
                <a href="{{ route('home') }}" class="text-3xl text-gray-900 font-logo">
                    EquineHire
                </a>
                <button x-on:click="isOpen = false" type="button"
                    class="inline-flex items-center justify-center p-2 text-gray-400 rounded-md hover:text-gray-500 hover:bg-gray-100">
                    <span class="sr-only">Close menu</span>
                    <x-heroicon-o-x-mark class="w-6 h-6" />
                </button>
            </div>

            <!-- Mobile menu content -->
            <div class="flex flex-col flex-1 px-4 py-6">
                <nav class="flex flex-col flex-1">
                    <ul role="list" class="flex flex-col flex-1 gap-y-7">
                        <!-- Dashboard section -->
                        <li>
                            <div class="text-xs font-semibold leading-6 text-gray-400">Dashboard</div>
                            <ul role="list" class="mt-2 space-y-1">
                                <li>
                                    <a href="{{ route('dashboard.employers.index') }}"
                                        class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                        <x-heroicon-o-home
                                            class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                        Dashboard Home
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('employers.index') }}"
                                        class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                        <x-heroicon-o-building-office
                                            class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                        Employer Profile
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Job Listings section -->
                        <li>
                            <div class="text-xs font-semibold leading-6 text-gray-400">Job Listings</div>
                            <ul role="list" class="mt-2 space-y-1">
                                <li>
                                    <a href="{{ route('employers.job-listings.index') }}"
                                        class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                        <x-heroicon-o-briefcase
                                            class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                        Manage Job Listings
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('employers.job-listings.create') }}"
                                        class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                        <x-heroicon-o-plus-circle
                                            class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                        Create Job Listing
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Billing section -->
                        <li>
                            <div class="text-xs font-semibold leading-6 text-gray-400">Billing</div>
                            <ul role="list" class="mt-2 space-y-1">
                                <li>
                                    <a href="{{ route('billing') }}" target="_blank"
                                        class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                        <x-heroicon-o-credit-card
                                            class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                        Manage Billing
                                    </a>
                                </li>
                                <li>
                                    <button
                                        onclick="document.getElementById('change-plan-modal').classList.remove('hidden')"
                                        class="flex w-full p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                        <x-heroicon-o-arrow-path
                                            class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                        Change Plan
                                    </button>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- Account Settings (moved to bottom) -->
            <div class="px-4 py-4 mt-auto">
                <a href="{{ route('profile.edit') }}"
                    class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md group gap-x-3 hover:bg-gray-50 hover:text-blue-600">
                    <x-heroicon-o-cog-6-tooth class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                    Account Settings
                </a>
            </div>
        </div>
    </div>
</div>
