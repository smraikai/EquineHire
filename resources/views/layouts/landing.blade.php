<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" href="https://equinehire-static-assets.s3.amazonaws.com/favicon.jpg" type="image/jpeg">

    <!-- SEO -->
    {!! SEO::generate() !!}

    <!-- CSS -->
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

<body class="font-sans antialiased">

    @if (session('success'))
        <x-success-message :message="session('success')" />
    @endif
    @if (session('error'))
        <x-error-message :message="session('error')" />
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Simple Footer -->
    <footer class="bg-gray-100 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center text-sm text-gray-600">
                <p>&copy; {{ date('Y') }} EquineHire. All rights reserved.</p>
                <div class="mt-2 space-x-4">
                    <a href="{{ route('privacy-policy') }}" class="hover:text-blue-600">Privacy Policy</a>
                    <a href="{{ route('terms-of-service') }}" class="hover:text-blue-600">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @yield('scripts')
    @stack('scripts')
</body>

</html>