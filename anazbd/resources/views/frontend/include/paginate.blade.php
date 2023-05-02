@push('css')
    <style>
        .pagination .disabled a {
            cursor: default;
        }
        .pagination .disabled a:hover {
            background: #f1f1f1;
            color: inherit;
        }
    </style>
@endpush

<div class="shop_toolbar t_bottom">
    <div class="pagination">
        <ul class="">
            <li class="@if($data->appends(request()->query())->currentPage() == 1) disabled @endif">
                <a class="" href="{{ $data->appends(request()->query())->previousPageUrl() }}">
                    <i class="fa fa-angle-double-left"></i>
                </a>
            </li>

            @foreach(range(1, $data->appends(request()->query())->lastPage()) as $i)
                @if($i >= $data->appends(request()->query())->currentPage() - 4 && $i <= $data->appends(request()->query())->currentPage() + 4)
                    @if ($i == $data->appends(request()->query())->currentPage())
                        <li class="current"><span>{{ $i }}</span></li>
                    @else
                        <li><a href="{{ $data->appends(request()->query())->url($i) }}">{{ $i }}</a></li>
                    @endif
                @endif
            @endforeach

            <li class=" @if($data->appends(request()->query())->lastPage() == $data->appends(request()->query())->currentPage()) disabled @endif">
                <a class="" href="{{ $data->appends(request()->query())->nextPageUrl() }}"><i
                        class="fa fa-angle-double-right"></i></a>
            </li>
        </ul>
    </div>
</div>

@push('js')
    <script>
        $(document).ready(function () {
            $('.pagination .disabled a').on('click', function (e) {
                e.preventDefault();
            });
        })
    </script>
@endpush
