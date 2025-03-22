@extends('layouts.admin')

@php
    $metaTitle = 'Applications | EquineHire Admin';
    $pageTitle = 'Manage Applications';
@endphp

@section('content')
    <div class="container py-12 mx-auto">
        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="p-6">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h2 class="text-lg font-medium text-gray-900">Applications</h2>
                            <p class="mt-2 text-sm text-gray-700">A list of all job applications in the system.</p>
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
                                                Applicant</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Job
                                                Listing</th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Employer
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status
                                            </th>
                                            <th scope="col"
                                                class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                                <span class="sr-only">Actions</span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($applications as $application)
                                            <tr>
                                                <td class="py-4 pl-4 pr-3 text-sm whitespace-nowrap sm:pl-0">
                                                    <div class="flex items-center">
                                                        <div class="ml-4">
                                                            <div class="font-medium text-gray-900">
                                                                @if ($application->jobSeeker && $application->jobSeeker->user)
                                                                    {{ $application->jobSeeker->user->name }}
                                                                @else
                                                                    <span class="text-gray-500 italic">Unknown
                                                                        applicant</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-gray-500">
                                                                @if ($application->jobSeeker && $application->jobSeeker->user)
                                                                    {{ $application->jobSeeker->user->email }}
                                                                @else
                                                                    <span class="italic">No email available</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($application->jobListing)
                                                        <div class="font-medium">{{ $application->jobListing->title }}</div>
                                                        <div class="text-xs text-gray-500">
                                                            {{ Str::limit($application->jobListing->description_plain, 30) }}
                                                        </div>
                                                    @else
                                                        <span class="italic">Deleted job listing</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500">
                                                    @if ($application->jobListing && $application->jobListing->employer)
                                                        <div>{{ $application->jobListing->employer->name }}</div>
                                                        @if ($application->jobListing->location)
                                                            <div class="text-xs">{{ $application->jobListing->location }}
                                                            </div>
                                                        @endif
                                                    @else
                                                        <span class="italic">Unknown employer</span>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 text-sm whitespace-nowrap">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                {{ $application->status === 'new'
                                                    ? 'bg-blue-100 text-blue-800'
                                                    : ($application->status === 'reviewed'
                                                        ? 'bg-yellow-100 text-yellow-800'
                                                        : ($application->status === 'contacted'
                                                            ? 'bg-green-100 text-green-800'
                                                            : 'bg-red-100 text-red-800')) }}">
                                                        {{ ucfirst($application->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                                                    {{ $application->created_at->format('M d, Y') }}</td>
                                                <td
                                                    class="relative py-4 pl-3 pr-4 text-sm font-medium text-right whitespace-nowrap sm:pr-0">
                                                    <a href="{{ route('admin.applications.show', $application->id) }}"
                                                        class="text-blue-600 hover:text-blue-900">View Application</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        {{ $applications->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
