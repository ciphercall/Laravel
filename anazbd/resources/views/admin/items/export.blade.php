@extends('admin.layout.master')
@section('page_header')
    <i class="fa fa-apple-alt"></i> Products
@endsection
@section('title','All Products')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-primary text-center">
                    <div class="row">
                        <div class="col-6 text-left">Filter Products</div>
                        <div class="col-6 text-right">
                            <div class="card-tool">
                            </div>
                        </div>
                    </div>
                </div>
                <form class="collapse show" id="filterForm" action="#">
                    <div class="card-body " >
                        <div class="row" >
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center ">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Name</label>
                                    <input type="text" value="{{ request()->name }}"name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Category</label>
                                    <select class="col-12 chosen-select" name="category_id" id="categoriesDropdown">
                                        <option value="">Select Option</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" @if($category->id == request()->category_id) selected="selected" @endif>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">SubCategory</label>
                                    <select class="col-12 chosen-select" name="sub_category_id" id="subcategoriesDropdown">
                                        <option value="">Select Option</option>

                                    @foreach($subcategories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">SubCategory</label>
                                    <select class="col-12 chosen-select" name="child_category_id" id="childcategoriesDropdown">
                                        <option value="">Select Option</option>

                                    @foreach($childCategories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Seller</label>
                                    <select class="col-12 chosen-select" name="seller_id" id="sellers">
                                        <option value="">Select Option</option>
                                    @foreach($sellers as $seller)
                                            <option value="{{$seller->id}}">{{$seller->shop_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Brands</label>
                                    <select class="col-12 chosen-select" name="brand_id" id="brands">
                                        <option value="">Select Option</option>
                                        @foreach($brands as $brand)
                                            <option value="{{$brand->id}}">{{$brand->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{--  <div class="row">
                            <div class="col-sm-9 col-md-4 col-lg-4 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Price Range</label>
                                    <input type="text" name="price_from" placeholder="From" class="col-6 form-control">
                                    <input type="text" name="price_to" placeholder="To" class="col-6 form-control">
                                </div>
                            </div>
                        </div>  --}}
                        <div class="col-12 text-center">
                            <button type="button" id="filterBtn" class="btn btn-sm btn-primary"><i class="material-icons">search</i></button>
                            <a href="{{ route('admin.product.item.export') }}" class="btn btn-sm btn-info"><i class="material-icons">clear</i></a>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    <div class="row justify-content-between">
                        <div class="col">
                            All Products
                        </div>
                        <div class="col text-center">
                            <button class="btn btn-sm btn-primary" id="download_btn"><i class="material-icons">file_download</i></button> 
                        </div>
                        <div class="col text-right" >
                            <button class="btn btn-sm btn-primary" type="button" data-toggle="modal" data-target="#exampleModal"><i class="material-icons">upload</i></button>
                        </div>
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col bg m-3">
                        <table class="table table-responsive datatable">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">SL</th>
                                    <th width="15%">Name</th>
                                    <th width="10%">Brand</th>
                                    <th width="10%">Category</th>
                                    <th width="10%">Sub Category</th>
                                    <th width="10%">Child Category</th>
                                    <th width="10%">Seller</th>
                                    <th width="10%">Sale</th>
                                    <th width="10%">sale Price</th>
                                    <th width="10%">Price</th>
                                    <th width="10%">Original Price</th>
                                    {{--  <th width="10%">Action</th>  --}}
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $item)
                                <tr class="text-center">
                                    <td>{{ ($items->total()-$loop->index)-(($items->currentpage()-1) * $items->perpage() ) }}</td>
                                    <td><a href="{{route('frontend.product',$item->slug)}}">{{ $item->name }}</a></td>
                                    <td>{{ $item->brand->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->sub_category->name }}</td>
                                    <td>{{ $item->child_category->name ?? '' }}</td>
                                    <td>{{ $item->seller->shop_name }}</td>
                                    <td>
                                        <span class="badge {{ $item->sale_price > 0 ? 'badge-success' : 'badge-info' }}">
                                            <i class="fa fa-{{ $item->sale_price > 0 ? 'check' : 'times' }}"></i>
                                        </span>

                                    </td>
                                    <td>{{ $item->sale_amount }} BDT</td>
                                    <td>{{ $item->price }} BDT</td>
                                    <td>{{ $item->original_price }} BDT</td>
                                    {{--  <td>

                                        @if($item->deleted_at)
                                            <form method="POST" action="{{route('admin.product.item.restore',$item->id)}}">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm btn-success" type="submit" onclick="return confirm('Are You to undo Delete ?')"><i class="material-icons">restore</i></button>
                                            </form>
                                        @else
                                            <form action="{{route('admin.product.item.status',$item)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm {{ $item->status ? 'btn-danger' : 'btn-info' }}" type="submit" onclick="return confirm('Are You Sure?')">{{ $item->status ? 'Un-Publish' : 'Publish' }}</button>
                                            </form>
                                            <form action="{{route('admin.product.item.deliveryType',$item)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button class="btn btn-sm {{ $item->is_online_pay_only ? 'btn-info' : 'btn-primary' }}" type="submit" onclick="return confirm('Are You Sure?')">{{ $item->is_online_pay_only ? 'Accept All Payment' : 'Accept Online Payment Only' }}</button>
                                            </form>
                                            <form method="POST" action="{{route('admin.product.item.destroy',$item)}}">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are You Sure to delete this item ?')"><i class="material-icons">delete</i></button>
                                            </form>
                                            <a href="{{ route($item->status ? 'backend.product.items.published.edit' : 'backend.product.items.unpublished.edit',$item->id) }}" class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                                        @endif

                                    </td>  --}}

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
        {{--  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Launch demo modal
        </button>  --}}

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Upload Bulk Product Prices</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form enctype="multipart/form-data" action="{{ route('admin.product.item.import') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        {{--  <div class="form-group">
                            <label for="">Upload File</label>
                            <input type="file" id="myfile" name="myfile"><br><br>
                            <small class="text-muted">Allowed File Type: CSV</small>
                        </div>  --}}
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            @error('file') <small class="text-danger">{{$message}}</small>@enderror
                          </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i></button>
                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                    </div>
                </form>

                </div>
            </div>
        </div>
@endsection

@push('js')
    <script>
        $(document).ready(function(){
            $('#categoriesDropdown').val('{{request()->category_id}}').trigger("chosen:updated");
            $('#subcategoriesDropdown').val('{{request()->sub_category_id}}').trigger("chosen:updated");
            $('#childcategoriesDropdown').val('{{request()->child_category_id}}').trigger("chosen:updated");
            $('#brands').val('{{request()->brand_id}}').trigger("chosen:updated");
            $('#sellers').val('{{request()->seller_id}}').trigger("chosen:updated");
            if('{{request()->category_id}}'.length > 0){
                getSubcategories('{{request()->category_id}}');
            }
            if('{{request()->sub_category_id}}'.length > 0){
                getChildcategories('{{request()->sub_category_id}}');
            }

            let showModal = "{{$errors->has('file')}}";
            if(showModal){
                $('#exampleModal').modal();
            }
        });

        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
          });

        $(document).on('click','#download_btn',function(){
            $("#filterForm").append(`
            <input type="hidden" id="download_field" name="download" value="true">
            `);
            $('#filterForm').submit();
        });

        $(document).on("click","#filterBtn",function(){
            $("#download_field").remove();
            $('#filterForm').submit();

        });

        $(document).on('change','#categoriesDropdown',function(){
            $('#childcategoriesDropdown').empty();
            $('#childcategoriesDropdown').append($('<option>', {
                    value: '',
                    text: ''
                }));
            getSubcategories(this.value);
        });

        $(document).on('change','#subcategoriesDropdown',function(){
            $('#childcategoriesDropdown').empty();
            $('#childcategoriesDropdown').append($('<option>', {
                    value: '',
                    text: ''
                }));
            getChildcategories(this.value);
        });
        function getSubcategories(id){
            $.get('{{route('backend.product.sub_categories.ajax.list', 100)}}'.replace('100', id), function (res) {
                genSubCats(res)
            });
        }
        function getChildcategories(id){
            $.get('{{route('backend.product.child_categories.ajax.list', 100)}}'.replace('100', id), function (res) {
                genChildCats(res)
            });
        }
        function genSubCats(subs) {
            if (subs instanceof Array) {
                subs.forEach(function (s) {
                    $("#subcategoriesDropdown").append($('<option>', {
                        value: s.id,
                        text: s.name
                    }));
                });
                $("#subcategoriesDropdown").val('{{request()->sub_category_id}}').trigger('chosen:updated');
            }
        }

        function genChildCats(childCats) {
            if (childCats instanceof Array) {
                childCats.forEach(function (s) {
                    $("#childcategoriesDropdown").append($('<option>', {
                        value: s.id,
                        text: s.name
                    }));
                });
                $("#childcategoriesDropdown").val('{{request()->child_category_id}}').trigger('chosen:updated');
            }
        }
    </script>
@endpush

