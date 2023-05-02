@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
    Flash Sale!
@endsection
@push('css')
    <link rel="stylesheet" href="{{asset('frontend/assets/css/category.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/assets/css/loadMore.css')}}">
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
                            <li>Flash Sale</li>
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
                    {{--                    <img src="{{ asset('frontend') }}/assets/img/Web Category-banners-LED-DECORATIVE.jpg" alt="">--}}
                    <img src="https://drive.google.com/uc?export=download&id=1csjpnQ9Zfe7Pa_f4yl_OLc4Z9tc8dD05" alt="">
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
                    @include('frontend.include.product-filter', ['route' => 'frontend.flash_sale'])
                </div>

                <div class="col-lg-9 col-md-12">
                <!-- @include('frontend.include.product-topbar') -->

                    @include('frontend.include.product-clear-filter', ['route' => 'frontend.flash_sale'])

                    <div class="row no-gutters shop_wrapper grid_list_4" id="product-card-holder">
                        @foreach($items as $item)
                            @include('frontend.include.product-1')
                        @endforeach
                    </div>

                    {{--                    @include('frontend.include.paginate', ['data' => $items])--}}
                    <div style="text-align: center; width: 100%">
                        <button class="button" id="load-more"><span>Load More </span></button>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@include('frontend.include.product-script')
@push('js')
    <script>
        $('#load-more').on('click', function (e) {
            let data = {
                "token": "{{ csrf_token() }}",
                "type": "flash_sale"
            }
            loadMoreProducts(data)
        })

    </script>
    @include('frontend.include.loadMoreProducts')
@endpush

