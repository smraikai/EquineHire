<header class="text-white bg-blue-700">
    <div class="px-4 py-6 mx-auto sm:px-6 lg:px-8 max-w-7xl">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold leading-tight">Edit Business Listing</h1>
            <div class="flex gap-2">
                <a href="{{ route('businesses.index') }}"
                    class="px-4 py-2 text-white transition duration-150 ease-in-out border rounded hover:text-black hover:bg-white">Cancel</a>
                <a id="publishUpdateBtn1"
                    class="px-4 py-2 text-white transition duration-150 ease-in-out bg-emerald-500 rounded cursor-pointer hover:bg-emerald-600"
                    onclick="submitForm()">{{ $business->post_status == 'Draft' ? 'Publish' : 'Update' }}</a>
            </div>
        </div>
    </div>
</header>