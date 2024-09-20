<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 text-sm font-semibold text-gray-900 bg-white rounded-md shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50']) }}>
    {{ $slot }}
</button>