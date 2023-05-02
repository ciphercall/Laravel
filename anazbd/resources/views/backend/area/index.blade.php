@extends('admin.layout.master')
@section('title','Division List')
@section('page-header')
    <i class="fa fa-list"></i> Area Division List
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
    {{--  @include('backend.components.page_header', [
       'fa' => 'fa fa-pencil',
       'name' => 'Create Division',
       'route' => route('backend.area.create-division')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Divisions</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.area.create-division') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus">New Division</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="" style="width: 5%">SL</th>
                            <th class="" style="width: 30%">Division</th>
                            <th class="" style="width: 10%">Action</th>
                        </tr>
                        @foreach($divisions as $key => $division)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $division->name }}</td>
                            <td>
                                <div class="btn-group btn-group-mini btn-corner">
                                    <a href="{{ route('backend.area.edit',['id' => $division->id]) }}"
                                       class="btn btn-xs btn-info"
                                       title="Edit">
                                        <i class="ace-icon fa fa-edit"></i>
                                    </a>
                
                                    <button type="button" class="btn btn-xs btn-danger"
                                            onclick="delete_check({{ $division->id }})"
                                            title="Delete">
                                        <i class="ace-icon fa fa-trash"></i>
                                    </button>
                                </div>
                                <form action="{{ route('backend.area.destroy', ['id' => $division->id]) }}"
                                      id="deleteCheck_{{ $division->id }}" method="GET">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                        @endforeach
                
                
                
                {{--        @forelse($origins as $key => $origin)--}}
                {{--            <tr>--}}
                {{--                <td>{{ $key + 1 }}</td>--}}
                {{--                <td>{{ $origin->name }}</td>--}}
                {{--                <td>{{ $origin->slug }}</td>--}}
                {{--                <td>--}}
                {{--                    <img src="{{ asset($origin->image) }}"--}}
                {{--                         height="30"--}}
                {{--                         width="120"--}}
                {{--                         alt="No Image">--}}
                {{--                </td>--}}
                {{--                <td>--}}
                {{--                    <div class="btn-group btn-group-mini btn-corner">--}}
                {{--                        <a href="{{ route('backend.product.origins.edit', $origin->id) }}"--}}
                {{--                           class="btn btn-xs btn-info"--}}
                {{--                           title="Edit">--}}
                {{--                            <i class="ace-icon fa fa-pencil"></i>--}}
                {{--                        </a>--}}
                
                {{--                        <button type="button" class="btn btn-xs btn-danger"--}}
                {{--                                onclick="delete_check({{$origin->id}})"--}}
                {{--                                title="Delete">--}}
                {{--                            <i class="ace-icon fa fa-trash-o"></i>--}}
                {{--                        </button>--}}
                {{--                    </div>--}}
                {{--                    <form action="{{ route('backend.product.origins.destroy', $origin->id)}}"--}}
                {{--                          id="deleteCheck_{{ $origin->id }}" method="GET">--}}
                {{--                        @csrf--}}
                {{--                    </form>--}}
                {{--                </td>--}}
                {{--            </tr>--}}
                {{--        @empty--}}
                {{--            <tr>--}}
                {{--                <td colspan="6">No data available in table</td>--}}
                {{--            </tr>--}}
                {{--        @endforelse--}}
                        </tbody>
                    </table>
                    {{$divisions->links()}}
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('js')
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
@endpush
