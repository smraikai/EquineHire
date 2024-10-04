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
