<div class="pagination_page">
    <div class="select-display-pagina">
        <p>{{__('common.paginate.display_per_page')}}</p>
        <form class="form-inline per-page" method="GET" role="form" action="{{secure_url(url()->current())}}">
            @foreach ($request->query() as $key => $value)
                @if(isset($value) & $key != 'page') <input name="{{$key}}" type="hidden" value="{{$value}}"> @endif
            @endforeach
            <div class="select">
                <select name="per_page">
                    <option value="10" @if($request->per_page == 10) selected @endif>10</option>
                    <option value="20" @if($request->per_page == 20) selected @endif>20</option>
                    <option value="50" @if($request->per_page == 50) selected @endif>50</option>
                    <option value="100" @if($request->per_page == 100) selected @endif>100</option>
                </select>
            </div>
        </form>

        <p class="ml-15">{{$paginator->total()}}{{__('common.label.records')}}</p>
    </div>
    {{ $paginator->links() }}
</div>

@push('script')
    <script type="text/javascript">
        $('select[name="per_page"]').on('change', function (){
            $('.per-page').submit();
        });
    </script>
@endpush

