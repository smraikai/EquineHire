<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-block px-6 py-3 text-center btn main']) }}>
    {{ $slot }}
</button>