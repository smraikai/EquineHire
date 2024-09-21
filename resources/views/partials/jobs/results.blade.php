@if (isset($results))
    <div class="space-y-6">
        @forelse($results as $job_listing)
            <div
                class="relative overflow-hidden transition duration-300 bg-white border rounded-lg shadow-sm hover:shadow-md {{ $job_listing->is_boosted ? 'border-l-2 rounded-l-none border-l-blue-500 bg-sky-50' : 'border-gray-200' }}">
                <div class="flex items-center p-6">
                    <!-- Logo -->
                    <img class="object-cover w-16 h-16 mr-4 rounded-full"
                        src="{{ $job_listing->company->logo ?? 'https://EquineHire-static-assets.s3.amazonaws.com/equine_pro_finder_placeholder.jpg' }}"
                        alt="{{ $job_listing->company->name }} logo">

                    <!-- Job details and location -->
                    <div class="flex flex-col flex-grow sm:flex-row sm:justify-between sm:items-start">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">{{ $job_listing->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $job_listing->company->name }}</p>
                        </div>

                        <!-- Featured tag, Location, and Time -->
                        <div class="mt-2 sm:mt-0 sm:ml-4 sm:text-right">
                            <!-- ... (rest of the code remains the same) ... -->
                        </div>
                    </div>

                    <!-- View Job and Apply Now buttons -->
                    <div class="absolute inset-0 flex items-center justify-end p-6 transition-opacity duration-300 opacity-0 hover:opacity-100"
                        style="background: linear-gradient(to right, transparent 50%, {{ $job_listing->is_boosted ? 'rgb(240 249 255)' : 'white' }} 50%);">
                        <a href="{{ route('jobs.show', ['job_slug' => $job_listing->slug, 'id' => $job_listing->id]) }}"
                            class="z-10 inline-flex items-center px-4 py-2 mr-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            View Job
                        </a>
                        <a href="#"
                            class="z-10 inline-flex items-center px-4 py-2 text-sm font-medium text-black bg-white border border-black rounded-md shadow-sm hover:bg-black hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Apply Now
                        </a>
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
