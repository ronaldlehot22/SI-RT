@if ($paginator->hasPages())
<div class="flex items-center justify-between gap-3 mt-4">

    {{-- Prev --}}
    @if ($paginator->onFirstPage())
        <span class="flex-1 flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-gray-100 text-gray-300 text-sm font-semibold cursor-not-allowed bg-gray-50">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Sebelumnya
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="flex-1 flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-gray-200 text-gray-600 text-sm font-semibold active:bg-gray-50 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
            </svg>
            Sebelumnya
        </a>
    @endif

    {{-- Info --}}
    <span class="text-xs text-gray-400 font-medium whitespace-nowrap">
        Hal. {{ $paginator->currentPage() }}
    </span>

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="flex-1 flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-hijau-600 text-hijau-600 text-sm font-semibold active:bg-hijau-50 transition-colors">
            Selanjutnya
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    @else
        <span class="flex-1 flex items-center justify-center gap-2 py-3 rounded-2xl border-2 border-gray-100 text-gray-300 text-sm font-semibold cursor-not-allowed bg-gray-50">
            Selanjutnya
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </span>
    @endif

</div>

{{-- Total info --}}
<p class="text-center text-xs text-gray-400 mt-2">
    Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
</p>
@endif
