@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
	wishlist
@endsection
@section('content')

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="index.html">home</a></li>
                            <li>Wishlist</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->

    <!--wishlist area start -->
    <div class="wishlist_page_bg">
        <div class="container">
            <div class="wishlist_area">
                <div class="wishlist_inner">
                    <form action="#">
                        <div class="row">
                            <div class="col-12">
                                <div class="table_desc wishlist">
                                    <div class="cart_page table-responsive">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th class="product_remove">Delete</th>
                                                    <th class="product_thumb">Image</th>
                                                    <th class="product_name">Product</th>
                                                    <th class="product-price">Price</th>
                                                    <th class="product_quantity">View</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($wishlists as $wishlist)
                                                    <tr>
                                                    <td class="product_remove">
                                                        <a href="{{ route('frontend.wishlist.destory',$wishlist->id) }}">X</a>
                                                    </td>
                                                        <td class="product_thumb"><a href="#"><img src="{{asset($wishlist->items->feature_image)  }}" alt="{{asset($wishlist->items->feature_image)  }}"></a></td>
                                                        <td class="product_name">
                                                            @if(mb_check_encoding($wishlist->items->name, 'ASCII'))
                                                                <a href="#">{{Illuminate\Support\Str::limit($wishlist->items->name, 38)}}</a>
                                                            @else
                                                                <a href="#">{{Illuminate\Support\Str::limit($wishlist->items->name, 60)}}</a>
                                                            @endif
                                                        </td>
                                                            @if($wishlist->items->sale_percentage)
                                                                <td >TK {{$wishlist->items->sale_percentage}}</td>
                                                            @else
                                                                <td >TK {{ $wishlist->items->original_price }}</td>
                                                            @endif

                                                        <td class="product_total"><a href="{{route('frontend.product',$wishlist->items->slug)}}">view Product</a></td>

                                                    </tr>

                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                               @include('frontend.include.paginate', ['data' => $wishlists])
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--wishlist area end -->
@endsection
