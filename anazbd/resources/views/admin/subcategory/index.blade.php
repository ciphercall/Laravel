@extends('admin.layout.master')
@section('title','Sub Category List')
@section('page-header')
    <i class="fa fa-list"></i> Sub Category List
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
        <div class="col-8">
            <div class="card rounded shadow">
                <div class="card-header-primary">
                    All Sub Categories
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Image</th>
                            <th>VAT</th>
                            <th>Commission</th>
                            <th>Delivery Charge</th>
                            <th>Action</th>
                        </tr>
                        @forelse($categories as $key => $item)
                            <tr>
                                <td>{{ ($categories->total()-$loop->index)-(($categories->currentpage()-1) * $categories->perpage()) }}</td>
                                <td>{{ $item->name }}<br><small class="text-muted">{{ $item->category->name }}</small></td>
                                <td>{{ $item->slug }}</td>
                                <td>
                                    <img src="{{ asset($item->cover_photo) }}"
                                        class="img img-thumbnail"
                                        height="30"
                                        width="120"
                                        alt="No Image">
                                </td>
                                <td>{{ $item->vat }}</td>
                                <td>{{ $item->commission }}</td>
                                <td>{{ $item->delivery_charge }}</td>
                                <td>
                                    <div class="btn-group btn-group-mini btn-corner">
                                        <!-- <a href="{{ route('backend.product.origins.edit', $item->id) }}"
                                        class="btn btn-xs btn-info"
                                        title="Edit">
                                            <i class="ace-icon fa fa-pencil"></i>
                                        </a> -->
                                        <button 
                                            data-id="{{ $item->id }}"
                                            data-name="{{ $item->name }}"
                                            data-category_id="{{$item->category_id}}"
                                            data-vat="{{$item->vat}}"
                                            data-commission="{{$item->commission}}"
                                            data-delivery_charge="{{$item->delivery_charge}}"
                                            class="btn btn-xs btn-warning" id="editBtn"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-xs btn-danger"
                                                onclick="delete_check({{$item->id}})"
                                                title="Delete">
                                            <i class="ace-icon fa fa-trash"></i>
                                        </button>
                                    </div>
                                    <form action="{{ route('backend.product.sub_categories.destroy', $item->id)}}"
                                        id="deleteCheck_{{ $item->id }}" method="GET">
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
                    {{$categories->links()}}
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-header-primary">
                    <span id="form_title">@if(old('id') > 0) Edit @else New @endif</span> Category
                </div>
                <div class="card-body">
                    <form action="{{ route('backend.product.sub_categories.store') }}" enctype="multipart/form-data" id="form" method="POST">
                        @csrf
                        @if(old('id') > 0) <input type="hidden" name="id" id="role_id" value="{{ old('id') }}"> @endif
                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" id="name">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Category</label><br>
                            <select name="category_id" id="category_id" class="col-12 chosen-select">
                                @foreach ($parentCats as $item)
                                    <option value="{{ $item->id }}">{{$item->name}}</option>
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="">Vat</label>
                            <input type="text" name="vat" class="form-control" value="{{ old('vat') }}" id="vat">
                            @error('vat') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Commission</label>
                            <input type="text" name="commission" class="form-control" value="{{ old('commission') }}" id="commission">
                            @error('commission') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="form-group">
                            <label for="">Delivery Charge</label>
                            <input type="text" name="delivery_charge" class="form-control" value="{{ old('delivery_charge') }}" id="delivery_charge">
                            @error('delivery_charge') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="">Image</label>
                                <div class="custom-file">
                                    <input name="image" accept="image/*" type="file" data-type="1" id="customFile">
                                </div>
                                @error('image') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        
                        <hr>
                        <div class="col text-right">
                            <button class="btn btn-sm btn-warning" type="button" id="reset_btn"><i class="fa fa-times"></i></button>
                            <button class="btn btn-sm btn-success"><i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        {{--  $(document).on("change",'#customFile', function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings("#custom-file-label-"+$(this).data('type')).addClass("selected").html(fileName);
        });  --}}

        $(document).on('click','#editBtn',function(){
            let id = $(this).data('id');
            let name = $(this).data('name');
            let parentCat = $(this).data('category_id');
            let vat = $(this).data('vat');
            let commission = $(this).data('commission');
            let deliveryCharge = $(this).data('delivery_charge');

            $('#form').append(
                `<input type="hidden" name="id" id="role_id" value='`+id+`'>`
            );
            $("#form_title").html("Edit");

            $('#name').val(name);
            $('#vat').val(vat);
            $('#commission').val(commission);
            $('#delivery_charge').val(deliveryCharge);
            $('#category_id').val(parentCat).trigger("chosen:updated")
        });

        $(document).on('click','#reset_btn',function(){
            $('#role_id').remove();
            $('#name').val('');
            $('#vat').val('');
            $('#commission').val('');
            $('#delivery_charge').val('');
            $('#category_id').val([]).trigger("chosen:updated")
            $('.custom-file-label').html('Choose Image');
            $("#form_title").html("New");
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
