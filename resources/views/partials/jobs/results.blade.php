@if (isset($results))
    <div class="space-y-6">
        @forelse($results as $job_listing)
            <div
                class="relative overflow-hidden transition duration-300 bg-white border rounded-lg shadow-sm hover:shadow-md {{ $job_listing->boosted ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                <a href="{{ route('jobs.show', ['job_slug' => $job_listing->slug, 'id' => $job_listing->id]) }}"
                    class="block">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img class="object-cover w-16 h-16 rounded-full"
                                    src="{{ $job_listing->company->logo ?? 'https://EquineHire-static-assets.s3.amazonaws.com/equine_pro_finder_placeholder.jpg' }}"
                                    alt="{{ $job_listing->company->name }} logo">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $job_listing->title }}</h3>
                                    <p class="text-sm font-medium text-gray-600">{{ $job_listing->company->name }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col items-end">
                                <div class="flex items-center space-x-2 text-sm text-gray-500">
                                    @if ($job_listing->remote_position)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Remote
                                        </span>
                                    @else
                                        <x-coolicon-map-pin class="w-4 h-4 text-gray-800" />
                                        <span class="font-bold text-gray-800">{{ $job_listing->city }},
                                            {{ $job_listing->state }}</span>
                                    @endif
                                </div>
                                <div class="mt-1 text-sm text-gray-500">
                                    Posted {{ $job_listing->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                        <div class="hidden mt-4 space-x-2 group-hover:flex">
                            <button
                                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Now
                            </button>
                            <button
                                class="px-4 py-2 text-sm font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Apply Now
                            </button>
                        </div>
                    </div>

                    @if ($job_listing->created_at->gt(now()->subWeeks(1)))
                        <div class="absolute top-2 left-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                New
                            </span>
                        </div>
                    @endif

                    @if ($job_listing->is_sticky && $job_listing->is_boosted)
                        <div class="absolute top-2 right-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                Featured
                            </span>
                        </div>
                    @elseif ($job_listing->is_sticky)
                        <div class="absolute top-2 right-2">
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                Featured
                            </span>
                        </div>
                    @endif
                </a>
            </div>
        @empty
            <div class="py-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">No job listings found</h3>
                <p class="mt-1 text-sm text-gray-500">No job listings match your search criteria.</p>
            </div>
        @endforelse
    </div>
    <div class="flex items-center justify-between mt-8">
        <p class="text-sm text-gray-700">
            Showing <span class="font-medium">{{ $results->firstItem() }}</span> to <span
                class="font-medium">{{ $results->lastItem() }}</span> of <span
                class="font-medium">{{ $results->total() }}</span> results
        </p>
        <div class="flex justify-end flex-1">
            {{ $results->links() }}
        </div>
    </div>
@endif
