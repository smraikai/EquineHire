<!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
<div class="relative z-40 lg:hidden" role="dialog" aria-modal="true">
    <!-- ... (add off-canvas menu for mobile here) ... -->
</div>

<!-- Static sidebar for desktop -->
<div class="hidden shadow-lg shadow-r lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
    <!-- Sidebar component -->
    <div class="flex flex-col px-6 pb-4 overflow-y-auto bg-white grow gap-y-5">
        <div class="flex items-center h-16 shrink-0">
            <a href="{{ route('home') }}" class="text-3xl text-gray-900 font-heading">
                EquineHire
            </a>
        </div>
        <nav class="flex flex-col flex-1">
            <ul role="list" class="flex flex-col flex-1 gap-y-7">
                <li>
                    <ul role="list" class="-mx-2 space-y-1">
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
                        <li>
                            <a href="{{ route('dashboard.job-listings.index') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-briefcase
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Manage Job Listings
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.job-listings.create') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-plus-circle
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Create Job Listing
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('billing') }}"
                                class="flex p-2 text-sm font-semibold leading-6 text-gray-700 rounded-md hover:text-blue-600 hover:bg-gray-50 group gap-x-3">
                                <x-heroicon-o-credit-card
                                    class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                                Manage Billing
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="mt-auto">
                    <a href="{{ route('profile.edit') }}"
                        class="flex p-2 -mx-2 text-sm font-semibold leading-6 text-gray-700 rounded-md group gap-x-3 hover:bg-gray-50 hover:text-blue-600">
                        <x-heroicon-o-cog-6-tooth class="w-6 h-6 text-gray-400 shrink-0 group-hover:text-blue-600" />
                        Settings
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>
