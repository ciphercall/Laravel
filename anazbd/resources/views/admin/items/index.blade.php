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
                <form class="collapse show" id="filterForm" action="{{route('admin.product.item.index')}}">
                    <div class="card-body " >
                        <div class="row" >
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center ">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Name</label>
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Category</label>
                                    <select class="col-12 chosen-select" name="category_id" id="">
                                        <option value="">Select Option</option>

                                    @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">SubCategory</label>
                                    <select class="col-12 chosen-select" name="sub_category_id" id="">
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
                                    <select class="col-12 chosen-select" name="child_category_id" id="">
                                        <option value="">Select Option</option>

                                    @foreach($childCategories as $category)
                                            <option value="{{$category->id}}">{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Status</label>
                                    <select class="col-12 chosen-select" name="type" id="">
                                        <option value="">Select Option</option>
                                        <option value="true">Published</option>
                                        <option value="false">Unpublished</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-2 col-lg-2 text-center">
                                <div class="row justify-content-center">
                                    <label class="col-12" for="">Seller</label>
                                    <select class="col-12 chosen-select" name="seller_id" id="">
                                        <option value="">Select Option</option>
                                    @foreach($sellers as $seller)
                                            <option value="{{$seller->id}}">{{$seller->shop_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="btn btn-sm btn-primary"><i class="material-icons">search</i></button>
                            <button type="reset" class="btn btn-sm btn-info"><i class="material-icons">clear</i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col">
            <div class="card">
                <div class="card-header-primary">
                    All Products
                </div>
                <div class="row card-body">
                    <div class="col bg m-3">
                        <table class="table table-responsive">
                            <thead>
                                <tr class="text-center">
                                    <th width="5%">SL</th>
                                    <th width="15%">Name</th>
                                    <th width="10%">Image</th>
                                    <th width="10%">Category</th>
                                    <th width="10%">Sub Category</th>
                                    <th width="10%">Child Category</th>
                                    <th width="10%">Seller</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($items as $item)
                                <tr>
                                    <td>{{ ($items->total()-$loop->index)-(($items->currentpage()-1) * $items->perpage() ) }}</td>
                                    <td><a href="{{route('frontend.product',$item->slug)}}">{{ $item->name }}</a></td>
                                    <td><img src="{{asset($item->thumb_feature_image)}}" alt="Image" class="img-thumbnail"></td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->sub_category->name }}</td>
                                    <td>{{ $item->child_category->name ?? '' }}</td>
                                    <td>{{ $item->seller->shop_name }}</td>
                                    <td>

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
                                        @can('view_product_history')
                                            <a href="{{ route('admin.product.history',$item->id) }}" class="btn btn-sm btn-warning"><i class="fa fa-history"></i></a>
                                        @endcan
                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>
@endsection

