@extends('layouts.site')

@section('content')
    <x-custom.hero-light kicker="Your Journey Starts Here" title="Search Equine Jobs"
        subtitle="Discover rewarding career opportunities in the equine industry." />
    <div class="container p-4 mx-auto mt-10 sm:p-10 max-w-7xl">

        <div class="flex flex-col justify-around gap-5 md:flex-row">
            <div class="order-2 w-full md:w-3/4 md:order-1">
                <div class="pb-10">
                    @include('partials.jobs.search')
                </div>
                @include('partials.jobs.results')
            </div>
        </div>
    </div>
@endsection
