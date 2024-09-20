<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-black border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-900 disabled:opacity-25 transition ease-in-out duration-150 text-center sm:text-left']) }}>
    {{ $slot }}
</button>
