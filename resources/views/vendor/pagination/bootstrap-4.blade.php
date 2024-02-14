@if ($paginator->hasPages())
    <ul class="pagination justify-content-center" role="navigation">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                <a class="page-link" href="">{{__('common.paginate.previous')}}</a>
            </li>
        @else
            <li class="page-item">
                <a class="page-link active" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')">
                    {{__('common.paginate.previous')}}</a>
            </li>
        @endif
            <?php
                $start = $paginator->currentPage() - 2; // show 3 pagination links before current
                $end = $paginator->currentPage() + 2; // show 3 pagination links after current
                if($start < 1) {
                    $start = 1; // reset start to 1
                    $end += 1;
                }
                if($end >= $paginator->lastPage() ) $end = $paginator->lastPage(); // reset end to last page
            ?>

        @if($start > 1)
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url(1) }}">{{1}}</a>
            </li>
            @if($paginator->currentPage() != 4)
                <li class="page-item"><a class="page-link" href="#">...</a></li>
            @endif
        @endif
        @for ($i = $start; $i <= $end; $i++)
            <li class="page-item">
                <a class="page-link {{ ($paginator->currentPage() == $i) ? ' active' : '' }}" href="{{ $paginator->url($i) }}">{{$i}}</a>
            </li>
        @endfor
        @if($end < $paginator->lastPage())
            @if($paginator->currentPage() + 3 != $paginator->lastPage())
                <li class="page-item"><a class="page-link" href="#">...</a></li>
            @endif
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}">{{$paginator->lastPage()}}</a>
            </li>
        @endif

        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')">{{__('common.paginate.next')}}</a>
            </li>
        @else
            <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                <a class="page-link" href="">{{__('common.paginate.next')}}</a>
            </li>
        @endif
    </ul>
@endif
