@if ($paginator->hasPages())
    <div class="paginasi">
        @if ($paginator->onFirstPage())
            <span class="btn btn-abu btn-kecil" style="opacity:.5">Sebelumnya</span>
        @else
            <a class="btn btn-abu btn-kecil" href="{{ $paginator->previousPageUrl() }}">Sebelumnya</a>
        @endif

        <span>Halaman {{ $paginator->currentPage() }}</span>

        @if ($paginator->hasMorePages())
            <a class="btn btn-abu btn-kecil" href="{{ $paginator->nextPageUrl() }}">Berikutnya</a>
        @else
            <span class="btn btn-abu btn-kecil" style="opacity:.5">Berikutnya</span>
        @endif
    </div>
@endif
