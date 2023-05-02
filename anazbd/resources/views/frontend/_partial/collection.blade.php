{{--  <style>@import url(https://fonts.googleapis.com/css?family=Open+Sans);

    body {
        background: #f2f2f2;
        font-family: 'Open Sans', sans-serif;
    }

    .search {
        width: 100%;
        position: relative;
        display: flex;
    }

    .searchTerm {
        width: 100%;
        border: 3px solid brown;
        border-right: none;
        padding: 5px;
        height: 20px;
        border-radius: 5px 0 0 5px;
        outline: none;
        color: #9DBFAF;
    }

    .searchTerm:focus {
        color: #00B4CC;
    }

    .searchButton {
        width: 40px;
        height: 36px;
        border: 1px solid brown;
        background: brown;
        text-align: center;
        color: #fff;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
        font-size: 20px;
    }

    /*Resize the wrap to see the search bar change!*/
    .wrap2 {
        width: 30%;
        position: absolute;
        /*top: 50%;*/
        left: 81%;
        transform: translate(-50%, -50%);
        padding-bottom: 1%;
    }
</style>  --}}



@if(collect($collections)->count())
    <div class="categories_product_area mb-55">
        <div class="container" style="    min-width: 1430px;
">
            <div class="section_title" style="width: 100%">
                <h2 style="margin-left: 0;">Blue Berry</h2>
                <a style="margin-left: 80%">
                    <div class="wrap2">
                        <!-- <div class="search">
                            <input type="text" class="searchTerm" placeholder="What are you looking for?"
                                   style="height: 36px;"/>
                            <button type="submit" class="searchButton">
                                <i class="fa fa-search"></i>
                            </button>
                        </div> -->
                    </div>
                </a>

            </div>
            <div class="categories_product_inner">
                <div class="card-header"
                     style="background: white; display: flex; justify-content: space-between; align-items: center;">
                    <span class="area_name" style="font-weight: 500;">
                        <span id="demo" style="color: orange;"></span>
                    </span>
                    <a href="{{route('frontend.global_collections')}}"
                       style="color: #ff7700; float: right; display: inline-block; border: 1px solid #ff7700; padding: 2px 10px; margin-right: 1%;">
                        SHOP MORE
                    </a>
                </div>
                {{--                <div class="row">--}}
                {{--                    @forelse ($collections as $col)--}}
                {{--                        --}}{{-- <a href="{{ $col->slug }}"> --}}
                {{--                        <div class="col-md-12">--}}
                {{--                            <div class="single_categories_products  collection-hover" style="padding-bottom: 10px">--}}
                {{--                                <div class="row text-center padding owl-carousel">--}}
                {{--                                    <div class="col-md-7"  style="padding-top:1rem;">--}}
                {{--                                        <a href="{{  route('frontend.collection',$col->slug) }}">--}}
                {{--                                            <div class="categories_product_thumb ">--}}
                {{--                                                <img src="{{ asset($col->cover_photo) }}"--}}
                {{--                                                     alt="{{ ($col->cover_photo) }}">--}}
                {{--                                            </div>--}}
                {{--                                        </a>--}}
                {{--                                    </div>--}}
                {{--                                    <div class="categories_product_content col-md-5" style="text-align: center;padding-top: 8%;">--}}
                {{--                                        <a href="{{ route('frontend.collection',$col->slug)  }}">--}}
                {{--                                            <h4 style="font-family: cursive;font-size: 123%;color: darkgoldenrod;">--}}
                {{--                                                {{ $col->title??' ' }}--}}
                {{--                                            </h4>--}}
                {{--                                            <p>{{ $col->items_count??' ' }} Products</p>--}}
                {{--                                        </a>--}}
                {{--                                    </div>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}
                {{--                        --}}{{-- </a> --}}

                {{--                    @empty--}}
                {{--                    @endforelse--}}
                {{--                </div>--}}

                    <div id="carou_blue" class="owl-carousel2">
                        @forelse ($collections as $col)
                        <div>
                        <a href="{{ route('frontend.collection',$col->slug)  }}">
                            <div class="container-fluid" style="
                                background-image: url(http://localhost:8080/anazbd/assets/images/decoration-images/fireworks_white.jpg);
                                background-size: cover;
                                width: 261px;
                                height: 266px;
                                box-shadow: 6px 10px 15px -8px;
                                z-index: 4;
                                margin: 15px 14px 17px 13px;
                                border: 1px solid lightslategrey;
                                ">
                                <div class="row justify-content-center">
                                    <img loading="lazy" src="{{ asset($col->cover_photo) }}" style="height: 105px;width: auto;"/>
                                </div>
                                <div class="row justify-content-center" style="height: 44pt;">
                                    <div style="position: absolute;bottom: 105px;">
                                            <h4 style="font-family: cursive;font-size: 123%;color: darkgoldenrod;width: 230px;text-align: center;">
                                                {{ $col->title??' ' }}
                                            </h4>
                                            <h5 style="text-align: center">{{ $col->items_count??' ' }} Products</h5>
                                    </div>
                                </div>
                                <div class="row justify-content-center" style="box-shadow: -7px -12px 20px -17px;position: absolute;bottom: 26px;">
                                    @forelse (collect($col->items)->take(3) as $item)
                                        <div class="col-4" style="height: 55pt;border-left: 1px solid lightgray;border-right: 1px solid lightgray;">
                                            <a href="{{ route('frontend.product',$item->slug) }}">
                                                <img loading="lazy" style="margin-top: 9px;width: 54px;height: 54px" src="{{asset($item->feature_image)}}"/>
                                            </a>

                                        </div>

                                    @empty
                                        <div class="col-4" style="height: 55pt;border-left: 1px solid lightgray;border-right: 1px solid lightgray;">
                                            <img loading="lazy" style="margin-top: 9px;width: 54px;height: 54px" src="{{asset("assets/images/decoration-images/dress_shirt_PNG8117.png")}}"/>
                                        </div>
                                        <div class="col-4" style="height: 55pt;border-left: 1px solid lightgray;border-right: 1px solid lightgray;">
                                            <img loading="lazy" style="margin-top: 9px;width: 54px;height: 54px" src="{{asset("assets/images/decoration-images/dress_shirt_PNG8117.png")}}"/>
                                        </div>
                                        <div class="col-4" style="height: 55pt;border-left: 1px solid lightgray;border-right: 1px solid lightgray;">
                                            <img loading="lazy" style="margin-top: 9px;width: 54px;height: 54px" src="{{asset("assets/images/decoration-images/dress_shirt_PNG8117.png")}}"/>
                                        </div>
                                    @endforelse

                                </div>
                            </div>
                        </a></div>
                        @empty
                        @endforelse

                    </div>

            </div>
        </div>
    </div>
@endif
@push('js')
    <script>
        var owl2 = $('#carou_blue');
        owl2.owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });
    </script>
@endpush
