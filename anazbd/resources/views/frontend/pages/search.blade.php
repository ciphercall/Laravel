@extends('frontend.layouts.master')
@section('active')
    style="display: none"
@endsection
@section('title')
     {{ $query }}
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
                        <li>You're Searching : {{ $query }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- catagory image -->
    {{-- <div class="shop_banner_area mb-30 pl-5 pr-5">
        <div class="row">
            <div class="col-md-12 ">
                <div class="shop_banner_thumb">
                    <img src="{{ asset('frontend') }}/assets/img/Web Category-banners-LED-DECORATIVE.jpg" alt="">
                </div>
            </div>
        </div>
    </div> --}}

{{--
    @php
        $GLOBALS['catName'] = '';
        $GLOBALS['subCatName'] = '';
        $GLOBALS['childCatName'] = '';
        $GLOBALS['brandName'] = '';
    @endphp --}}
    <div class="shop_area shop_reverse allcategory-responsive">
        <div class="container">
            <div class="row">
                {{-- <div class="col-lg-3 col-md-12 ">
                    @include('frontend.include.product-filter', ['route' => 'frontend.category', 'slug' => $category->slug,])
                </div> --}}

                <div class="col-lg-12 col-md-12">
                    @include('frontend.include.product-topbar')

                    {{-- @include('frontend.include.product-clear-filter', ['route' => 'frontend.category', 'slug' => $category->slug]) --}}
                    <div class="row no-gutters shop_wrapper grid_list_4" id="product-card-holder">
                        @foreach($items as $item)
                            @include('frontend.include.product-1')
                        @endforeach
                    </div>
                    @if($items->hasPages())
                        <div class="row">
                            <div style="text-align: center;width: 100%;padding-top: 5%;">
                                <button class="button" id="loadMore" data-last-page="{{ $items->lastPage() }}" data-cp="{{ $items->currentPage() }}" data-url="{{ url('/') }}/search?page="><span>Load More </span></button>
                            </div>
                        </div>
                    @endif
                    {{--  {{ $items->links() }}
                    @include('frontend.include.paginate', ['data' => $items])  --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).on('click','#loadMore',function (e){
            e.preventDefault();
            let currentPage = $(this).data('cp');
            console.log(currentPage)
            let lastPage = $(this).data('last-page');
            let url = $(this).data('url');
            let nextPage = parseInt(currentPage) + 1;
            if (currentPage < lastPage){
                $.ajax({
                    url: url+nextPage,
                    method: 'GET',
                    data: {
                        '_token':"{{{ csrf_token() }}}"
                    },
                    success: function (data){
                        $('#loadMore').data('cp',nextPage++);
                        var dataToAttach = "";
                        data.data.forEach(element => {

                            let priceHTML = ""
                            let saleBannerHTML = ""
                            let name = ""
                            let ratingHTML = ""
                            let firstVarient = ""
                            let color = ""
                            let size = ""
                            if (element.salePriceAttached) {
                                saleBannerHTML += "<div class='label_product'><span class='label_sale'>Sale</span></div>";
                                priceHTML = "<span class='old_price'>TK "+element.priceAttached+"</span><span class='current_price'>TK "+element.salePriceAttached+"</span>";
                            }else{
                                // priceHTML = "<span class='current_price'>TK "+element.priceAttached+"</span>";
                                priceHTML = "<span class='current_price'>TK "+element.original_price+"</span>";
                            }
                            if(element.name.length > 0){
                                name = element.name.substring(0,38)
                            }
                            if(element.rating > 0){
                                for(var i = 0; i < element.rating;i++){
                                    ratingHTML += "<li><span class='fa fa-star checked'></span></li>";
                                }
                            }
                            if(Array.isArray(element.variants) ){
                                if(element.variants[0].color_id != null){
                                    color = element.variants[0].color.name
                                }
                                if(element.variants[0].size_id != null){
                                    color = element.variants[0].size.name
                                }
                            }
                            let wishlistedClass = '';
                            if(element.isWishlisted){
                                wishlistedClass = 'fas fa-heart';
                            }else{
                                wishlistedClass = 'far fa-heart';
                            }
                            let url = "{{{ url('/') }}}"
                            dataToAttach += "<div class='col-lg-2 col-md-4 col-sm-6 col-lg-3'><article class='single_product'><div style='text-align: left; width: 100%'><a class='"+ wishlistedClass +"' style='font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;' onclick=heartChange(this,'"+String(element.slug)+"')></a></div><figure style='width: 100%;'><div class='product_thumb'><a class='primary_img' href='"+url+"/product/"+element.slug+"'><img src='"+url+'/'+element.thumb_feature_image+"'' alt="+element.name+"></a>"+saleBannerHTML+"</div><div class='product_content grid_content'><div class='product_content_inner'><h4 class='product_name'><a href='"+url+"/product/"+element.slug+"'>"+name+"</a></h4><div class='product_rating'><ul>"+ratingHTML+"</ul></div><div class='price_box'>"+priceHTML+"</div><div class='add_to_cart'><a href='#' data-item='"+element.slug+"' data-color='"+color+"' data-size='"+size+"'>Add to cart</a></div></div><div class='product_content list_content' style='width: 100%;'><h4 class='product_name'><a href='"+url+"/product/"+element.slug+"'>+name+</a></h4><div class='product_rating'><ul>+ratingHTML+</ul></div><div class='price_box'>+priceHTML+</div><div class='product_desc'><p>+element.short_description+</p></div><div class='add_to_cart'><a href='#' data-item='"+element.slug+"' data-color='"+color+"' data-size='"+size+"'>Add to cart</a></div></div></div></div></figure></article></div>"
                        });
                        $('#product-card-holder').append(dataToAttach);
                    },
                    error: function (error) {
                        console.error(error)
                    }
                });
            }else{
                console.log(currentPage,lastPage,nextPage)
            }


        })
    </script>
    @include('frontend.include.product-script')
@endpush
