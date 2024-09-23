@if (isset($results))
    <div class="space-y-6">
        @forelse($results as $job_listing)
            <div class="relative group">
                <div class="relative group">
                    <a href="{{ route('jobs.show', ['job_slug' => $job_listing->slug, 'id' => $job_listing->id]) }}"
                        class="block relative overflow-hidden transition duration-300 bg-white border rounded-lg shadow-sm group-hover:shadow-md {{ $job_listing->is_boosted ? 'border-l-2 rounded-l-none border-l-blue-500 bg-sky-50' : 'border-gray-200' }}">
                        <div class="relative flex items-center justify-between p-4 sm:p-6">

                            <!-- Logo -->
                            <img class="object-cover w-12 h-12 mr-3 rounded-full sm:w-16 sm:h-16 sm:mr-4"
                                src="{{ $job_listing->employer->logo ?? 'https://EquineHire-static-assets.s3.amazonaws.com/equine_pro_finder_placeholder.jpg' }}"
                                alt="{{ $job_listing->employer->name }} logo">

                            <!-- Job details and location -->
                            <div class="flex-grow min-w-0">
                                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start">
                                    <div>
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-base font-semibold text-gray-900 truncate sm:text-lg">
                                                {{ $job_listing->title }}</h3>
                                            @if ($job_listing->is_sticky || $job_listing->is_boosted)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 ml-2 sm:hidden">
                                                    Featured
                                                </span>
                                            @endif
                                        </div>
                                        <p class="flex items-center text-sm text-gray-500 truncate">
                                            <x-coolicon-house-03 class="w-4 h-4 mr-1" />
                                            {{ $job_listing->employer->name }}
                                            <span class="mx-2">|</span>
                                            <x-coolicon-checkbox-check class="w-4 h-4 mr-1" />
                                            {{ $job_listing->job_type }}
                                        </p>
                                        <div class="flex items-center mt-1 text-sm text-gray-500 sm:hidden">
                                            <x-coolicon-map-pin class="flex-shrink-0 w-4 h-4 mr-1" />
                                            <span class="truncate">
                                                @if ($job_listing->remote_position)
                                                    Remote
                                                @else
                                                    {{ $job_listing->city }}, {{ $job_listing->state }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Featured tag, Location, and Time -->
                                    <div
                                        class="mt-2 transition-opacity duration-300 sm:mt-0 sm:ml-4 sm:text-right group-hover:opacity-0">
                                        @if ($job_listing->is_sticky || $job_listing->is_boosted)
                                            <span
                                                class="hidden sm:inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 mb-2">
                                                Featured
                                            </span>
                                        @else
                                            <span
                                                class="items-center hidden text-sm text-gray-500 sm:flex sm:justify-end">
                                                <x-coolicon-clock class="w-4 h-4 mr-1" />
                                                {{ $job_listing->created_at->diffForHumans() }}
                                            </span>
                                        @endif
                                        <div class="items-center hidden text-sm text-gray-500 sm:flex sm:justify-end">
                                            <x-coolicon-map-pin class="w-4 h-4 mr-1" />
                                            @if ($job_listing->remote_position)
                                                <span>Remote</span>
                                            @else
                                                <span>{{ $job_listing->city }}, {{ $job_listing->state }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
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
                    </a>

                    <!-- View Job and Apply Now buttons -->
                    <div
                        class="absolute inset-0 items-center justify-end hidden p-6 transition-all duration-300 translate-y-4 opacity-0 pointer-events-none sm:flex group-hover:opacity-100 group-hover:translate-y-0">
                        <div class="pointer-events-auto">
                            <a href="{{ route('jobs.show', ['job_slug' => $job_listing->slug, 'id' => $job_listing->id]) }}"
                                class="inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                View Job
                            </a>
                            <a href="#" onclick="applyNow(event, '{{ $job_listing->id }}')"
                                class="inline-flex items-center px-4 py-2 text-sm font-medium text-black bg-white border border-black rounded-md shadow-sm hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Apply Now
                            </a>
                        </div>
                    </div>
                </div>

                <!-- View Job and Apply Now buttons -->
                <div
                    class="absolute inset-0 flex items-center justify-end p-6 transition-all duration-300 translate-y-4 opacity-0 pointer-events-none group-hover:opacity-100 group-hover:translate-y-0">
                    <div class="pointer-events-auto">
                        <a href="{{ route('jobs.show', ['job_slug' => $job_listing->slug, 'id' => $job_listing->id]) }}"
                            class="inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Job
                        </a>
                        <a href="#" onclick="applyNow(event, '{{ $job_listing->id }}')"
                            class="inline-flex items-center px-4 py-2 text-sm font-medium text-black bg-white border border-black rounded-md shadow-sm hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Apply Now
                        </a>
                    </div>
                </div>
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

<script>
    function applyNow(event, jobId) {
        event.preventDefault();
        // Add your apply now logic here
        console.log('Apply Now clicked for job ID:', jobId);
    }
</script>
