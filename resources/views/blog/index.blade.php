@extends('layouts.site')

@php
    $metaTitle = 'EquineHire Blog | Equine Expertise & Industry Insights';
    $metaDescription =
        'Explore the latest insights, tips, and news about equine professionals and services on the EquineHire blog.';

    // Contentful Setup for Blog Index
    use Contentful\Delivery\Client as ContentfulClient;
    use Contentful\Delivery\Query;

    $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
    $query = new Query();
    $query->setContentType('blogPost')->setLimit(4)->orderBy('sys.createdAt', true);
    $posts = $client->getEntries($query);
    $latestPost = $posts->getItems()[0] ?? null;

@endphp

@section('content')
    <section class="bg-white">
        <div class="max-w-5xl px-4 mx-auto lg:px-8">
            <div class="max-w-2xl mx-auto lg:mx-0">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">EquineHire Blog</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">Insights, tips, and news for equine professionals and
                    enthusiasts.</p>
            </div>
            <hr class="my-10">
            @if ($latestPost)
                <a href="{{ route('blog.show', $latestPost->get('slug')) }}" class="block">
                    <article
                        class="flex flex-col-reverse overflow-hidden transition duration-300 ease-in-out rounded-lg md:flex-row group">
                        <div class="flex flex-col w-full gap-5 py-6 md:w-1/2">
                            <h3
                                class="text-4xl font-semibold text-gray-900 md:text-6xl fancy-title text-pretty group-hover:text-gray-700">
                                {{ $latestPost->get('title') }}
                            </h3>
                            <div class="inline-flex items-center text-sm btn plain group-hover:text-blue-600">
                                <span>Read More</span> <x-coolicon-chevron-right-md
                                    class="w-5 h-5 ml-2 transition-transform duration-300 ease-in-out group-hover:translate-x-1" />
                            </div>
                        </div>
                        <div class="w-full overflow-hidden rounded-lg md:w-1/2">
                            <img class="object-cover w-full h-64 transition duration-300 ease-in-out transform md:h-full group-hover:opacity-90"
                                src="{{ $latestPost->get('featuredImage')->getFile()->getUrl() }}"
                                alt="{{ $latestPost->get('title') }}">
                        </div>
                    </article>
                </a>
            @endif

            <div class="pt-10 mx-auto mt-10 space-y-16 border-t border-gray-200 sm:mt-16 sm:pt-16">
                @foreach ($posts->getItems() as $index => $post)
                    @if ($index > 0)
                        <a href="{{ route('blog.show', $post->get('slug')) }}" class="block">
                            <article
                                class="flex flex-col items-start transition duration-100 ease-out md:flex-row hover:opacity-90">
                                <div class="relative w-full md:w-1/3 md:mr-6">
                                    <img src="{{ $post->get('featuredImage')->getFile()->getUrl() }}"
                                        alt="{{ $post->get('title') }}"
                                        class="object-cover w-full h-56 rounded-lg aspect-[16/9]">
                                    <div class="absolute inset-0 rounded-lg ring-1 ring-inset ring-gray-900/10"></div>
                                </div>
                                <div class="max-w-xl md:w-2/3">
                                    <div class="flex items-center mt-8 sm:mt-0 gap-x-4">
                                        <time datetime="{{ $post->getSystemProperties()->getCreatedAt()->format('Y-m-d') }}"
                                            class="text-gray-500">
                                            {{ $post->getSystemProperties()->getCreatedAt()->format('F j, Y') }}
                                        </time>
                                    </div>
                                    <div class="relative group">
                                        <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900">
                                            {{ $post->get('title') }}
                                        </h3>
                                        <p class="mt-5 text-sm leading-6 text-gray-600 line-clamp-3">
                                            {{ $post->get('metaDescription') }}</p>
                                    </div>
                                    <div class="inline-flex items-center mt-4 text-sm btn plain group-hover:text-blue-600">
                                        <span>Read More</span> <x-coolicon-chevron-right-md
                                            class="w-5 h-5 ml-2 transition-transform duration-300 ease-in-out group-hover:translate-x-1" />
                                    </div>
                                </div>
                            </article>
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta.job-alerts')
@endsection
