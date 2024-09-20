@props(['href', 'text'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-6 py-3 text-center btn main']) }}>
    {{ $text }}
</a>