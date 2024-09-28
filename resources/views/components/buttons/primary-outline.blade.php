<a href="{{ $href }}"
    {{ $attributes->merge(['class' => 'inline-flex items-center justify-center px-6 py-3 text-base font-medium text-blue-600 bg-white border border-2 border-blue-600 rounded-md shadow-sm hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500']) }}>
    {{ $text }}
    <x-heroicon-m-chevron-right class="w-5 h-5 ml-2" />
</a>
