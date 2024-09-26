@if (isset($results))
    <div class="space-y-6">
        @forelse($results as $job_listing)
            @include('partials.jobs.list')
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
