<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'EquineHire'))</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('css')

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

<body class="min-h-screen font-sans antialiased bg-gray-50">
    <div class="flex flex-col min-h-screen">
        <!-- Header with Logo -->
        <header class="py-8">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <div class="logo">
                        <a href="https://equinehire.com" class="text-3xl text-gray-900 font-logo">
                            EquineHire
                        </a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex items-center justify-center flex-1 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-7xl">
                @yield('content')
            </div>
        </main>

        <!-- Footer -->
        <footer class="py-8">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="text-sm text-center text-gray-500">
                    © {{ date('Y') }} EquineHire. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    @yield('scripts')
</body>

</html>
