@props(['href', 'text'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center justify-center btn alt-black']) }}>
    {{ $text }}
</a>