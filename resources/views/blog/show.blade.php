@extends('layouts.site')
@section('content')
    <section class="pt-10 pb-10">
        <div class="px-4 mx-auto max-w-7xl lg:px-8">
            <div class="blog-post">
                <a href="{{ route('blog.index') }}" class="text-sm font-semibold leading-6 text-blue-600 hover:text-blue-500">
                    <span aria-hidden="true">&larr;</span> Back to Blog
                </a>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">{{ $post->get('title') }}</h1>
                @if ($post->has('featuredImage'))
                    <img class="object-cover aspect-video rounded-xl bg-gray-50"
                        src="{{ $post->get('featuredImage')->getFile()->getUrl() }}" alt="">
                @endif
                <article class="mt-8 content">
                    {!! $renderer->render($post->get('body')) !!}
                </article>
            </div>
        </div>
    </section>
    @include('partials.sections.job-alerts')
@endsection
