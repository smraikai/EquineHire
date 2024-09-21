<div class="bg-blue-50">
    <div class="container px-4 py-20 mx-auto max-w-7xl sm:px-6 sm:py-24 lg:px-8 lg:py-32">
        <div class="text-center">
            @if (isset($kicker))
                @include('components.custom.kicker-text', ['text' => $kicker])
            @endif
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl md:text-5xl lg:text-6xl">
                {{ $title }}
            </h1>
            @if (isset($subtitle))
                <p
                    class="max-w-md mx-auto mt-3 text-sm text-gray-500 sm:text-base md:mt-5 md:text-lg lg:text-xl lg:max-w-3xl">
                    {{ $subtitle }}
                </p>
            @endif
            {{ $slot ?? '' }}
        </div>
    </div>
</div>
