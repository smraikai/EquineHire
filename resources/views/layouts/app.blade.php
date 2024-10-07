<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? 'EquineHire' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')

    <!-- Favicon and Logo -->
    <link rel="icon" href="https://equinehire-static-assets.s3.amazonaws.com/favicon.jpg" type="image/jpeg">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,700;0,800;1,400;1,700;1,800&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
</head>

<body class="h-full font-sans antialiased">
    <div class="min-h-full">

        @if (session('success'))
            <x-success-message :message="session('success')" />
        @endif
        @if (session('error'))
            <x-error-message :message="session('error')" />
        @endif
        @include('partials.dashboard.sidebar')

        <div class="lg:pl-72">
            <div
                class="sticky top-0 z-30 flex items-center h-16 px-4 bg-gray-50 shrink-0 gap-x-4 sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="lg:hidden" x-data="{ isOpen: false }"
                    x-on:click="$dispatch('toggle-sidebar'); isOpen = !isOpen">
                    <span class="sr-only" x-text="isOpen ? 'Close menu' : 'Open menu'"></span>
                    <x-heroicon-o-bars-3 class="w-6 h-6" />
                </button>
                <!-- Separator -->
                <div class="w-px h-6 bg-gray-200 lg:hidden" aria-hidden="true"></div>

                <div class="flex self-stretch flex-1 gap-x-4 lg:gap-x-6">
                    <div class="relative flex items-center flex-1">
                        <h1 class="text-xl font-semibold text-gray-900">
                            {{ $pageTitle ?? 'Dashboard' }}
                        </h1>
                    </div>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button type="button" class="-m-1.5 flex items-center p-1.5" id="user-menu-button"
                                @click="open = !open" @keydown.escape.window="open = false" @click.away="open = false"
                                aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                @if (Auth::user()->employer && Auth::user()->employer->logo)
                                    <img class="w-8 h-8 rounded-full bg-gray-50"
                                        src="{{ Storage::url(Auth::user()->employer->logo) }}"
                                        alt="{{ Auth::user()->name }}">
                                @else
                                    <div
                                        class="flex items-center justify-center w-8 h-8 text-sm font-semibold text-white bg-blue-600 rounded-full">
                                        {{ Str::upper(Str::substr(Auth::user()->name, 0, 2)) }}
                                    </div>
                                @endif
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900"
                                        aria-hidden="true">{{ Auth::user()->name }}</span>
                                    <svg class="w-5 h-5 ml-2 text-gray-400" viewBox="0 0 20 20" fill="currentColor"
                                        aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </button>
                            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="transform opacity-0 scale-95"
                                x-transition:enter-end="transform opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="transform opacity-100 scale-100"
                                x-transition:leave-end="transform opacity-0 scale-95"
                                class="absolute right-0 z-10 w-48 py-1 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
                                tabindex="-1">
                                <a href="{{ route('profile.edit') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem"
                                    tabindex="-1" id="user-menu-item-0">My Account</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full px-4 py-2 text-sm text-left text-gray-700 hover:bg-gray-100"
                                        role="menuitem" tabindex="-1" id="user-menu-item-1">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <main class="">
                <div class="bg-gray-100">
                    @yield('content')
                </div>
            </main>
        </div>

        @include('partials.dashboard._subscription_modal')

    </div>
    @yield('scripts')

</body>

</html>
