@extends('admin.layout.master')
@section('title','Colors List')
@section('page-header')
    <i class="fa fa-list"></i> Color List
@stop
@section('content')
    <div class="row">
        <div class="col-7">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Colors
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Color Value</th>
                            {{-- <th class="bg-dark" style="width: 25%">Image</th> --}}
                            <th>Action</th>
                        </tr>
                        @forelse($colors as $key => $color)
                            <tr>
                                <td>{{  ($colors->total()-$loop->index)-(($colors->currentpage()-1) * $colors->perpage() ) }}</td>
                                <td>{{ $color->name }}</td>
                                <td>{{ $color->value }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        {{--  <a href="{{ route('backend.product.colors.edit', $color->id) }}"
                                           class="btn btn-xs btn-info"
                                           title="Edit">
                                            <i class="ace-icon fa fa-edit"></i>
                                        </a>  --}}
                                        <button id="editBtn" class="btn btn-xs btn-warning" data-id="{{ $color->id }}" data-name="{{ $color->name }}" data-value="{{ $color->value }}"><i class="fa fa-edit"></i></button>
                
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$color->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.product.colors.destroy', $color->id)}}"
                                          id="deleteCheck_{{ $color->id }}" method="GET">
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
                    {{ $colors->links() }}
                </div>
            </div>
        </div>
        <div class="col-5">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0)Edit @else New @endif</span> Color
                </div>
                <div class="card-body">
                    <form id="form" role="form" method="post" class="form-horizontal" enctype="multipart/form-data" action="{{route('backend.product.colors.store')}}">
                        @csrf
                        @if(old('id') > 0)
                            <input id="model_id" type="hidden" name="id" value="{{ old('id') }}">
                        @endif
                        <!-- Name -->
                            <div class="form-group">
                                <label class="" for="name">Color Name <sup class="red">*</sup></label>
                                <input type="text" id="name" name="name" placeholder="Color name" class="form-control" required="" value="{{old('name')}}">
                                <strong class="red">{{ $errors->first('name') }}</strong>
                            </div>
                            {{-- value of color --}}
                            <div class="form-group">
                                <label for="name">Color Value <sup class="red">*</sup></label>
                               <input type="color" name="value" value="{{ old('value') }}" id="value">
                                <strong class="red">{{ $errors->first('value') }}</strong>
                            </div>

                            <!-- Buttons -->
                            <div class="form-group">
                                <button class="btn btn-sm btn-success submit create-button">
                                    <i class="fa fa-save"></i> Add
                                </button>

                                <button type="reset" id="resetBtn" class="btn btn-sm"><i class="fa fa-times"></i> Clear</button>
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
            let value = $(this).data('value');
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#name').val(name);
            $('#value').val(value);
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
