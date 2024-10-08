<nav x-data="{ open: false, searchOpen: false }"
    class="lg:px-6 px-4 border-b border-gray-100 {{ Route::currentRouteName() === 'home' ? 'bg-transparent border-none absolute top-0 left-0 w-full z-10' : 'bg-white' }}">
    <!-- Primary Navigation Menu -->
    <div class="w-full py-3 mx-auto">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0 gap-10">
                <div class="logo">
                    <a href="{{ route('home') }}"
                        class="font-logo text-3xl {{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-900' }}">
                        EquineHire
                    </a>
                </div>
            </div>
            <!-- Navigation Links -->
            <div class="items-center hidden space-x-6 lg:flex">

                <a href="{{ route('jobs.index') }}"
                    class="inline-flex items-center px-2 py-2 {{ Route::currentRouteName() === 'home' ? 'text-white hover:text-gray-300' : 'text-gray-700 hover:text-gray-500' }} bg-transparent  focus:outline-none focus:text-gray-500">
                    Search Jobs
                </a>

                <a href="{{ route('blog.index') }}"
                    class="inline-flex items-center px-2 py-2 {{ Route::currentRouteName() === 'home' ? 'text-white hover:text-gray-300' : 'text-gray-700 hover:text-gray-500' }} bg-transparent focus:outline-none focus:text-gray-500">
                    Blog
                </a>

                <!-- Vertical Divider -->
                <div class="w-px h-12 bg-gray-300"></div>

                <!-- User Interaction Links -->
                @auth
                    <!-- Links for Logged-in Users -->
                    <a href="{{ auth()->user()->is_employer ? route('dashboard.employers.index') : route('dashboard.job-seeker.index') }}"
                        class="text-sm {{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-700' }} hover:text-gray-500">
                        My Account
                    </a>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        class="text-sm {{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-700' }} hover:text-gray-500">Log
                        Out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                @endauth

                @guest
                    <!-- Links for Guests -->
                    <a href="{{ route('subscription.plans') }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-center text-white bg-blue-700 border border-transparent rounded-md hover:bg-blue-800">
                        Post a Job
                    </a>

                    <a href="{{ route('login') }}"
                        class="text-sm {{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-700' }} hover:text-gray-500">Log
                        in</a>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button @click="open = !open"
                    class="text-gray-500 border hover:text-gray-600 focus:outline-none focus:text-gray-600"
                    aria-label="Toggle menu">
                    <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke="{{ Route::currentRouteName() === 'home' ? 'white' : 'currentColor' }}">
                        <path d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

        </div>
    </div>


    <!-- Blur effect overlay -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 z-30 backdrop-filter backdrop-blur-sm">
    </div>

    <!-- Mobile menu overlay -->
    <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-500"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-500" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" @click="open = false" class="fixed inset-0 z-30 bg-black bg-opacity-50">
    </div>

    <!-- Mobile menu -->
    <div x-show="open" class="sm:hidden" style="display: none;">
        <div class="fixed right-0 z-40 w-full max-w-sm inset-y-16" aria-labelledby="slide-over-title" role="dialog"
            aria-modal="true">
            <div x-show="open" x-transition:enter="transform transition ease-out duration-500"
                x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in duration-500" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full" @click.away="open = false"
                class="mx-4 overflow-y-auto bg-white border rounded-lg shadow-xl">
                <div class="flex flex-col">
                    <!-- Menu items -->
                    <div class="flex-1 px-4 py-6 sm:px-6">
                        <nav class="space-y-1">
                            <h2 class="text-xs font-bold leading-6 tracking-widest text-gray-900 uppercase"
                                id="slide-over-title">
                                Navigation
                            </h2>
                            <a href="{{ route('jobs.index') }}"
                                class="flex items-center px-3 py-2 text-base font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                                Find Jobs
                            </a>
                            <a href="{{ route('blog.index') }}"
                                class="flex items-center px-3 py-2 text-base font-medium text-gray-600 rounded-md group hover:text-gray-900 hover:bg-gray-50">
                                Blog
                            </a>
                        </nav>
                    </div>
                    <hr class="w-full mx-auto mb-2">
                    <!-- Action buttons -->
                    <div class="p-4 border-gray-200">
                        @auth
                            <a href="{{ auth()->user()->is_employer ? route('dashboard.employers.index') : route('dashboard.job-seeker.index') }}"
                                class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-700 border border-transparent rounded-md shadow-sm hover:bg-blue-800">
                                My Account
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                                @csrf
                                <button type="submit"
                                    class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                    Log out
                                </button>
                            </form>
                        @else
                            <a href="{{ route('subscription.plans') }}"
                                class="flex items-center justify-center w-full px-4 py-2 text-base font-medium text-white bg-blue-700 border border-transparent rounded-md shadow-sm hover:bg-blue-800">
                                Post a Job
                            </a>
                            <a href="{{ route('login') }}"
                                class="flex items-center justify-center w-full px-4 py-2 mt-4 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50">
                                Log in
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

</nav>
