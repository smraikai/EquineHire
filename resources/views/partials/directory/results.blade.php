@if (isset($businesses))
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
        @forelse($businesses as $business)
            <a href="{{ route('businesses.directory.show', ['state_slug' => $business->state_slug, 'slug' => $business->slug, 'id' => $business->id]) }}"
                class="block overflow-hidden transition-shadow bg-white border border-gray-200 rounded-lg hover:-translate-y-1 hover:shadow-lg hover:shadow-slate-50">
                <div class="flex flex-col">
                    @if ($business->featured_image)
                        <div class="relative pb-56">
                            <img src="{{ $business->featured_image }}" alt="Featured Image"
                                class="absolute object-cover w-full h-full">
                        </div>
                    @else
                        <div class="relative pb-56">
                            <img src="https://EquineHire-static-assets.s3.amazonaws.com/equine_pro_finder_placeholder.jpg"
                                alt="Placeholder Image" class="absolute object-cover w-full h-full">
                        </div>
                    @endif
                    <div class="flex flex-col justify-between flex-grow p-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900">{{ $business->name }}</h3>
                            <p class="text-sm text-gray-500">{{ $business->city }}, {{ $business->state }}</p>
                            <p class="mt-2 text-sm text-gray-600">
                                {{ Str::limit(strip_tags($business->description), 120) }}
                            </p>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-4">
                            @foreach ($business->categories->take(5) as $category)
                                <span class="px-2 py-1 text-xs font-semibold text-emerald-800 bg-emerald-100 rounded">
                                    {{ $category->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-2">
                <p class="text-gray-500">No businesses found for your search criteria.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-4 mb-4 text-sm text-gray-500">
        {{ $businesses->total() }} Results
    </div>
    <div class="flex justify-center mt-4">
        {{ $businesses->links() }}
    </div>
@endif
