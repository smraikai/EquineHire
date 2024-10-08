<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-gray-100">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="https://equinehire-static-assets.s3.amazonaws.com/favicon.jpg" type="image/jpeg">

    <title>
        @if (isset($jobListing))
            Apply for {{ $jobListing->title }} at {{ $jobListing->employer->name }} | EquineHire
        @else
            {{ $metaTitle ?? 'Job Application | EquineHire' }}
        @endif
    </title>
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

<body class="h-full font-sans antialiased">

    <div class="min-h-full">
        <nav class="">
            <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <div class="flex items-center flex-shrink-0">
                            <a href="{{ route('home') }}" class="text-3xl text-gray-900 font-logo">
                                EquineHire
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center">
                        @if (isset($jobListing))
                            <a href="{{ route('jobs.show', ['job_slug' => $jobListing->slug, 'id' => $jobListing->id]) }}"
                                class="flex items-center font-medium text-gray-500 hover:text-gray-700 group">
                                <x-heroicon-o-arrow-long-left
                                    class="w-5 h-5 mr-1 transition-transform duration-300 group-hover:-translate-x-1" />
                                <span>Back to Job Listing</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <div class="bg-gray-100">
                @yield('content')
            </div>
        </main>
    </div>
    @yield('scripts')
</body>

</html>
