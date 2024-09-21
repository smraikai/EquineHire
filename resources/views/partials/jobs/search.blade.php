<form action="{{ route('jobs.index') }}" method="GET" class="w-full max-w-4xl mx-auto">
    <div class="flex space-x-4">
        <div class="relative flex-grow">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-coolicon-search-magnifying-glass class="w-5 h-5 text-gray-400" />
            </div>
            <input type="search" name="keyword" placeholder="Search for jobs..." value="{{ request('keyword') }}"
                class="w-full py-3 pl-10 pr-4 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
        </div>
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-coolicon-map-pin class="w-5 h-5 text-gray-400" />
            </div>
            <select name="state"
                class="w-full py-3 pl-10 pr-10 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg shadow-sm appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                <option value="">All States</option>
                @foreach (\App\Models\JobListing::getUniqueStates() as $state)
                    <option value="{{ $state }}" {{ request('state') == $state ? 'selected' : '' }}>
                        {{ $state }}</option>
                @endforeach
            </select>
        </div>
    </div>
</form>
