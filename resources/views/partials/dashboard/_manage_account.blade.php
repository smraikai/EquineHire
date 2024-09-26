<div class="overflow-hidden">
    <div class="p-4 sm:p-6">
        <h2 class="text-lg font-medium leading-6 text-gray-900 sm:text-xl">Account Settings</h2>
        <p class="mt-1 text-sm text-gray-500">Edit email, password, or delete account.</p>
        <a href="{{ route('profile.edit') }}"
            class="inline-flex items-center px-4 py-2 mt-4 text-sm font-bold text-white transition-colors duration-200 ease-in-out bg-blue-700 rounded-md hover:bg-blue-800">
            <x-coolicon-user-01 class="w-5 h-5 mr-2" />
            Edit Profile
        </a>
    </div>
</div>
