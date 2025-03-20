@props(['id', 'maxWidth' => '2xl'])

@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ][$maxWidth];
@endphp

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div id="{{ $id }}-overlay" class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75"
            aria-hidden="true"></div>

        <!-- This element is to trick the browser into centering the modal contents. -->
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

        <!-- Modal panel -->
        <div
            class="inline-block align-bottom text-left transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle {{ $maxWidth }} sm:w-full overflow-hidden">
            {{ $slot }}
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('{{ $id }}');
            const overlay = document.getElementById('{{ $id }}-overlay');
            if (!modal || !overlay) return;

            // Close modal when clicking the overlay
            overlay.addEventListener('click', function() {
                modal.classList.add('hidden');
            });

            // Close modal with Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    modal.classList.add('hidden');
                }
            });

            // Make show function available globally
            window[`show${modal.id.charAt(0).toUpperCase() + modal.id.slice(1)}`] = function() {
                modal.classList.remove('hidden');
            };
        });
    </script>
@endpush
