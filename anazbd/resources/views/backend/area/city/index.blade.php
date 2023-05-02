@extends('admin.layout.master')
@section('title','City List')
@section('page-header')
    <i class="fa fa-list"></i> City List
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
       'name' => 'Create City',
       'route' => route('backend.area.city.create')
    ])  --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row">
                        <div class="col">
                            <h4>Cities</h4>
                        </div>
                        <div class="col text-right">
                            <a href="{{ route('backend.area.city.create') }}" class="btn btn-sm btn-primary"><i class="fa fa-plus"> New City</i></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th class="" style="width: 5%">SL</th>
                            <th class="" style="width: 5%">Division</th>
                            <th class="" style="width: 30%">City</th>
                            <th class="" style="width: 10%">Action</th>
                        </tr>
                
                        @foreach($cities as $key => $city)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $city->division_name }}</td>
                                <td>{{ $city->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <a href="{{ route('backend.area.city.show', ['id' => $city->id]) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-edit"></i>
                                        </a>
                
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{ $city->id }})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.area.city.destroy', ['id' => $city->id]) }}"
                                          id="deleteCheck_{{ $city->id }}" method="GET">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$cities->links()}}
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
