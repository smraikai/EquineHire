<div class="overflow-hidden bg-white rounded-lg shadow">
    <div class="p-6">
        <h2 class="mb-4 text-lg font-semibold text-gray-900">Recent Applications</h2>

        @if ($recentApplications->isEmpty())
            <p class="text-gray-500">No applications yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                Applicants
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Position
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Status
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Date
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach ($recentApplications as $application)
                            <tr>
                                <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                                    <div class="font-medium text-gray-900">{{ $application->name }}</div>
                                    <div class="text-gray-500">{{ $application->email }}</div>
                                </td>
                                <td class="px-3 py-4 text-sm text-gray-500">
                                    <div class="text-gray-900">{{ $application->jobListing->title }}</div>
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
        @endif
    </div>
</div>
