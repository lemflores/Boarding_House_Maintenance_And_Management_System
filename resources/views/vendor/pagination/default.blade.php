@if ($paginator->hasPages())
    <div class="flex items-center gap-1">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="w-8 h-8 rounded-lg bg-[#faf7f4] border border-[#ede7df] text-[#2d1a0e] flex items-center justify-center cursor-not-allowed" disabled>
                ‹
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="w-8 h-8 rounded-lg bg-[#faf7f4] border border-[#ede7df] text-[#2d1a0e] hover:bg-[#7c3a1e] hover:text-white transition-colors flex items-center justify-center">
                ‹
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="text-gray-300 text-[12px] px-1">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="w-8 h-8 rounded-lg bg-[#7c3a1e] text-white text-[12px] font-bold">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="w-8 h-8 rounded-lg bg-[#faf7f4] border border-[#ede7df] text-[#2d1a0e] text-[12px] hover:bg-[#7c3a1e] hover:text-white transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="w-8 h-8 rounded-lg bg-[#faf7f4] border border-[#ede7df] text-[#2d1a0e] hover:bg-[#7c3a1e] hover:text-white transition-colors flex items-center justify-center">
                ›
            </a>
        @else
            <button class="w-8 h-8 rounded-lg bg-[#faf7f4] border border-[#ede7df] text-[#2d1a0e] flex items-center justify-center cursor-not-allowed" disabled>
                ›
            </button>
        @endif
    </div>
@endif