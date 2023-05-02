@extends('backend.layouts.master')
@section('title','WishLists')
@section('page-header')
    <i class="fa fa-heart"></i> WishList
@stop
@push('css')
    <style>
        table th,
        td {
            text-align: center !important;
            vertical-align: middle !important;
        }
    </style>
@endpush

@section('content')
    <table class="table table-bordered table-hover">
        <tbody>
        <tr>
            <th class="bg-dark" style="width: 4%">SL</th>
            <th class="bg-dark" style="width: 10%">User</th>
            <th class="bg-dark" style="width: 10%">Mobile / Email</th>
            <th class="bg-dark" style="width: 36%">Item</th>
            <th class="bg-dark" style="width: 12%">Created At</th>
        </tr>
        @forelse($wishlists as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->email != null ? $item->user->email : $item->user->mobile  }}</td>
                <td><a href="{{ route('frontend.product',$item->items->slug) }}">{{ $item->items->name }}</a></td>
                <td>{{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No data available in table</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    @include('backend.partials._paginate', ['data' => $wishlists])
@endsection

{{--  @push('js')
    <script type="text/javascript">
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width: 400,
            }).then((result) => {
                if (result.value) {
                    $('#deleteCheck_' + id).submit();
                }
            })
        }
    </script>
@endpush  --}}
