@extends('layouts.admin')

@php
    $metaTitle = 'Employers | EquineHire Admin';
    $pageTitle = 'Manage Employers';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-medium text-gray-900">Employers</h2>
                            <p class="mt-2 text-sm text-gray-700">A list of all employers registered in the system.</p>
                        </div>
                    </div>
                    <div class="mt-6 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                Employer</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact
                                                Info</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Location
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Listings
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Created
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($employers as $employer)
                                            <tr>
                                                <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-10 w-10">
                                                            @if ($employer->logo)
                                                                <img class="h-10 w-10 rounded-full"
                                                                    src="{{ Storage::url($employer->logo) }}"
                                                                    alt="">
                                                            @else
                                                                <div
                                                                    class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500">
                                                                    <x-heroicon-o-building-office class="h-6 w-6" />
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="ml-4">
                                                            <div class="font-medium text-gray-900">{{ $employer->name }}
                                                            </div>
                                                            <div class="text-gray-500">
                                                                @if ($employer->user)
                                                                    {{ $employer->user->name }}
                                                                @else
                                                                    <span class="italic">No user</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($employer->user)
                                                        <div>{{ $employer->user->email }}</div>
                                                    @else
                                                        <span class="italic">No email</span>
                                                    @endif
                                                    @if ($employer->website)
                                                        <div>{{ $employer->website }}</div>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @php
                                                        $address = array_filter([
                                                            $employer->city,
                                                            $employer->state,
                                                            $employer->country,
                                                        ]);
                                                    @endphp
                                                    {{ !empty($address) ? implode(', ', $address) : 'No location' }}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 text-center">
                                                    {{ $employer->jobListings()->count() }}
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ $employer->created_at->format('M d, Y') }}
                                                </td>
                                                <td
                                                    class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                    <a href="{{ route('employers.show', $employer->id) }}"
                                                        class="text-blue-600 hover:text-blue-900">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        {{ $employers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
