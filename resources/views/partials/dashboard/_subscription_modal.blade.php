<div id="change-plan-modal" class="fixed inset-0 z-50 hidden overflow-y-auto bg-white">
    <div class="min-h-screen px-4 py-8 text-center">
        <button type="button" class="absolute z-10 text-gray-400 top-4 right-4 hover:text-gray-500"
            onclick="document.getElementById('change-plan-modal').classList.add('hidden')">
            <span class="sr-only">Close</span>
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="max-h-screen p-4 overflow-y-auto sm:p-6 md:p-8">
            <div class="max-w-5xl mx-auto text-center">
                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl md:text-3xl">Change Your Plan</h2>
                <p class="max-w-xl mx-auto mt-4 text-lg text-center text-gray-500">
                    Choose the plan that best fits your hiring needs.
                </p>
                <div class="mt-4">
                    @include('subscription._plans-component')
                </div>
            </div>
        </div>
        <p class="mt-2 text-sm text-gray-600">
            Plan changes take effect immediately and are not prorated. Your current plan will be replaced with the new
            selection.
        </p>
    </div>
</div>


<script>
    // Close modal when clicking outside
    document.getElementById('change-plan-modal').addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });

    // Close modal on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            document.getElementById('change-plan-modal').classList.add('hidden');
        }
    });
</script>
