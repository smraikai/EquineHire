<form action="{{ route('jobs.index') }}" method="GET" class="w-full max-w-4xl mx-auto" id="jobSearchForm">
    <div class="relative flex items-center">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <x-coolicon-search-magnifying-glass class="w-5 h-5 text-gray-400" />
        </div>
        <input type="search" name="keyword" placeholder="Search for jobs..." value="{{ request('keyword') }}"
            class="w-full py-3 pl-10 pr-32 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        <div class="absolute inset-y-0 right-0 flex items-center">
            <div class="w-px h-6 mr-2 bg-gray-300"></div>
            <select name="state" id="stateSelect"
                class="h-full py-0 pl-2 text-gray-700 bg-transparent border-0 appearance-none pr-7 focus:outline-none focus:ring-0">
                <option value="">All States</option>
                @foreach (\App\Models\JobListing::getUniqueStates() as $state)
                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                        {{ $state }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>

<script>
    document.getElementById('stateSelect').addEventListener('change', function() {
        document.getElementById('jobSearchForm').submit();
    });
</script>
