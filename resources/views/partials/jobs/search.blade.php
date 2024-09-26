<form action="{{ route('jobs.index') }}" method="GET" class="w-full max-w-4xl mx-auto" id="jobSearchForm">
    <div class="flex flex-col space-y-2 sm:flex-row sm:space-y-0 sm:space-x-2">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-coolicon-search-magnifying-glass class="w-5 h-5 text-gray-400" />
            </div>
            <input type="search" name="keyword" placeholder="Search for jobs..." value="{{ request('keyword') }}"
                class="w-full py-3 pl-10 pr-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="relative">
            <select name="state" id="stateSelect"
                class="w-full py-3 pl-2 pr-8 text-gray-700 bg-white border border-gray-300 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All States</option>
                @foreach (\App\Models\JobListing::getUniqueStates() as $state)
                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                        {{ $state }}
                    </option>
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
