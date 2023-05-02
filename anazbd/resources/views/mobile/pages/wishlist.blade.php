@extends('mobile.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins.css')}}">

    <!-- Main Style CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style2.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/themes/metroui.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/lib/noty/noty.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css')}}">

@endpush
@section('mobile')

    {{--    <!--breadcrumbs area start-->--}}
    {{--    <div class="breadcrumbs_area">--}}
    {{--        <div class="container">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-12">--}}
    {{--                    <div class="breadcrumb_content">--}}
    {{--                        <ul>--}}
    {{--                            <li><a href="index.html">home</a></li>--}}
    {{--                            <li>Wishlist</li>--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--    <!--breadcrumbs area end-->--}}

    <!--wishlist area start -->
    <div class="wishlist_page_bg">
        <div class="container">
            <div class="row"><h4>Wishlist</h4></div>

            <div class="wishlist_area">
                <div class="wishlist_inner">
                    <form action="#">
                        <div class="row">
                            <div class="col-12">
                                @foreach ($wishlists as $wishlist)
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="product_thumb"><a href="#"><img
                                                        style="height: 73px;width: auto;"
                                                        src="{{asset($wishlist->items->feature_image)  }}"
                                                        alt="{{asset($wishlist->items->feature_image)  }}"></a></div>
                                        </div>
                                        <div class="col-9">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="product_name">
                                                        @if(mb_check_encoding($wishlist->items->name, 'ASCII'))
                                                            <a href="{{route('frontend.product',$wishlist->items->slug)}}"><h4>{{Illuminate\Support\Str::limit($wishlist->items->name, 38)}}</h4></a>
                                                        @else
                                                            <a href="{{route('frontend.product',$wishlist->items->slug)}}"><h4>{{Illuminate\Support\Str::limit($wishlist->items->name, 60)}}</h4></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    @if($wishlist->items->sale_percentage)
                                                        <div>TK {{ $wishlist->items->sale_price }}</div>
                                                    @else
                                                        <div>TK {{ $wishlist->items->original_price }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12" style="text-align: right;">
                                                    <a href="{{ route('frontend.wishlist.destory',$wishlist->id) }}"><i class="fas fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!--wishlist area end -->
@endsection
