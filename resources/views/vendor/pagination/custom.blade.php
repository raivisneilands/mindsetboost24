@if ($paginator->hasPages())
    <nav class="flex items-center justify-center space-x-2 mt-8">
        
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">
                ← Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                ← Prev
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-gray-500">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-4 py-2 rounded-lg bg-emerald-700 text-white font-semibold">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 rounded-lg bg-white border border-emerald-300 text-emerald-700 hover:bg-emerald-50">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
                Next →
            </a>
        @else
            <span class="px-4 py-2 rounded-lg bg-gray-200 text-gray-500 cursor-not-allowed">
                Next →
            </span>
        @endif

    </nav>
@endif
