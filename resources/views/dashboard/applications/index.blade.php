@extends('layouts.app')

@php
    $metaTitle = 'Job Applications | EquineHire';
    $pageTitle = 'Job Applications';
@endphp

@section('content')
    <div class="container px-4 py-12 mx-auto sm:py-24">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if ($applications->isEmpty())
                <div class="flex flex-col items-center p-6 bg-white rounded-md">
                    <p class="text-sm text-gray-600">No applications yet.</p>
                </div>
            @else
                <div class="flex flex-col gap-5 px-4 sm:px-6 lg:px-8">
                    <div class="order-1 flow-root sm:order-2">
                        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 align-middle shadow sm:px-6 lg:px-8 ring-1 ring-black ring-opacity-5 ">
                                <div class="overflow-hidden shadow sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    Applicants
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Position
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Status
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Date
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Actions
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-100">
                                            @foreach ($applications as $application)
                                                <tr>
                                                    <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                                        <div class="font-medium text-gray-900">{{ $application->name }}
                                                        </div>
                                                        <div class="text-gray-500">{{ $application->email }}</div>
                                                    </td>
                                                    <td class="px-3 py-4 text-sm text-gray-500">
                                                        <div class="text-gray-900">{{ $application->jobListing->title }}
                                                        </div>
                                                    </td>
                                                    <td class="px-3 py-4 text-sm text-gray-500">
                                                        <span
                                                            class="inline-flex px-2 text-xs font-semibold leading-5 rounded-full {{ $application->getStatusBadgeColor() }}">
                                                            {{ ucfirst($application->status ?? 'new') }}
                                                        </span>
                                                    </td>
                                                    <td class="px-3 py-4 text-sm text-gray-500">
                                                        {{ $application->created_at->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-3 py-4 text-sm text-gray-500">
                                                        <a href="{{ route('employer.applications.show', $application) }}"
                                                            class="text-blue-600 hover:text-blue-900">View</a>
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
                <div class="flex justify-center mx-auto">
                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
