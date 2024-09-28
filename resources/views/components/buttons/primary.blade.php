<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-6 py-3 text-base font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500']) }}>
    {{ $text }}
    <x-heroicon-m-chevron-right class="w-5 h-5 ml-2" />
</a>
