<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

    <div class="">
        @include('layouts.navigation')
        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif
        <!-- Page Content -->
        <main>
            @yield('content')
        </main>
    </div>
    @include('partials.footer')
    @yield('scripts')
</body>

</html>
