@extends('admin.layout.master')
@section('title','brand List')
@section('page-header')
    <i class="fa fa-list"></i> brand List
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
                    All Brands
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                            <tr>
                                <th>SL</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                            @forelse($brands as $key => $brand)
                                <tr>
                                    <td>{{   ($brands->total()-$loop->index)-(($brands->currentpage()-1) * $brands->perpage() )  }}</td>
                                    <td>{{ $brand->name }}</td>
                                    <td>{{ $brand->slug }}</td>
                                    <td><img src="{{ asset($brand->image) }}" alt="{{$brand->image ?? 'None'}}" class="img img-thumbnail"></td>
                                    <td>
                                        <div class="btn-group btn-group-minier btn-corner">
                                            {{-- <a href="{{ route('backend.product.brands.edit', $brand->id) }}"
                                               class="btn btn-xs btn-info"
                                               title="Edit">
                                                <i class="ace-icon fa fa-edit"></i>
                                            </a> --}}
                                            <button id="editBtn" class="btn btn-xs btn-warning" data-name="{{ $brand->name }}" data-slug="{{ $brand->slug }}" data-id="{{ $brand->id }}"><i class="fa fa-edit"></i></button>
                                            <button type="button" class="btn btn-xs btn-danger"
                                                    onclick="delete_check({{$brand->id}})"
                                                    title="Delete">
                                                <i class="ace-icon fa fa-trash"></i>
                                            </button>
                                        </div>
                                        <form action="{{ route('backend.product.brands.destroy', $brand->id)}}"
                                              id="deleteCheck_{{ $brand->id }}" method="GET">
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
                
                    {{$brands->links()}}
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    <span id="form-title">@if(old('id') > 0) Edit @else New @endif</span> brand
                </div>
                <div class="card-body">
                    <form id="form" enctype="multipart/form-data" action="{{ route('backend.product.brands.store') }}" method="POST">
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
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose Image</label>
                              </div>
                            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
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
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
          });

        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let slug = $(this).data('slug');
            $('#model_id').remove();
            let row = `<input type="hidden" id="model_id" name="id" value="`+id+`">`;
            $('#model_id').remove();
            $('#form').append(row);
            $('#name').val(name);
            $('#slug').val(slug);
            $('#form-title').html('Edit');
        });
        $(document).on('click','#resetBtn',function(){
            $('#form-title').html('New');
            $('#model_id').remove();
            $('.custom-file-label').html('Choose Image');
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
