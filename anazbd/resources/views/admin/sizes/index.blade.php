@extends('admin.layout.master')
@section('title','Sizes List')
@section('page-header')
    <i class="fa fa-list"></i> Size List
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
    <div class="row">
        <div class="col-7">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Sizes
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                        @forelse($sizes as $key => $size)
                            <tr>
                                <td>{{  ($sizes->total()-$loop->index)-(($sizes->currentpage()-1) * $sizes->perpage() ) }}</td>
                                <td>{{ $size->name }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        {{--  <a href="{{ route('backend.product.sizes.edit', $size->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a>  --}}
                
                                        <button type="button" id="editBtn" class="btn btn-xs btn-warning"
                                                data-id="{{$size->id}}"
                                                data-name="{{$size->name}}"
                                                title="Delete">
                                            <i class=" fa fa-edit"></i>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$size->id}})"
                                                title="Delete">
                                            <i class=" fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.product.sizes.destroy', $size->id)}}"
                                          id="deleteCheck_{{ $size->id }}" method="GET">
                                        @csrf
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">No data available in table</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    {{$sizes->links()}}
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Size
                </div>
                <div class="card-body">
                    <form action="{{route('backend.product.sizes.store')}}" method="POST" id="form">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="form-group">
                            <label for="">Name <sup class="text-danger">*</sup></label>
                            <input class="form-control" type="text" name="name" value="{{ old('name') }}" id="name">
                        </div>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-success" type="submit"><i class="fa fa-save"></i></button>
                            <button class="btn btn-sm btn-warning" type="reset" id="resetBtn"><i class="fa fa-times"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script type="text/javascript">
        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#name').val(name);
            $('#form-title').html('Edit');
        });
        $(document).on('click','#resetBtn',function(){
            $('#form-title').html('New');
            $('#model_id').remove();
        });
        function delete_check(id) {
            Swal.fire({
                title: 'Are you sure?',
                html: "<b>You will delete it permanently!</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonSize: '#3085d6',
                cancelButtonSize: '#d33',
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
