@props(['message'])

<div id="error-message" class="fixed top-0 right-0 z-50 hidden w-full max-w-sm p-4">
    <div class="overflow-hidden rounded-lg shadow-lg bg-red-50 ring-1 ring-red-500 ring-opacity-50">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <x-heroicon-o-exclamation-circle class="w-6 h-6 text-red-600" />
                </div>
                <div class="flex-1 w-0 ml-3">
                    <p class="text-sm font-medium text-red-800">
                        {{ $message }}
                    </p>
                </div>
                <div class="flex flex-shrink-0 ml-4">
                    <button onclick="hideError()"
                        class="inline-flex text-red-600 rounded-md bg-red-50 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <span class="sr-only">Close</span>
                        <x-heroicon-s-x-mark class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const errorMessage = document.getElementById('error-message');

    // Show error with animation
    errorMessage.classList.remove('hidden');
    errorMessage.style.animation = 'slideIn 300ms ease-out forwards';

    // Auto-hide after 5 seconds
    const timeout = setTimeout(() => {
        hideError();
    }, 5000);

    function hideError() {
        errorMessage.style.animation = 'slideOut 200ms ease-in forwards';
        errorMessage.addEventListener('animationend', () => {
            errorMessage.classList.add('hidden');
        }, {
            once: true
        });
    }

    // Add animation keyframes to the document
    const style = document.createElement('style');
    style.textContent = `
    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-0.5rem);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    @keyframes slideOut {
        from {
            opacity: 1;
            transform: translateY(0);
        }
        to {
            opacity: 0;
            transform: translateY(-0.5rem);
        }
    }
`;
    document.head.appendChild(style);
</script>
