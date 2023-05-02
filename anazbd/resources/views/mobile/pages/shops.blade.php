@extends('mobile.layouts.master')
@section('mobile')
    <!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/product-grid.css').'?v='.(config()->get('version'))}}">

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Float four columns side by side */
        .column {
            float: left;
            width: 139px;
            height: 139px;
            /* padding: 0 10px; */
            padding-left: 1px;
            padding-right: 1px;
            margin-bottom: 18px;
        }

        /* Remove extra left and right margins, due to padding */
        .row {
            margin: 0 -5px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /*!* Responsive columns *!*/
        /*@media screen and (max-width: 389px) {*/
        /*    .column {*/
        /*        width: 100%;*/
        /*        display: block;*/
        /*        margin-bottom: 4px;*/
        /*    }*/
        /*}*/

        /*@media screen and (max-width: 800px) and (min-width: 390px) {*/
        /*    .column {*/
        /*        width: 50%;*/
        /*        display: block;*/
        /*        margin-bottom: 4px;*/
        /*    }*/
        /*}*/

        /*@media screen and (max-width: 800px) and (min-width: 541px) {*/
        /*    .column {*/
        /*        width: 33%;*/
        /*        display: block;*/
        /*        margin-bottom: 4px;*/
        /*    }*/
        /*}*/


        /*@media screen and (min-width: 759px) {*/
        /*    .column {*/
        /*        width: 25%;*/
        /*        display: block;*/
        /*        margin-bottom: 4px;*/
        /*    }*/
        /*}*/

        /* Style the counter cards */
        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            /*padding: 16px;*/
            text-align: center;
        }

        a.card {
            margin: 0 !important;
            min-width: 99px;
            /* max-width: 205px; */
            min-height: 99px;
            /* max-height: 350px; */
            display: inline-block;
            transition: all 0s;
            border-radius: 5px;
            align-self: start;
        }

        /*a.card .card-img-top {*/
        /*    max-width: 86px !important;*/
        /*    max-height: 194px !important;*/
        /*    min-height: 100px !important;*/
        /*}*/
        a.card .card-img-top {
            max-width: 203px !important;
            max-height: 203px !important;
            min-height: 10px !important;}
    </style>
</head>
<body>
{{--@if(isset($sellers))--}}
{{--    <div class="row" style="--bs-gutter-y: 15px;">--}}
{{--        @foreach($sellers->chunk(6) as $chunk)--}}
{{--            @foreach($chunk as $seller)--}}
{{--                <div class="column">--}}
{{--                    <a href="{{route('frontend.seller.shop.show', $seller->slug)}}" class="card">--}}
{{--                        <div class="card-img-overlay"></div>--}}
{{--                        <img class="card-img-top"--}}
{{--                             src="{{asset($seller->profile->product_image ?? '') }}"--}}
{{--                             alt="">--}}
{{--                        <div class="card-img-on-top">--}}
{{--                            <img style="max-width: 25px;" class="card-image-anaz-mall"--}}
{{--                                 src="{{asset($seller->profile->logo ?? '')}}"--}}
{{--                                 alt="Card image cap">--}}
{{--                        </div>--}}
{{--                        <div class="card-body">--}}
{{--                            <div style="font-size: 12px;" class="card-title-h1">{{$seller->shop_name}}</div>--}}
{{--                            <p class="card-content-p">{{$seller->slogan ?? ''}}</p>--}}
{{--                        </div>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            @endforeach--}}
{{--        @endforeach--}}
{{--        @endif--}}

@if(isset($sellers_mobile))
    <div class="row" style="--bs-gutter-y: 8px;--bs-gutter-x: 6px;">
        @foreach($sellers_mobile as $seller)

{{--                <div class="col-4">--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12" style="text-align: center;">--}}
{{--                            <a href="{{route('frontend.seller.shop.show', $seller->slug)}}" class="card">--}}
{{--                                --}}{{--                        <div class="card-img-overlay"></div>--}}
{{--                                --}}{{--                        <div class="card-img-on-top">--}}
{{--                                --}}{{--                            <img style="" class="card-image-anaz-mall"--}}
{{--                                --}}{{--                                 src="{{asset($seller->profile->logo ?? '')}}"--}}
{{--                                --}}{{--                                 alt="Card image cap">--}}
{{--                                --}}{{--                        </div>--}}
{{--                                                        <img style="width: 97px;height: 97px;" class="card-img-top"--}}
{{--                                                             src="{{asset($seller->profile->product_image ?? '') }}"--}}
{{--                                                             alt="">--}}
{{--                                                    </a>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="row">--}}
{{--                        <div class="col-12">--}}
{{--                            <div class="card-body" style="padding: 7px 1px 1px 1px;">--}}
{{--                                <div style="font-size: 12px;text-align: center;" class="card-title-h1">{{$seller->shop_name}}</div>--}}
{{--                                <p class="card-content-p">{{$seller->slogan ?? ''}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}



                <div class="col-4">
                    <div class="card flash-sale-card">
                        <div class="card-body" style="height: 159px;width: 127px;">
                            {{--                                  <span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>--}}
                            <div class="product-thumbnail-side">
                                <a class="product-thumbnail d-block" href="{{route('frontend.seller.shop.show', $seller->slug)}}">
                                    {{--                                        @dump($seller->profile->product_image)--}}
                                    <img style="height: 99px;width: auto;position: relative; left: -8px;" src="{{asset($seller->profile->product_image ?? 'https://drive.google.com/uc?export=download&id=1XaDf3lLjAOZKcp6F2MPBACJPDbPb7EGS')}}" alt="{{ ($seller->profile->product_image ?? ' ')}}">
                                </a>
                            </div>
                            <div class="product-description" style="text-align: center">
                                <a class="product-title d-block" style="position: relative;left: -8px;font-size: 12px;" href="{{route('frontend.seller.shop.show', $seller->slug)}}">{{$seller->shop_name??' '}}</a>
                                <p class="sale-price">{{ $seller->slogan ?? ' ' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

    @endforeach
@endif
</body>
</html>
@endsection
