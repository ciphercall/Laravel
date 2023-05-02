@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    {{$seller->shop_name}}
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/category.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/loadMore.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
          integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
          crossorigin="anonymous"/>
@endpush
@section('content')
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <ul>
                            <li><a href="/">home</a></li>
                            <li>{{$seller->shop_name}}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- caagory image -->
    <div class="shop_banner_area mb-30 pl-5 pr-5">
        <div class="row">
            <div class="col-md-12 ">
                <div class="shop_banner_thumb">
                    <img
                        src="{{ asset($seller->profile->product_image ?? 'frontend/assets/img/Web Category-banners-LED-DECORATIVE.jpg') }}"
                        loading="lazy" style="width: 1440px;height: 290px;" alt="">
                </div>
            </div>
        </div>
    </div>


    @php
        $GLOBALS['catName'] = '';
        $GLOBALS['subCatName'] = '';
        $GLOBALS['childCatName'] = '';
        $GLOBALS['brandName'] = '';
    @endphp
    <div class="shop_area shop_reverse allcategory-responsive">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12 ">
                    @include('frontend.include.product-filter', ['route' => 'frontend.seller.shop.show', 'slug' => $seller->slug,])
                </div>

                <div class="col-lg-9 col-md-12">
                    @include('frontend.include.product-topbar')

                    @include('frontend.include.product-clear-filter', ['route' => 'frontend.seller.shop.show', 'slug' => $seller->slug])

                    <div class="row no-gutters shop_wrapper grid_list_4" id="product-card-holder">
                        @foreach($items as $item)
                            @include('frontend.include.product-1')
                        @endforeach
                    </div>
                    <div style="text-align: center; width: 100%">
                        @if(count($items) > 0)
                            <button class="button" id="load-more"><span>Load More </span></button>
                        @endif
                    </div>
                    {{--                    @include('frontend.include.paginate', ['data' => $items])--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('#load-more').on('click', function (e) {
            let data = {
                "token": "{{ csrf_token() }}",
                'type': 'seller',
                'slug': "{{ $seller->slug  }}"
            }
            loadMoreProducts(data);
        })
    </script>
    @include('frontend.include.loadMoreProducts')
@endpush
@include('frontend.include.product-script')
