@extends('layouts.site')

@section('content')
    <div class="flex items-center justify-center min-h-screen bg-white">
        <div class="w-full max-w-2xl px-4 py-8 text-center sm:px-6 lg:px-8">
            @if (str_contains(request()->path(), 'jobs'))
                <p class="text-sm font-semibold tracking-wide text-blue-600 uppercase">Uh Oh!</p>
                <h1 class="mt-2 text-5xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Job Listing Not Found</h1>
                <p class="max-w-sm mx-auto mt-2 text-base text-gray-500">
                    It looks like this job listing is no longer available.
                </p>
            @else
                <p class="text-sm font-semibold tracking-wide text-blue-600 uppercase">404 error</p>
                <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Page Not Found</h1>
                <p class="mt-2 text-base text-gray-500">
                    Sorry, we couldn't find the page you're looking for.
                </p>
            @endif
            <div class="mt-6">
                @if (str_contains(request()->path(), 'jobs'))
                    <a href="{{ route('jobs.index') }}"
                        class="inline-flex items-center px-4 py-2 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Browse Jobs
                    </a>
                @endif
                <a href="{{ route('home') }}"
                    class="inline-flex items-center px-4 py-2 text-base font-medium text-blue-600 border border-blue-600 rounded-md shadow-sm hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Go back home
                </a>
            </div>
        </div>
    </div>
@endsection
