@extends('mobile.layouts.master')
@section('mobile')
    <div class="row" style="height: 161px;background-color: ghostwhite;border-bottom-left-radius: 66px;border-bottom-right-radius: 66px;">
        <div class="col-12">
            <div class="row" style="height: 71%;width: 90%;position: relative;left: 8%;top: 5%;border-radius: 17px;background-image: url('https://drive.google.com/uc?export=download&id=1csjpnQ9Zfe7Pa_f4yl_OLc4Z9tc8dD05'); background-size: cover;">

            </div>
            <div class="section-heading d-flex align-items-center justify-content-between" style="left: 14%;top: 9%;">
                {{--                @dump($seller->profile->seller_logo)--}}
{{--                <h6 class="ml-1">All Products - {{ $seller->shop_name }}</h6>--}}
                <h6 class="ml-1">All Products - Flash Sales</h6>
                <!-- Layout Options-->
                {{--                <div class="layout-options">--}}
                {{--                    <a class="active" href=""><i class="lni lni-grid-alt"></i></a><a href=""><i--}}
                {{--                            class="lni lni-radio-button"></i></a>--}}
                {{--                </div>--}}
            </div>

        </div>
    </div>

    <div class="top-products-area py-3">
        <div class="container">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6 class="ml-1">All Products</h6>
{{--                <!-- Layout Options-->--}}
{{--                <div class="layout-options">--}}
{{--                    <a class="active" href=""><i class="lni lni-grid-alt"></i></a><a href=""><i--}}
{{--                            class="lni lni-radio-button"></i></a>--}}
{{--                </div>--}}
            </div>
            @include('mobile._include.products')
        </div>
    </div>

@endsection
@push('script')
<script>

    $(window).on('scroll',loader)
    $(window).on('touchmove',loader)

    function loader(){
        if (Math.round($(window).scrollTop() + window.innerHeight) >= $(document).height()) {
            let data = {
                "_token": "{{ csrf_token() }}",
                'type': "flash_sale"
            }
            loadMoreProducts(data)
        }
    }


</script>
@include('mobile._include.loadMoreScript')
@include('mobile.includes.product-script')
@endpush

