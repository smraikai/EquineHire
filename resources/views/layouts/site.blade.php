<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $metaTitle ?? 'EquineHire' }}</title>
    <meta name="description" content="{{ $metaDescription ?? 'Find equine services near you with EquineHire' }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $metaTitle ?? 'EquineHire' }}">
    <meta property="og:description" content="{{ $metaDescription ?? 'Find equine services near you with EquineHire' }}">
    <meta property="og:image" content="https://EquineHire-static-assets.s3.amazonaws.com/socialshare.jpg">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="{{ $metaTitle ?? 'EquineHire' }}">
    <meta property="twitter:description"
        content="{{ $metaDescription ?? 'Find equine services near you with EquineHire' }}">
    <meta property="twitter:image" content="https://equinehire-static-assets.s3.amazonaws.com/socialshare.jpg">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('scripts_css')

    <!-- Favicon and Logo -->
    <link rel="icon" href="https://EquineHire-static-assets.s3.amazonaws.com/favico.jpg" type="image/jpeg">
    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Organization",
        "url": "https://equinehire.com",
        "logo": "https://equinehire-static-assets.s3.amazonaws.com/favico.jpg"
        }
    </script>

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
    @include('partials.scripts._google-maps-locations')
    @yield('scripts')
</body>

</html>
