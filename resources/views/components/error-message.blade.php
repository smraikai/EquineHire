@props(['message'])

<div x-data="{ show: false }" x-init="$nextTick(() => {
    show = true;
    setTimeout(() => { show = false }, 5000);
})" x-show="show"
    x-transition:enter="transform ease-out duration-500 transition" x-transition:enter-start="-translate-y-full"
    x-transition:enter-end="translate-y-0" x-transition:leave="transform ease-in duration-500 transition opacity-100"
    x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-full opacity-0"
    class="fixed top-0 right-0 z-50 w-full max-w-sm p-4">
    <div class="overflow-hidden rounded-lg shadow-lg bg-red-50 ring-1 ring-red-500 ring-opacity-50">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="flex-1 w-0 ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ $message }}
                    </p>
                </div>
                <div class="flex flex-shrink-0 ml-4">
                    <button @click="show = false"
                        class="inline-flex text-red-600 rounded-md bg-red-50 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <span class="sr-only">Close</span>
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
