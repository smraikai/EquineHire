@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gray-100">
        <div class="py-12 mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="fixed bottom-0 left-0 right-0 p-4 mb-4 text-sm text-blue-800 bg-blue-50 rounded-lg mx-auto text-center max-w-[90%] shadow-lg"
                    role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="mb-8 text-4xl font-bold text-gray-900">Admin Dashboard</h1>

            <div class="flex flex-col gap-10">
                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-2xl font-semibold text-gray-800">Create New Listings</h2>
                    <p class="mb-4 text-gray-600">You don't have any business listings yet.</p>
                    <a href="{{ route('company.create') }}"
                        class="inline-flex items-center px-6 py-3 text-sm font-medium text-white transition duration-150 ease-in-out rounded-md bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <x-coolicon-add-plus-circle class="w-5 h-5 mr-2" />
                        Create New Listing
                    </a>
                </div>

                <div class="p-6 bg-white rounded-lg shadow-md">
                    <h2 class="mb-4 text-2xl font-semibold text-gray-800">Manage Existing Listings</h2>
                    <div class="overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="text-xs font-semibold text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="p-3 text-left">Business</th>
                                    <th class="p-3 text-left">Owner</th>
                                    <th class="p-3 text-left">Business Actions</th>
                                    <th class="p-3 text-left">Owner Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-gray-100">
                                @foreach ($businesses as $business)
                                    <tr>
                                        <td class="p-3">
                                            <a href="{{ url('/' . $business->state_slug . '/' . $business->slug . '-' . $business->id) }}"
                                                class="font-medium text-blue-600 hover:text-blue-800">{{ $business->name }}</a>
                                        </td>
                                        <td class="p-3">
                                            <a href="{{ route('admin.users.show', $business->user) }}"
                                                class="text-gray-700 hover:text-gray-900">{{ $business->user->name }}</a>
                                        </td>
                                        <td class="p-3">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.company.edit', $business) }}"
                                                    class="text-blue-600 hover:text-blue-800">Edit</a>
                                                <form action="{{ route('admin.company.destroy', $business) }}"
                                                    method="POST" class="inline"
                                                    onsubmit="return confirm('Are you sure you want to delete this business listing?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="p-3">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.users.edit', $business->user) }}"
                                                    class="text-blue-600 hover:text-blue-800">Edit</a>
                                                <form action="{{ route('admin.users.destroy', $business->user) }}"
                                                    method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-800">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
