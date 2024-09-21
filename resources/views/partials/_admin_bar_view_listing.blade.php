    <div id="scrollingFooter" class="fixed inset-x-0 bottom-0 z-50 px-4 py-6 mx-auto bg-white shadow sm:px-6 lg:px-8">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold leading-tight">Edit Business Listing</h1>
            <div class="flex gap-2">
                <a href="{{ route('businesses.index') }}"
                    class="px-4 py-2 text-black transition duration-150 ease-in-out border border-black rounded hover:text-white hover:bg-black">Cancel</a>
                <a id="publishUpdateBtn2"
                    class="px-4 py-2 text-white transition duration-150 ease-in-out bg-blue-500 rounded cursor-pointer hover:bg-blue-600"
                    onclick="submitForm()">{{ $business->post_status == 'Draft' ? 'Publish' : 'Update' }}</a>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            // Bottom Bar Scrolling
            document.addEventListener('scroll', function() {
                const footer = document.getElementById('scrollingFooter');
                if (window.scrollY > 100) {
                    footer.classList.add('visible');
                } else {
                    footer.classList.remove('visible');
                }
            });
        </script>
    @endsection
