@extends('backend.layouts.master')

@section('title','Seller-List')
@section('page-header')
    <i class="fa fa-list"></i> Seller List
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
    @include('backend.components.page_header')

    <form class="form-horizontal" method="post" action="{{ route('admin.seller.search') }}" role="form" enctype="multipart/form-data">
        @csrf
        <table class="table table-bordered">
            <tbody><tr>
                <th  class="bg-dark" style="width: 22%"><label for="name">Name - Number - Email - Shopname </label></th>
                <th class="bg-dark" style="width: 12%;">Actions</th>
            </tr>
            <tr>
                <td>
                    <input type="text" id="myInput" name="search" placeholder="Name - Number - Email - Shopname search here.." value="" class="input-sm form-control text-center" required>
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <button type="submit" class="btn btn-xs btn-primary" title="Search">
                            <i class="ace-icon fa fa-search"></i>
                        </button>

                    <a href="{{ route('backend.seller.index') }}" class="btn btn-xs btn-info" title="Show All">
                            <i class="ace-icon fa fa-list"></i>
                        </a>
                    </div>
                </td>
            </tr>
        </tbody></table>
    </form>
    <table class="table table-bordered" id="table1">
        <tbody>
        <tr>
            <th class="bg-dark" >SL</th>
            <th class="bg-dark" >Name</th>
            <th class="bg-dark" >Email</th>
            <th class="bg-dark" >Mobile</th>
            <th class="bg-dark" >Type</th>
            {{-- <th class="bg-dark" >Status</th> --}}
            <th class="bg-dark" >Image</th>
            <th class="bg-dark" >Status</th>
            <th class="bg-dark" style="">Action</th>
        </tr>
        @forelse($sellers as $key => $seller)
            <tr>
                <td>{{ $key+1 }}</td>
                <td> {{ $seller->name }}</td>
                <td>{{ $seller->email ?? '-' }}</td>
                <td>{{ $seller->mobile ?? '-' }}</td>
                <td><span class="label label-md label-{{$seller->type? 'primary' : ' '}} arrowed-in arrowed-in-right">{{ $seller->type ? 'Business' : 'Personal' }}</span></td>
                {{-- <td><span class="badge badge-{{$seller->type ? 'info' : 'primary'}}">{{ $seller->type ? 'Business' : 'Personal' }}</span></td> --}}
                <td><img src="{{ asset($seller->image) }}" alt="{{$seller->image}}" height="20"></td>
                <td>
                    <label class="pull-center inline">
                    <input  data-id="{{$seller->id}}" id="id-button-borders" {{ $seller->status == true ? "Checked" :' ' }} type="checkbox" class="ace ace-switch ace-switch-5 toggle-class"">
                        <span class="lbl middle"></span>
                    </label>
                </td>
                <td>
                    <div class="btn-group btn-group-mini btn-corner">
                        <a href="{{ route('backend.seller.show',$seller->id)}}"
                            class="btn btn-xs btn-info"
                            title="view">
                            <i class="ace-icon fa fa-eye"></i>
                        </a>
                        <a href="{{ route('backend.seller.edit',$seller->id)}}"
                            class="btn btn-xs btn-warning"
                            title="Edit">
                            <i class="ace-icon fa fa-pencil"></i>
                        </a>

                        <button type="button" class="btn btn-xs btn-danger"
                                onclick="delete_check({{$seller->id}})"
                                title="Delete">
                            <i class="ace-icon fa fa-trash-o"></i>
                        </button>
                    </div>
                    <form action="{{ route('backend.seller.destroy',$seller->id) }}"
                        id="deleteCheck_{{ $seller->id }}" method="GET">
                        @csrf
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">No data available in table</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @include('backend.partials._paginate', ['data' => $sellers])
@endsection

@push('js')
    <script type="text/javascript">

        $('.toggle-class').change(function() {
            var status      = $(this).prop('checked') == true ;
            var seller_id   = $(this).data('id');
            let url         = "{{ route('backend.seller.status',":seller_id") }}";
            url             = url.replace(':seller_id',seller_id);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: url,
                data: {'status': status},
                success: function(data){
                    swal.fire(data.success);
                }
            });
        });

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
@endpush

