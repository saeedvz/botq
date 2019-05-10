<nav class="pagination margin-top--sm margin-bottom--sm" aria-label="Pagination">
    <ol class="pagination__list">
        <li>
            <a href="{{ $paginator->url(1) }}" class="pagination__item {{ ($paginator->currentPage() == 1) ? 'pagination__item--disabled' : '' }}" aria-label="{{ __('Previous') }}">
                <em class="icon-text">
                    <svg class="icon" aria-hidden="true" viewBox="0 0 16 16">
                        <title>{{ __('Previous') }}</title>
                        <g stroke-width="1" stroke="currentColor">
                            <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6.5,3.5 11,8 6.5,12.5 "></polyline>
                        </g>
                    </svg>
                    <span>{{ __('Previous') }}</span>
                </em>
            </a>
        </li>
        @for ($i = 1; $i <= $paginator->lastPage(); $i++)
            <li class="display--sm">
                <a href="{{ $paginator->url($i) }}" class="pagination__item {{ ($paginator->currentPage() == $i) ? 'pagination__item--selected' : '' }}" aria-label="{{ $i }}" @if(($paginator->currentPage() == $i)) aria-current="page" @endif>{{ $i }}</a>
            </li>
        @endfor
        <li>
            <a href="{{ $paginator->url($paginator->currentPage()+1) }}" class="pagination__item {{ ($paginator->currentPage() == $paginator->lastPage()) ? ' pagination__item--disabled' : '' }}" aria-label="{{ __('Next') }}">
                <em class="icon-text">
                    <span>{{ __('Next') }}</span>
                    <svg class="icon" aria-hidden="true" viewBox="0 0 16 16">
                        <title>{{ __('Previous') }}</title>
                        <g stroke-width="1" stroke="currentColor">
                            <polyline fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="9.5,3.5 5,8 9.5,12.5 "></polyline>
                        </g>
                    </svg>
                </em>
            </a>
        </li>
    </ol>
</nav>
