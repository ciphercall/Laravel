@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    {{$item->name}}
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>
    <style>
        .inner-content {
            margin: 25px 0;
        }

        .inner-content input[type="radio"] {
            display: none;
        }

        .inner-content i {
            color: #dddddd;
            font-size: 36px;
            cursor: pointer;
        }

        .inner-content input[type="radio"]:checked ~ label i {
            color: #FFD700;
        }

        .inner-content {
            direction: rtl;
            width: 100%;
        }

        .inner-content h3 {
            margin: 0 0 15px 0;
            font-size: 24px;
        }

        .popover {
            max-width: 50%;
            min-width: 400px;
        }
    </style>
@endpush
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="{{ url('/') }}">home</a></li>
                            <li>{{$item->name}} </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--breadcrumbs area end-->
    <div class="product_page_bg">
        <div class="container">
            <div class="product_details_wrapper mb-55">
                <!--product details start-->
                <div class="product_details">
                    <div class="row">
                        <div class=" col-md-4">
                            <div class="product-details-tab">
                                <div id="img-1" class="zoomWrapper single-zoom">
                                    <a href="#" class="zoom-img">
                                        <img style="max-width: 100%;height: auto;"
                                             src="{{ asset($item->feature_image) }}"
                                             data-zoom-image="{{ asset($item->feature_image) }}"/>
                                    </a>
                                </div>
                                <hr>
                                <div class="single-zoom-thumb">

                                    <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                        @foreach($item->other_images as $image)
                                            @if($image->path_resized)
                                                <li>
                                                    <a href="#"
                                                       class="elevatezoom-gallery active"
                                                       {{--                                               data-image="{{asset($image->path_resized)}}" --}}
                                                       data-zoom-image="{{asset($image->path)}}">
                                                        <img src="{{asset($image->path_resized)}}" width="45"
                                                             height="30"/>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                        @foreach($item->variants    as $variant)
                                            @if($variant->image_resized)
                                                <li>
                                                    <a href="#" class="elevatezoom-gallery active"
                                                       {{--                                                   data-image="{{asset($variant->image_resized)}}" --}}
                                                       data-zoom-image="{{asset($variant->image)}}">
                                                        <img src="{{asset($variant->image_resized)}}" width="45"
                                                             height="30"/>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="product_d_right">
                                <br>
                                @php
                                    $variant_colors = collect($item->variants)->groupBy('color_id');
                                @endphp
                                <form id="buy-now-form" action="{{route('frontend.checkout.buy-now')}}" method="post">
                                    @csrf
                                    <h3><a href="#">{{$item->name}}</a><br>
                                        @if($item->is_online_pay_only)
                                            <small style="font-size: 10pt;" class="text-muted">This Item supports online payment only.</small>
                                        @endif</h3>
                                    <div class="product_rating">
                                        <ul>
                                            <li><a href="#"><i class="ion-android-star"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                            <li><a href="#"><i class="ion-android-star-outline"></i></a></li>
                                        </ul>
                                        <ul>
                                            <li>Brand: <a href="#">{{$item->brand->name}}</a></li>&nbsp;|&nbsp;
                                            <li>Wishlist:
                                                <a href="#" id="wish-list">
                                                    <i class="fa fa-heart" aria-hidden="true"></i>
                                                </a>
                                            </li>
                                            {{--                                        &nbsp;|&nbsp;<li><a href="#">More Men from SS WORLD</a></li>--}}
                                        </ul>
                                    </div>
                                    <hr>
                                    <div class="pdp-product-price">
                                        @foreach($item->variants as $variant)

                                            <span
                                                id="price-{{az_hash($variant->id)}}"
                                                class="pdp-price pdp-price_type_normal pdp-price_color_orange pdp-price_size_xl"
                                                style="display: {{$loop->index == 0 ? 'block': 'none'}}">
                                                @if($variant->sale_percentage)
                                                    <span style="text-decoration: line-through; color: gray;">
                                                        ৳ {{ $variant->price + $item->getPriceAdditionAttribute($variant)  }}
                                                    </span>
                                                    <span>&emsp;৳ {{ $variant->sale_price }}</span>
                                                    <span class="pdp-product-price__discount" style="color: orange">
                                                        &emsp;-{{$variant->sale_percentage}}%
                                                    </span>
                                                @else
                                                    <span>৳ {{ $variant->price + $item->getPriceAdditionAttribute($variant) }}</span>
                                                @endif
                                        </span>
                                        @endforeach
                                    </div>

                                    <hr>
                                    <!-- COLOR SELECTS -->
                                    @if($variant_colors->keys()[0] != '')
                                        <div class="section-content">
                                            <div class="sku-prop-content">
                                                <span class="sku-tabpath-single"
                                                      data-spm-anchor-id="a2a0e.pdp.0.i5.ca2112503oCXp7"> Color &nbsp; &nbsp;</span>
                                                @foreach($variant_colors as $color)
                                                    <span class="sku-variable-size"
                                                          title="{{optional($color->first()->color)->name}}"
                                                          style="border: none; padding: 0; display: inline;">
                                                        <a href="#"
                                                           class="elevatezoom-gallery active color"
                                                           {{--data-image="{{asset($variant->image_resized)}}" --}}
                                                           data-vid="{{az_hash($color->first()->id)}}"
                                                           data-size-div="size-{{optional($color->first()->color)->name}}"
                                                           data-price-div="price-{{az_hash($color->first()->id)}}"
                                                           data-zoom-image="{{asset($color->first()->image)}}"
                                                           style="display:inline-block; border: 2px solid {{$loop->index ? 'transparent' : '#f78e50'}};">
                                                            <img src="{{asset($color->first()->image_resized)}}"
                                                                 width="45" height="30"/>
                                                        </a>
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                <!-- SIZE SELECTS -->
                                    @foreach($variant_colors as $color)
                                        @if(collect($color)->where('size_id', '!=', null)->count() > 0)
                                            <div class="section-content size"
                                                 id="size-{{optional($color->first()->color)->name}}"
                                                 style="display: {{$loop->index == 0 ? 'block' : 'none'}}">
                                                <div class="sku-prop-content">
                                                    <span class="sku-tabpath-single"
                                                          data-spm-anchor-id="a2a0e.pdp.0.i5.ca2112503oCXp7"> Size &nbsp; &nbsp; &nbsp;</span>
                                                    @foreach($color as $variant)
                                                        <span class="sku-variable-size size"
                                                              title="{{optional($variant->size)->name}}"
                                                              data-vid="{{az_hash($variant->id)}}"
                                                              data-price-div="price-{{az_hash($variant->id)}}"
                                                              data-spm-anchor-id="a2a0e.pdp.0.i2.ca2112503oCXp7"
                                                              style="border: 2px solid {{$loop->index ? 'transparent' : '#f78e50'}};">
                                                {{optional($variant->size)->name ?? '-'}}
                                                </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    <br>
                                    <br>

                                    <div class="product_variant quantity">
                                        <label for="qty">quantity</label>
                                        <input id="qty" name="qty" min="1" max="{{ $item->max_orderable_qty }}"
                                               value="1" type="number">

                                    </div>

                                    <input type="hidden" name="item" value="{{az_hash($item->id)}}">
                                    <input type="hidden" name="seller" value="{{az_hash($item->seller_id)}}">
                                    <input type="hidden" id="variant" name="variant"
                                           value="{{az_hash(collect($item->variants)->first()->id)}}">
                                    <input type="hidden" name="buy_now" value="1">

                                    <div class="product_variant quantity">
                                        <button id="buy-now" class="button" type="button"
                                                style="background: #f57224 !important;">
                                            Buy Now
                                        </button>
                                        <button id="add-cart" class="button pull-right" type="button">
                                            Add to Cart
                                        </button>
                                    </div>
                                </form>
                                <div class="priduct_social" style="margin-left: 4%;">
                                    <ul>
                                        <li><a class="facebook" href="#" title="facebook"><i
                                                    class="fab fa-facebook-square"></i>
                                                Like</a></li>
                                        <li><a class="twitter" href="#" title="twitter"><i
                                                    class="fab fa-twitter-square"></i>
                                                tweet</a></li>
                                        <li><a class="pinterest" href="#" title="pinterest"><i
                                                    class="fab fa-pinterest-square"></i> save</a></li>
                                        <li><a class="google-plus" href="#" title="google +"><i
                                                    class="fab fa-google-plus-square"></i> share</a></li>
                                        <li><a class="linkedin" href="#" title="linkedin"><i
                                                    class="fab fa-linkedin-square"></i>
                                                linked</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <div class="col-md-3" style="background: #fafafa">
                            <div class="card-deck" style="width: 20rem;">
                                <div class="card-body">
                                    <h5 class="card-subtitle mb-2 text-muted">
                                        Delivery Option
                                        <a href="#" id="delv_opt" class="delivary-card-link" style="margin-left: 51%;"
                                           role="button" data-toggle="popover" data-trigger="focus"
                                           title="<h3>Delivery Option</h3>"
                                           data-placement="left">
                                            <i class="fa fa-info-circle" aria-hidden="true">
                                            </i>
                                        </a>
                                    </h5>
                                    <div style="display:flex;">
                                        <img src="{{ asset('frontend') }}/assets/img/icon-2/location.png"
                                             style="width: 20px; height: 20px;">
                                        <div style="display: inline; width: 70%" class="card-text-of-area">&nbsp;
                                            &nbsp; {{$location}}</div>
                                    </div>
                                    {{--                                    <div class="delivary-card-change">--}}
                                    {{--                                        <a href="#" style="color: #1DA1F2">CHANGE</a>--}}
                                    {{--                                    </div>--}}
                                </div>
                            </div>
                            <hr>
                            <div class="card-deck" style="width: 20rem;">
                                <div class="card-body">
                                    <h5 class="card-subtitle"><img
                                            src="{{ asset('frontend') }}/assets/img/icon-2/delivery.png"
                                            style="width: 20px; height: 20px">&nbsp; &nbsp; Home Delivery</h5>
                                    <p class="card-subtitle mb-2 text-muted">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 9-15
                                        days <i class="delivary-product-price">&#2547; {{round($delivery_charge)}}</i>
                                    </p>
                                    <h5 class="card-subtitle"><i class="fa fa-money fa-lg" aria-hidden="true"></i>&nbsp;
                                        &nbsp; Cash on Delivery Available</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="card-deck" style="width: 20rem;">
                                <div class="card-body">
                                    <p class="card-subtitle mb-2 text-muted">
                                        Return & Delivery
                                        <a href="#" id="ret_delv" class="delivary-card-link" style="margin-left: 46%;"
                                           role="button" data-toggle="popover" data-trigger="focus"
                                           title="<h3>Return and Warrantee</h3>"
                                           data-placement="left">
                                            <i class="fa fa-info-circle" aria-hidden="true">
                                            </i>
                                        </a>
                                    </p>
                                    <h5 class="card-subtitle"><img
                                            src="{{ asset('frontend') }}/assets/img/icon-2/return.png"
                                            style="width: 20px; height: 20px">&nbsp; &nbsp; 7 Day Returns</h5>
                                    <p class="card-subtitle mb-2 text-muted">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Change
                                        of mind available,, </p>
                                    <p></p>
                                    <h5 class="card-subtitle"><img
                                            src="{{ asset('frontend') }}/assets/img/icon-2/warrenty-icon.png"
                                            style="width: 20px; height: 20px">&nbsp;
                                        &nbsp; {{$item->warranty_type->name ?? 'Warranty not available'}}
                                        @if($item->warranty_period)
                                            &nbsp;({{$item->warranty_period}})
                                        @endif
                                    </h5>
                                </div>
                            </div>
                            <hr>
                            <div class="container">
                                <div class="row" style="width: 330px;">
                                    <table class="table" style="border: 1px solid #fafa; margin-left: -15px;">
                                        <tr>
                                            <td colspan="3">
                                                <i style="font-size: 10px;">Sold By</i>
                                                <p>{{$item->seller->shop_name}}</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="1" style="border: 1px solid #0101; height: 110px;">
                                                <p class="table-font-size">Positive Seller Ratings</p>
                                                <div>
                                                    <p>81%</p>
                                                </div>
                                            </td>
                                            <td colspan="1" style="border: 1px solid #2021; width: 110px;">
                                                <p class="table-font-size">Ship on Time</p>
                                                <br>
                                                <div><p>99%</p></div>
                                            </td>
                                            {{--  <td colspan="1"  style="border: 1px solid #f1f1; width: 110px;">
                                                 <p class="table-font-size">Chat Response Rate</p>
                                                 <div><p>96%</p></div>
                                             </td> --}}
                                        </tr>
                                        <tr>
                                            <td colspan="3" style="text-align: center; color: darkcyan">
                                                <a href="{{route('frontend.seller.shop.show', $item->seller->slug)}}">Go
                                                    To Store</a>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!--product info start-->
                <div class="product_d_info">
                    <div class="row">
                        <div class="col-12">

                            <div class="product_d_inner">
                                <div class="product_info_button">
                                    <ul class="nav" role="tablist">
                                        <li>
                                            <a class="active" data-toggle="tab" href="#info" role="tab"
                                               aria-controls="info" aria-selected="false">Product details
                                                of {{$item->name}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="info" role="tabpanel">
                                        <div class="product_info_content">
                                            <p>{!! $item->highlights !!}</p>
                                            <p>{!! $item->description !!}</p>
                                            @if($item->is_online_pay_only)
                                                 <small class="text-muted">This Item supports online payment only.</small>
                                            @endif</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="product_d_inner">
                                <div class="product_info_button">
                                    <ul class="nav" role="tablist">
                                        <li>
                                            <a class="active" data-toggle="tab" href="#info" role="tab"
                                               aria-controls="info" aria-selected="false">Ratings & Reviews
                                                of {{$item->name}}</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="info" role="tabpanel">

                                        @auth
                                            <div class="product_rating mb-10">
                                                <form action="{{ route('frontend.comment',$item->slug) }}"
                                                      method="Post">
                                                    @csrf
                                                    <h4>Your rating</h4>
                                                    <div class="inner-content">
                                                        <h5>Star Rating</h5>
                                                        <input type="radio" value="5" name="rating" id="star6"
                                                               checked><label for="star6"><i
                                                                class="fa fa-star"></i></label>
                                                        <input type="radio" value="4" name="rating" id="star7"><label
                                                            for="star7"><i class="fa fa-star"></i></label>
                                                        <input type="radio" value="3" name="rating" id="star8"><label
                                                            for="star8"><i class="fa fa-star"></i></label>
                                                        <input type="radio" value="2" name="rating" id="star9"><label
                                                            for="star9"><i class="fa fa-star"></i></label>
                                                        <input type="radio" value="1" name="rating" id="star10"><label
                                                            for="star10"><i class="fa fa-star"></i></label>
                                                    </div>
                                                    <strong style="color: red">{{ $errors->first('rating') }}</strong>
                                                    <div class="product_review_form">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <label for="review_comment">Your review </label>
                                                                <textarea name="review" id="review_comment"
                                                                          required></textarea>
                                                            </div>
                                                            <strong
                                                                style="color: red">{{ $errors->first('review') }}</strong>
                                                        </div>
                                                        <button type="submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        @else
                                            <h4>Write Your Review? Login First.</h4>
                                        @endauth
                                        @if($item->comments)
                                            <h4> {{ $item->comments->count() ?? ' ' }} Review for
                                                : {{ $item->name }}</h4>
                                                @foreach ($comments as $comment)
                                                <div class="reviews_comment_box">
                                                    <div class="comment_thmb"></div>
                                                    <div class="comment_text" style="margin-left: 0">
                                                        <div class="reviews_meta">
                                                            <div class="product_rating">
                                                                <ul>
                                                                    {{--  @for ($i = 1; $i <= $comments->count(); $i++)  --}}
                                                                        <li>
                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                <i class="fa fa-star @if($i <= $comment->rating) text-warning @else text-muted @endif"></i>
                                                                            @endfor
                                                                        </li>
                                                                    {{--  @endfor  --}}
                                                                </ul>
                                                            </div>
                                                            <p>
                                                                <strong>{{ $comment->user->name }} </strong>- {{  $comment->created_at->format('d-M-Y') }}
                                                            </p>
                                                            <span>{{ $comment->review }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--product info end-->
            </div>
            <div class="product_details_wrapper mb-55">
                <div class="product_d_inner mt-4">
                    <div class="product_info_button">
                        <ul class="nav" role="tablist">
                            <li>
                                <a class="active" data-toggle="tab" href="#info" role="tab"
                                   aria-controls="info" aria-selected="false">Questions about this product
                                    ({{ $item->questions->count() }})</a>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="info" role="tabpanel">

                            @auth
                                <div class="product_rating mb-10">
                                    <form action="{{ route('frontend.question.store',$item->slug) }}" method="Post">
                                        @csrf
                                        <h4>Your Question</h4>

                                        <div class="product_review_form">
                                            <div class="row">
                                                <div class="col-12">
                                                    <textarea name="question" id="question_box" required></textarea>
                                                </div>
                                                <strong style="color: red">{{ $errors->first('review') }}</strong>
                                            </div>
                                            <button type="submit">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <h4>
                                    <button class="btn btn-sm"
                                            onclick="return window.location.href = `{{ url('/login') }}`">
                                        Login to ask a question
                                    </button>
                                </h4>
                            @endauth
                            @if($item->questions)
                                <h4>Questions for : {{ $item->name }}</h4>
                                @if($questionsByUser != null)
                                    <hr>
                                    @foreach ($questionsByUser as $question)
                                        <div class="reviews_comment_box">
                                            <div class="comment_thmb"></div>
                                            <div class="comment_text" style="margin-left: 0">
                                                <p>
                                                    <strong>{{ $question->user->name }} </strong>- {{  $question->created_at->format('d-M-Y') }}
                                                    <span class="text-danger"></span></p>
                                                <span>{{ $question->question }}</span>
                                            </div>
                                        </div>
                        </div>
                        @endforeach
                        <hr>
                        @endif

                        @foreach ($item->questions as $question)
                            <div class="reviews_comment_box">
                                <div class="comment_thmb"></div>
                                <div class="comment_text" style="margin-left: 0">
                                    <p>
                                        <strong>{{ $question->user->name }} </strong>- {{  $question->created_at->format('d-M-Y') }}
                                    </p>
                                    <span>{{ $question->question }}</span>
                                </div>
                            </div>
                    </div>
                    @if($question->answer)
                        <div class="reviews_comment_box ml-5">
                            <div class="comment_thmb"></div>
                            <div class="comment_text" style="margin-right: 0">
                                <p><strong>Replied By
                                        Seller </strong>- {{  Carbon\Carbon::parse($question->answer->created_at)->diffForhumans($question->created_at) }}
                                </p>
                                <span>{{ $question->answer->answer }}</span>
                            </div>
                        </div>
                </div>
                @endif
                @endforeach
                @endif
            </div>
        </div>
    </div>


    <!--product area start-->
    <section class="product_area related_products">
        <div class="row">
            <div class="col-12">
                <div class="section_title">
                    <h2>Related Products </h2>
                </div>
            </div>
        </div>
        @if($related_items)
            <div class="row">
                @foreach($related_items as $product)
                    <div class="col-lg-2 col-md-4 col-sm-6 no-padding-margin">
                        <article class="single_product">
                            <div style="text-align: left; width: 100%">
                                <a class="far fa-heart"
                                   style="font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;"
                                   onclick="heartChange(this,{{ $product->id }})"></a>
                            </div>
                            <figure style="width: 100%;">
                                <div class="product_thumb">
                                    <a class="primary_img"
                                       href="{{route('frontend.product', $product->slug)}}"><img
                                            src="{{asset($product->thumb_feature_image)}}"
                                            alt="{{$product->name}}"
                                            style='display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'></a>

                                    @if($product->sale_price)
                                        <div class="label_product">
                                            <span class="label_sale">Sale</span>
                                        </div>
                                    @endif
                                </div>

                                <div class="product_content grid_content">
                                    <div class="product_content_inner">
                                        <h4 class="product_name">
                                            <a href="{{route('frontend.product', $product->slug)}}">
                                                {{--                                                    @if(mb_check_encoding($item->name, 'ASCII'))--}}
                                                {{--                                                        {{Illuminate\Support\Str::limit($item->name, 38)}}--}}
                                                {{--                                                    @else--}}
                                                {{--                                                        {{Illuminate\Support\Str::limit($item->name, 60)}}--}}
                                                {{--                                                    @endif--}}
                                                @if(mb_check_encoding($product->name, 'ASCII'))
                                                    {{Illuminate\Support\Str::limit($product->name, 15)}}
                                                @else
                                                    {{Illuminate\Support\Str::limit($product->name, 15)}}
                                                @endif
                                            </a>
                                        </h4>
                                        <div class="product_rating">
                                            <ul>
                                                @php $rating = $product->rating @endphp
                                                @foreach(range(2,6) as $i)
                                                    @if($rating > 0)
                                                        <li>
                                                            <span class="fa fa-star checked"></span>
                                                        </li>
                                                    @endif
                                                    @php $rating-- @endphp
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            @if($product->sale_price)
                                                <span class="old_price">TK {{$product->original_price}}</span>
                                                <span class="current_price">TK {{$product->sale_price}}</span>
                                            @else
                                                <span class="current_price">TK {{$product->original_price}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="add_to_cart">
                                        @php
                                            $v = collect($product->variants)->first()
                                        @endphp
                                        <a href="#"
                                           data-item="{{$product->slug}}"
                                           data-color="{{$v->color->name ?? ''}}"
                                           data-size="{{$v->size->name ?? ''}}">
                                            Add to cart
                                        </a>
                                    </div>
                                </div>
                                <div class="product_content list_content" style="width: 100%;">
                                    <h4 class="product_name">
                                        <a href="{{route('frontend.product', $product->slug)}}">{{$product->name}}</a>
                                    </h4>
                                    <div class="product_rating">
                                        <ul>
                                            @php $rating = $product->rating @endphp
                                            @foreach(range(2,6) as $i)
                                                @if($rating > 0)
                                                    <li>
                                                        <span class="fa fa-star checked"></span>
                                                    </li>
                                                @endif
                                                @php $rating-- @endphp
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="price_box">
                                        @if($product->sale_price)
                                            <span class="old_price">TK {{$product->original_price}}</span>
                                            <span class="current_price">TK {{$product->sale_price}}</span>
                                        @else
                                            <span class="current_price">TK {{$product->original_price}}</span>
                                        @endif
                                    </div>
                                    <div class="product_desc">
                                        <p>{{$product->short_description}}</p>
                                    </div>
                                    <div class="add_to_cart">
                                        <a href="#"
                                           data-item="{{$product->slug}}"
                                           data-color="{{$v->color->name ?? ''}}"
                                           data-size="{{$v->size->name ?? ''}}">
                                            Add to cart
                                        </a>
                                    </div>
                                </div>
                            </figure>
                        </article>
                    </div>
                @endforeach
            </div>
        @endif

    </section>
    <!--product area end-->


    <div id="demo"></div>
@endsection

@push('js')
    @include('frontend.include.product-script')
    <script src="{{ asset('frontend/jquery.elevateZoom-3.0.8.min.js') }}"></script>
    <script src="{{asset('assets/js/jquery-ui.min.js')}}"></script>

    <script>


        $(document).ready(function () {

                getShortDesc();

                let deliveryOpt = document.getElementById('delv_opt');
                deliveryOpt.dataset.content =
                    '<div class="container-fluid"><div class="row"><div class="" style="width:60px;height:auto;"><img src="{{ asset('frontend') }}/assets/img/icon-2/delivery.png" style="width:50px;height:50px"></div><div class="col"><div class="row"><h4>Home Delivery is Available.</h4></div><div class="row"><p>It takes usually 9 to 15 days to arrive.</p></div></div></div><br/><div class="row"><div class="" style="font-size:28px;width:60px;height:auto;"><i class="fa fa-money fa-lg" aria-hidden="true"></i></div><div class="col"><div class="row"><h4>Cash on Delivery is Available</h4></div></div></div></div>';

                let return_delv = document.getElementById('ret_delv');
                return_delv.dataset.content =
                    '<div class="container-fluid"><div class="row"><div class="" style="width:60px;height:auto;"><img src="{{ asset('frontend') }}/assets/img/icon-2/return.png" style="width:50px;height:50px"></div><div class="col"><div class="row"><h4>7 Days return is available.</h4></div><div class="row"><p>An exclusive 7 days money back return is available for any product.<br> For Anaz exclusive product it is 14 days.</p></div></div></div><br/><div class="row"><div class="" style="width:60px;height:auto;"><img src="{{ asset('frontend') }}/assets/img/icon-2/warrenty-icon.png" style="width:50px;height:50px"></div><div class="col"><div class="row"><h4>Warrantee is not Available</h4></div></div></div></div>';

                // $("#ret_delv").on('click', function () {
                //     getShortDesc();
                // });

                function getShortDesc() {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.get('{{ url('/getShortDesc/') }}'+'/' + 'refund-policy',
                        function (res) {
                            console.log(res);
                            // return_delv.dataset.content = res.short_desc;
                            $.get('{{ url('/getShortDesc/') }}'+'/' + 'warranty-policy',
                                function (res2) {
                                    console.log(res2);
                                    return_delv.dataset.content = res.short_desc.substring(0,300) +"... "+"<a href='{{url("quick-page/refund-policy")}}' style='color:red;' >SEE MORE</a>"+"<br><br>"+ res2.short_desc.substring(0,300)+"... "+"<a href='{{url("quick-page/warranty-policy")}}' style='color:red;' >SEE MORE</a>";
                                });
                        });

                }
        }
        );
        $('#delv_opt, #ret_delv').popover({
            trigger: 'focus',
            template: '<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>',
            html: true
        });
        @php
            $v1 = collect($item->variants)->first();
        @endphp

        const item = '{{ $item->slug }}';
        let color = '{{optional($v1->color)->name ?? ""}}';
        let size = '{{optional($v1->size)->name ?? ""}}';
        let limit = '{{ $item->max_orderable_qty ?? 5 }}';
        let variant = '{{ az_hash($item->variants->first()->id) }}'

        // image click
        $('a.elevatezoom-gallery').on('click', function (e) {
            e.preventDefault();
            $('#img-1 img').attr('src', $(this).data('zoom-image'));
        });

        const colorSelect = $('a.color');
        const sizeSelect = $('.sku-variable-size.size');

        // color click
        colorSelect.on('click', function (e) {
            e.preventDefault();
            resetColorSelects();
            resetSizeSelects();

            $('#img-1 img').attr('src', $(this).data('zoom-image'));
            $('.section-content.size').css("display", "none");
            const sizeDiv = $("#" + $(this).data('size-div').toString().trim());
            sizeDiv.css('display', 'block');
            $('#variant').val($(this).data('vid').toString().trim());
            const firstSize = sizeDiv.find('.sku-variable-size.size').eq(0);
            firstSize.css('border', '2px solid #f78e50');
            $('.pdp-price').css('display', 'none');
            $("#" + $(this).data('price-div').toString().trim()).css('display', 'block');
            $(this).css('border', '2px solid #f78e50');
            color = $(this).parent().attr('title').toString().trim();
            size = firstSize.attr('title').toString().trim();
            variant = $(this).data('vid').toString().trim();

        });

        // size click
        sizeSelect.on('click', function (e) {
            e.preventDefault();
            resetSizeSelects();
            variant = $(this).data('vid').toString().trim();
            $('#variant').val($(this).data('vid').toString().trim());
            $('.pdp-price').css('display', 'none');
            $("#" + $(this).data('price-div').toString().trim()).css('display', 'block');
            $(this).css('border', '2px solid #f78e50');
            size = $(this).attr('title').toString().trim();
        });

        // iframe
        const buyNow = $('#buy-now');
        const addCart = $('#add-cart');

        buyNow.on('click', function () {
            if ({{auth('web')->id() ?? 'false'}}) {
                submitBuyNow();
            } else {
                window.location.href = "{{ url('/login') }}"
                    return false;
            }
        });

        function submitBuyNow() {
            if (Number(limit) >= Number(qty)) {
                $('#buy-now-form').submit();
            }
        }

        addCart.on('click', function () {
            if ({{auth('web')->id() ?? 'false'}}) {
                updateCart();
            } else {
                window.location.href = "{{ url('/login') }}"
                return false;
            }
        });

        function updateCart(shouldReload = false) {
            let qty = $('#qty').val().toString().trim();
            if (Number(limit) >= Number(qty) && Number(qty) > 0) {
                $.post('{{route('frontend.cart.store.ajax')}}',
                    {
                        item: item,
                        color: color,
                        size: size,
                        qty: qty,
                        variant: variant
                    },
                    function (res) {
                        if (res.status) {
                            swal({
                                icon: "success",
                                buttons: false,
                                timer: 1000
                              });
                            $('.cart_count').text(res.count);
                        } else {
                            swal({
                                buttons: false,
                                timer: 2000,
                                icon: 'error',
                                title: 'Failed.',
                                text: res.msg,
                            });
                        }
                    });
            } else {
                swal({
                    buttons: false,
                    timer: 2000,
                    icon: 'error',
                    title: 'Failed.',
                    text: "Minimum Order Quantity is 1 and Maximum Valid quantity is " + limit,

                });
            }

        }

        //wishlist
        const wishlist = $('#wish-list');

        wishlist.on('click', function () {
            if ({{ auth('web')->id()??'false' }}) {
                wishList();
            } else {
                window.location.href = "{{ url('/login') }}"
                    return false;
            }
        });

        function wishList(shouldReload = false) {
            let itemId = {{ $item->id }};
            let url = '{{ route("store.wishlist", ":id") }}'.replace(':id', itemId);
            $.get(url,
                function (wish) {
                    if (wish.status) {
                        $('.ui-dialog-content').dialog('close');
                        $('.wishlist_count').text(wish.wishcount);

                        new Noty({
                            theme: 'metroui',
                            timeout: 3000,
                            type: 'success',
                            layout: 'topRight',
                            text: 'Product added to wishlist successfully!'
                        }).show();

                        if (shouldReload)
                            window.location.reload(shouldReload);

                    } else {
                        new Noty({
                            theme: 'metroui',
                            timeout: 3000,
                            type: 'success',
                            layout: 'topRight',
                            text: 'Product is already in wishlist!'
                        }).show();
                    }
                });
        }

        function iframeDialog(url, shouldReload = false) {
            const iframe = $(`<iframe src="${url}"
                                      frameborder="0"
                                      style="width:100%;height:100%;">
                              </iframe>`);

            const root = $("<div></div>");
            root.append(iframe).dialog({
                autoOpen: true,
                width: 810,
                height: 550,
                modal: true,
                create: function (e, ui) {
                    $("body").css({overflow: 'hidden'});
                },
                beforeClose: function (e, ui) {
                    $("body").css({overflow: 'inherit'})
                }
            });

            const closeDialog = $('<a href="#" class="fa fa-times" style="position: absolute; top: 10px; right: 20px; font-size: 18px"></a>');
            closeDialog.on('click', function (e) {
                e.preventDefault();
                $('.ui-dialog-content').dialog('close');
                if (shouldReload)
                    window.location.reload(true);
            });
            root.append(closeDialog)

            const iframeBody = $('body', iframe[0].contentDocument);
            iframeBody.html('<div style="width: 100%; height: 100%; background: white"></div>');

            $('.ui-dialog-titlebar').hide();
            $('.ui-widget-content').css('border', 'none');
        }

        // resets
        function resetColorSelects() {
            colorSelect.each(function () {
                $(this).css('border', '2px solid transparent');
            })
        }

        function resetSizeSelects() {
            sizeSelect.each(function () {
                $(this).css('border', '2px solid transparent');
            })
        }

        var id =  {{ $item->id }};
        var url = "{{ route('frontend.commentall', ":id") }}";
        url = url.replace(':id', id);

        //commnet section
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function (data) {
                console.log(data);
            }
            // console.log(data);
            // container.html('');
            // $.each(data, function(index, item) {
            // container.html(''); //clears container for new data
            // $.each(data, function(i, item) {
            //     container.append('<div class="row"><div class="ten columns"><div class="editbuttoncont"><button class="btntimestampnameedit" data-seek="' + item.timestamp_time + '">' +  new Date(item.timestamp_time * 1000).toUTCString().match(/(\d\d:\d\d:\d\d)/)[0] +' - '+ item.timestamp_name +'</button></div></div> <div class="one columns"><form action="'+ item.timestamp_id +'/deletetimestamp" method="POST">' + '{!! csrf_field() !!}' +'<input type="hidden" name="_method" value="DELETE"><button class="btntimestampdelete"><i aria-hidden="true" class="fa fa-trash buttonicon"></i></button></form></div></div>');
            // });
            //         container.append('<br>');
            //     });
            // },error:function(){
            //     console.log(data);
            // }
        });

    </script>
@endpush
