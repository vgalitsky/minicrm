@if ($paginator->hasPages())
    <nav class="mini-pagination" aria-label="Pagination">
        <ul>
            <li class="is-nav {{ $paginator->onFirstPage() ? 'is-disabled' : '' }}">
                @if ($paginator->onFirstPage())
                    <span>&#8592; Prev</span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&#8592; Prev</a>
                @endif
            </li>

            @foreach ($elements as $element)
                @if (is_string($element))
                    <li class="is-dots"><span>{{ $element }}</span></li>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        <li class="{{ $page == $paginator->currentPage() ? 'is-active' : '' }}">
                            @if ($page == $paginator->currentPage())
                                <span>{{ $page }}</span>
                            @else
                                <a href="{{ $url }}">{{ $page }}</a>
                            @endif
                        </li>
                    @endforeach
                @endif
            @endforeach

            <li class="is-nav {{ $paginator->hasMorePages() ? '' : 'is-disabled' }}">
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">Next &#8594;</a>
                @else
                    <span>Next &#8594;</span>
                @endif
            </li>

        </ul>
    </nav>
@endif