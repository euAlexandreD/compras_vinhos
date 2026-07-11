@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegação de página" class="pagination">

        <p class="pagination-summary">
            Mostrando
            @if ($paginator->firstItem())
                <strong>{{ $paginator->firstItem() }}</strong>
                a
                <strong>{{ $paginator->lastItem() }}</strong>
            @else
                {{ $paginator->count() }}
            @endif
            de
            <strong>{{ $paginator->total() }}</strong>
            resultados
        </p>

        <ul class="pagination-list">

            {{-- Previous Page Link --}}
            <li>
                @if ($paginator->onFirstPage())
                    <span class="pagination-arrow" aria-disabled="true">&laquo;</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="pagination-arrow" aria-label="Página anterior">&laquo;</a>
                @endif
            </li>

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li><span class="pagination-ellipsis">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li>
                            @if ($page == $paginator->currentPage())
                                <span class="pagination-current" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pagination-link" aria-label="Ir para a página {{ $page }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            <li>
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="pagination-arrow" aria-label="Próxima página">&raquo;</a>
                @else
                    <span class="pagination-arrow" aria-disabled="true">&raquo;</span>
                @endif
            </li>

        </ul>
    </nav>
@endif
