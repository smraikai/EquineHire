@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center min-h-screen bg-white">
    <div class="w-full max-w-md px-4 py-8 text-center sm:px-6 lg:px-8">
        <p class="text-sm font-semibold tracking-wide uppercase text-blue-600">404 error</p>
        <h1 class="mt-2 text-4xl font-extrabold tracking-tight text-gray-900 sm:text-5xl">Page not found</h1>
        <p class="mt-2 text-base text-gray-500">Sorry, we couldn't find the page you're looking for.</p>
        <div class="mt-6">
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-base font-medium text-white border border-transparent rounded-md shadow-sm bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Go back home
            </a>
        </div>
    </div>
</div>
@endsection
