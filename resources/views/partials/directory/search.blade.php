<form action="{{ route('businesses.directory') }}" method="GET"
    class="flex flex-col lg:flex-row items-stretch p-0 bg-white rounded-md overflow-hidden {{ Route::currentRouteName() === 'home' ? 'border-none' : 'lg:border lg:border-gray-200' }}">
    <!-- Keyword Input -->
    <div class="w-full mb-2 lg:flex-grow lg:mb-0">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-coolicon-search-magnifying-glass class="w-5 h-5 text-gray-400" />
            </div>
            <input type="text" name="keyword" placeholder="Enter keyword..."
                class="w-full pl-10 border-none rounded-full lg:rounded-none" style="outline: none; box-shadow: none;"
                value="{{ request('keyword') }}">
        </div>
    </div>
    <!-- Location Input -->
    <div class="w-full mb-2 lg:flex-grow lg:mb-0">
        <div class="relative">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <x-coolicon-map-pin class="w-5 h-5 text-gray-400" />
            </div>
            <input type="text" name="location" id="location"
                class="w-full pl-10 border border-transparent rounded-full lg:border-l-gray-200 lg:rounded-none"
                style="outline: none; box-shadow: none;">
        </div>
    </div>
    <!-- Search Button -->
    <button type="submit"
        class="w-full px-4 py-3 font-bold text-white rounded-md lg:w-auto bg-blue-700 hover:bg-blue-800 lg:rounded-tr-md lg:rounded-br-md lg:rounded-none">
        <span class="lg:hidden">Search</span>
        <x-coolicon-search-magnifying-glass class="hidden w-5 h-5 text-white lg:block" />
    </button>
</form>
