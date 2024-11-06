@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}"
        class="flex items-center justify-between px-4 py-3-t sm:px-6">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-md cursor-default">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-100">
                    {!! __('pagination.previous') !!}
                </a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white rounded-md hover:bg-gray-100 ">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span
                    class="inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-400 bg-gray-100 rounded-md cursor-default ">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden rounded-md sm:flex-1 sm:flex sm:items-center sm:justify-between">

            <div>
                <span class="relative z-0 inline-flex rounded-md shadow-sm">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white cursor-default rounded-l-md">
                            <span class="sr-only">{{ __('pagination.previous') }}</span>
                            <x-coolicon-chevron-left-md class="w-5 h-5" />
                        </span>
                    @else
                        <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium bg-white text-gray-1000 rounded-l-md hover:text-gray-700 hover:bg-gray-100">
                            <span class="sr-only">{{ __('pagination.previous') }}</span>
                            <x-coolicon-chevron-left-md class="w-5 h-5" />
                        </a>
                    @endif

                    {{-- Pagination Elements --}}
                    @php
                        $start = max($paginator->currentPage() - 2, 1);
                        $end = min($paginator->currentPage() + 2, $paginator->lastPage());
                    @endphp

                    @if ($start > 1)
                        <a href="{{ $paginator->url(1) }}"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">
                            1
                        </a>
                        @if ($start > 2)
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white cursor-default">
                                ...
                            </span>
                        @endif
                    @endif

                    @for ($page = $start; $page <= $end; $page++)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 cursor-default">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $paginator->url($page) }}"
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">
                                {{ $page }}
                            </a>
                        @endif
                    @endfor

                    @if ($end < $paginator->lastPage())
                        @if ($end < $paginator->lastPage() - 1)
                            <span
                                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white cursor-default">
                                ...
                            </span>
                        @endif
                        <a href="{{ $paginator->url($paginator->lastPage()) }}"
                            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-100">
                            {{ $paginator->lastPage() }}
                        </a>
                    @endif

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <a href="{{ $paginator->nextPageUrl() }}" rel="next"
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium bg-white text-gray-1000 rounded-r-md hover:text-gray-700 hover:bg-gray-100">
                            <span class="sr-only">{{ __('pagination.next') }}</span>
                            <x-coolicon-chevron-right-md class="w-5 h-5" />
                        </a>
                    @else
                        <span
                            class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-400 bg-white cursor-default rounded-r-md">
                            <span class="sr-only">{{ __('pagination.next') }}</span>
                            <x-coolicon-chevron-right-md class="w-5 h-5" />
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
