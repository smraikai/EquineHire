@if (session('success'))
    <div x-data="{ show: false }" x-init="setTimeout(() => show = true, 500);
    setTimeout(() => show = false, 5000)" x-show="show"
        x-transition:enter="transform transition ease-out duration-500"
        x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transform transition ease-in duration-500"
        x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0"
        class="fixed inset-x-0 w-[90%] max-w-4xl px-4 py-3 mx-auto text-blue-600 bg-blue-100 border border-blue-400 rounded-lg shadow-lg bottom-4 sm:px-6 lg:px-8 sm:py-4">


        <div class="flex flex-wrap items-center justify-between sm:flex-nowrap">
            <!-- Icon for Success -->
            <div class="flex items-center flex-1 min-w-0">
                <x-coolicon-circle-check class="flex-shrink-0 w-6 h-6 pr-2 sm:w-7 sm:h-7" />
                <p class="text-sm truncate sm:text-base">{!! session('success') !!}</p>
            </div>
            <!-- Close button -->
            <button @click="show = false" class="flex-shrink-0 ml-2 text-blue-600 hover:text-blue-900">
                <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>
@endif
