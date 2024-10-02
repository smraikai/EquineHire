@extends('layouts.site')

@section('content')
    @php
        $subtitle = match ($category->id) {
            1
                => 'Find jobs in horse care and stable management. Groom positions involve feeding, grooming, and maintaining horse health.',
            2
                => 'Search for careers in equine health and veterinary services. These roles focus on improving horse health and well-being.',
            3
                => 'Find leadership positions in the equine industry. Manager jobs involve overseeing operations, staff, and resources in various horse-related settings.',
            4
                => 'Browse administrative and support roles in equine businesses. Office jobs include positions in finance, marketing, and general administration.',
            5
                => 'Find opportunities for professional riders. These jobs involve working with horses in various disciplines, from racing to show jumping.',
            6
                => "Search for careers in horse training and education. Trainer jobs focus on developing horses' skills and preparing them for various equestrian activities.",
            7
                => "Browse unique opportunities in the equine industry. This category includes specialized roles that don't fit into other categories.",
            default => 'Find exciting career opportunities in the equine industry.',
        };
    @endphp

    <x-custom.hero-light title="{!! $category->name !!}" :subtitle="$subtitle" />

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
