<nav x-data="{ open: false, searchOpen: false }"
    class="lg:px-6 px-4 border-b border-gray-100 {{ Route::currentRouteName() === 'home' ? 'bg-transparent border-none absolute top-0 left-0 w-full z-10' : 'bg-white' }}">
    <!-- Primary Navigation Menu -->
    <div class="w-full py-3 mx-auto">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center flex-shrink-0 gap-10">
                <div class="logo">
                    <a href="{{ route('home') }}"
                        class="{{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-900' }}">
                        EquineHire
                    </a>
                </div>
                <!-- Search Bar -->
                <div id="search-container" class="hidden ml-4 lg:block md:w-full lg:w-auto">
                    @include('partials.directory.search')
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="items-center hidden space-x-6 lg:flex">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                        class="inline-flex items-center px-2 py-2 {{ Route::currentRouteName() === 'home' ? 'text-white hover:text-gray-300' : 'text-gray-700 hover:text-gray-500' }} bg-transparent focus:outline-none">
                        About
                        <svg class="w-5 h-5 ml-2 -mr-1 transition-transform duration-200"
                            :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" x-cloak @click.away="open = false"
                        x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute z-10 w-48 py-1 mt-2 bg-white rounded-md shadow-lg">
                        <a href="/our-story" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Our
                            Story</a>
                    </div>
                </div>

                <a href="{{ route('businesses.directory') }}"
                    class="inline-flex items-center px-2 py-2 {{ Route::currentRouteName() === 'home' ? 'text-white hover:text-gray-300' : 'text-gray-700 hover:text-gray-500' }} bg-transparent  focus:outline-none focus:text-gray-500">
                    Explore
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
                    <a href="{{ route('businesses.index') }}"
                        class="text-sm {{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-700' }} hover:text-gray-500">My
                        Account</a>
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
                        class="inline-flex items-center px-4 py-2 text-sm font-semibold tracking-widest text-center text-white border border-transparent rounded-md bg-blue-700 hover:bg-blue-800">
                        Post a Job
                    </a>

                    <a href="{{ route('login') }}"
                        class="text-sm {{ Route::currentRouteName() === 'home' ? 'text-white' : 'text-gray-700' }} hover:text-gray-500">Log
                        in</a>
                @endguest
            </div>

            <!-- Mobile menu and search buttons -->
            <div class="flex items-center gap-2 lg:hidden">
                <button @click="searchOpen = true; moveSearchToOverlay()"
                    class="mr-2 text-gray-500 hover:text-gray-600 focus:outline-none focus:text-gray-600"
                    aria-label="Open search">
                    <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke="{{ Route::currentRouteName() === 'home' ? 'white' : 'currentColor' }}">
                        <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
                <button @click="open = !open; searchOpen = false; moveSearchBack()"
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
    <!-- Mobile Navigation Menu -->
    <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform -translate-y-full"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform translate-y-0"
        x-transition:leave-end="opacity-0 transform -translate-y-full"
        class="fixed inset-0 z-50 overflow-y-auto bg-white">
        <div class="w-full p-6">
            <!-- Close button -->
            <button @click="open = false" class="absolute text-gray-500 top-8 right-5 hover:text-gray-700">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <!-- Logo -->
            <div class="mb-8">
                <a href="{{ route('home') }}" class="text-3xl logo">
                    EquineHire
                </a>
            </div>

            <!-- Menu items -->
            <nav class="space-y-6">
                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center w-full text-2xl text-gray-700 hover:text-gray-900">
                        Explore Services
                        <svg class="w-5 h-5 ml-2 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2 space-y-2">
                        <a href="{{ route('businesses.directory', ['categories[]' => 5]) }}"
                            class="block text-xl text-gray-600 hover:text-gray-900">Farriers</a>
                        <a href="{{ route('businesses.directory', ['categories[]' => 14]) }}"
                            class="block text-xl text-gray-600 hover:text-gray-900">Trainers</a>
                        <a href="{{ route('businesses.directory', ['categories[]' => 1]) }}"
                            class="block text-xl text-gray-600 hover:text-gray-900">Boarding Facilities</a>
                        <a href="{{ route('businesses.directory', ['categories[]' => 6]) }}"
                            class="block text-xl text-gray-600 hover:text-gray-900">Riding Lessons</a>
                        <a href="{{ route('businesses.directory') }}"
                            class="block text-xl text-gray-600 hover:text-gray-900">View All Jobs</a>
                    </div>
                </div>

                <div x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center w-full text-2xl text-gray-700 hover:text-gray-900">
                        About
                        <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                    <div x-show="open" class="mt-2 space-y-2">
                        <a href="/our-story" class="block text-xl text-gray-600 hover:text-gray-900">Our Story</a>
                    </div>
                </div>

                <a href="{{ route('blog.index') }}" class="block text-2xl text-gray-700 hover:text-gray-900">
                    Blog
                </a>

                <div class="pt-8 mt-8 border-t border-gray-200">
                    @guest
                        <a href="{{ route('subscription.plans') }}"
                            class="block w-full py-3 text-xl font-medium text-center text-white transition duration-150 ease-in-out rounded-md bg-blue-700 hover:bg-blue-800">List
                            Your Business</a>
                        <a href="{{ route('login') }}"
                            class="block w-full py-3 mt-4 text-xl font-medium text-center transition duration-150 ease-in-out border rounded-md text-blue-700 border-blue-700 hover:bg-blue-50">Log
                            in</a>
                    @else
                        <a href="{{ route('businesses.index') }}"
                            class="block w-full py-3 text-xl font-medium text-center text-white transition duration-150 ease-in-out rounded-md bg-blue-700 hover:bg-blue-800">My
                            Account</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-4">
                            @csrf
                            <button type="submit"
                                class="w-full py-3 text-xl font-medium text-center text-gray-700 transition duration-150 ease-in-out border border-gray-300 rounded-md hover:bg-gray-50">Log
                                Out</button>
                        </form>
                    @endguest
                </div>
            </nav>
        </div>
    </div>



    <!-- Mobile Search Overlay -->
    <div x-show="searchOpen" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform scale-95"
        x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 transform scale-100"
        x-transition:leave-end="opacity-0 transform scale-95"
        class="absolute left-0 right-0 z-50 mx-4 bg-white rounded-lg shadow-lg top-20">
        <div class="w-full p-4 border rounded-lg">
            <!-- Close button -->
            <button @click="searchOpen = false; moveSearchBack()"
                class="absolute z-10 text-gray-500 top-2 right-2 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <!-- Search form container -->
            <div id="mobile-search-container" class="lg:mt-4"></div>
        </div>
    </div>

</nav>

<script>
    function moveSearchToOverlay() {
        const searchForm = document.querySelector('#search-container > form');
        const mobileContainer = document.getElementById('mobile-search-container');
        mobileContainer.appendChild(searchForm);
    }

    function moveSearchBack() {
        setTimeout(() => {
            const searchForm = document.querySelector('#mobile-search-container > form');
            const desktopContainer = document.getElementById('search-container');
            desktopContainer.appendChild(searchForm);
        }, 200); // 200 milliseconds delay
    }
</script>
