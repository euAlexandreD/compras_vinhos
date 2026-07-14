@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegação de página" class="flex flex-col items-center gap-3 border-t border-border pt-5 sm:flex-row sm:justify-between">

        <p class="text-sm text-muted">
            Mostrando
            @if ($paginator->firstItem())
                <strong class="text-ink">{{ $paginator->firstItem() }}</strong>
                a
                <strong class="text-ink">{{ $paginator->lastItem() }}</strong>
            @else
                {{ $paginator->count() }}
            @endif
            de
            <strong class="text-ink">{{ $paginator->total() }}</strong>
            resultados
        </p>

        <ul class="no-scrollbar flex max-w-full items-center gap-1.5 overflow-x-auto">

            {{-- Previous Page Link --}}
            <li>
                @if ($paginator->onFirstPage())
                    <span class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-border bg-bg px-2 text-muted">&laquo;</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-border px-2 text-primary hover:border-primary hover:bg-primary-light" aria-label="Página anterior">&laquo;</a>
                @endif
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="flex h-9 min-w-9 items-center justify-center px-1 text-muted">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span class="flex h-9 min-w-9 items-center justify-center rounded-lg bg-primary px-2 font-medium text-white" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-border px-2 font-medium text-primary hover:border-primary hover:bg-primary-light" aria-label="Ir para a página {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-border px-2 text-primary hover:border-primary hover:bg-primary-light" aria-label="Próxima página">&raquo;</a>
                @else
                    <span class="flex h-9 min-w-9 items-center justify-center rounded-lg border border-border bg-bg px-2 text-muted">&raquo;</span>
                @endif
            </li>

        </ul>
    </nav>
@endif
