@extends('admin.layout.master')
@section('title','Unit List')
@section('page-header')
    <i class="fa fa-list"></i> Unit List
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
        <div class="col-6">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Units
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Conversion</th>
                                <th>Action</th>
                            </tr>
                            @forelse($units as $key => $unit)
                                <tr>
                                    <td>{{($units->total()-$loop->index)-(($units->currentpage()-1) * $units->perpage())}}</td>
                                    <td>{{ $unit->name }}</td>
                                    <td>{{ $unit->conversion }}</td>
                                    <td>
                                        <div class="btn-group btn-group-minier btn-corner">
                                            {{-- <a href="{{ route('backend.product.units.edit', $unit->id) }}"
                                               class="btn btn-xs btn-info"
                                               title="Edit">
                                                <i class="ace-icon fa fa-edit"></i>
                                            </a> --}}
                                            <button id="editBtn" class="btn btn-xs btn-warning" data-name="{{ $unit->name }}" data-conversion="{{ $unit->conversion }}" data-id="{{ $unit->id }}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                    onclick="delete_check({{$unit->id}})"
                                                    title="Delete">
                                                <i class="ace-icon fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('backend.product.units.destroy', $unit->id)}}"
                                              id="deleteCheck_{{ $unit->id }}" method="GET">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">No data available in table</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                
                    {{$units->links()}}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> Unit
                </div>
                <div class="card-body">
                    <form id="form" action="{{ route('backend.product.units.store') }}" method="POST">
                        @csrf
                        @if(old('id') > 0)
                            <input type="hidden" id="model_id" name="id" value="{{ old('id') }}">
                        @endif
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Conversion</label>
                            <input type="text" class="form-control" name="conversion" id="conversion" value="{{ old('conversion') }}">
                            @error('conversion') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <button id="resetBtn" type="reset" class="btn btn-sm"><i class="fa fa-times"></i> Reset</button>
                        <button class="btn btn-sm btn-success"><i class="fa fa-save"></i> Save</button>
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
            let conversion = $(this).data('conversion');
            $('#model_id').remove();
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#name').val(name);
            $('#conversion').val(conversion);
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
