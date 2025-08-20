@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center space-x-2">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1 text-gray-400 border rounded-lg">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-3 py-1 border rounded-lg hover:bg-emerald-100">‹</a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-1 text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1 bg-emerald-600 text-white border rounded-lg">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-3 py-1 border rounded-lg hover:bg-emerald-100">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-3 py-1 border rounded-lg hover:bg-emerald-100">›</a>
        @else
            <span class="px-3 py-1 text-gray-400 border rounded-lg">›</span>
        @endif
    </nav>
@endif
