@props(['href', 'text'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'flex items-center justify-start btn plain group']) }}>
    <span class="mr-2 transition-transform duration-300 ease-in-out transform group-hover:translate-x-1">
        <x-coolicon-chevron-right-md class="w-5 h-5" />
    </span>
    {{ $text }}
</a>