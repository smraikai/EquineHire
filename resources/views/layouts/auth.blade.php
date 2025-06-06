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
    <div class="flex flex-col min-h-screen md:flex-row">
        <!-- Left side: Form content -->
        <div class="flex flex-col w-full px-4 py-4 md:w-1/2">
            <!-- Logo -->
            <div class="mb-12">
                <div class="logo">
                    <a href="https://equinehire.com" class="text-3xl text-gray-900 font-logo">
                        EquineHire
                    </a>
                </div>
            </div>

            <!-- Form Content -->
            <div class="flex items-center justify-center flex-1">
                <div class="w-full max-w-xl">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Right side: Full-size image (hidden on mobile) -->
        <div class="relative hidden w-1/2 md:block">
            <img src="https://equinehire-static-assets.s3.amazonaws.com/horse-barn-bw-min.jpg" alt="Auth Image"
                class="object-cover w-full h-full">
            <div class="absolute inset-0 bg-gradient-to-br from-black/70 to-transparent"></div>
        </div>
    </div>

    @yield('scripts')
</body>

</html>
