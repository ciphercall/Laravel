@if(isset($premium_sellers))
    <div class="categories_product_area mb-55 overflow-auto">
        <div class="container" style="    min-width: 1430px;
">
            <div class="section_title" style="width: 100%">
                <h2 style="margin-left: 0">Anaz Spotlight</h2>
            </div>
            <div class="card-header"
                 style="background: white; display: flex; justify-content: space-between; align-items: center;">
                    <span class="area_name" style="font-weight: 500;">
                        <span id="demo" style="color: orange;"></span>
                    </span>
                <a href="{{route('frontend.seller.shop.index')}}"
                   style="color: #ff7700; float: right; display: inline-block; border: 1px solid #ff7700; padding: 2px 10px; margin-right: 1%;">
                    SEE MORE
                </a>
            </div>
{{--            <div class="card-deck owl-carousel" style="background-color: white;margin-left: 0%;padding-top: 1%;">--}}
{{--                @foreach($premium_sellers as $seller)--}}
{{--                    <div>--}}
{{--                        <a href="{{route('frontend.seller.shop.show', $seller->slug)}}" class="card">--}}
{{--                            <div class="card-img-overlay"></div>--}}
{{--                            <img loading="lazy" class="card-img-top"--}}
{{--                                 src="{{asset($seller->profile->product_image ?? '') }}"--}}
{{--                                 alt="">--}}
{{--                            <div class="card-img-on-top">--}}
{{--                                <img loading="lazy" class="card-image-anaz-mall"--}}
{{--                                     src="{{asset($seller->profile->logo ?? '')}}"--}}
{{--                                     alt="Card image cap">--}}
{{--                            </div>--}}
{{--                            <div class="card-body">--}}
{{--                                <div class="card-title-h1">{{$seller->shop_name}}</div>--}}
{{--                                <p class="card-content-p">{{$seller->slogan ?? ''}}</p>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    </div>--}}

{{--                @endforeach--}}
{{--            </div>--}}

            {{--            new design--}}
            <div id="carou_spt" class="card-deck owl-carousel" style="background-color: white;margin-left: 0%;padding-top: 1%;">
                @foreach($premium_sellers as $seller)
                <div style="background-image: url('public/assets/images/decoration-images/black-linen.png');width: 200px;height: 304px;/* border-radius: 5% 5% 0% 0%; *//* margin: 74px; */box-shadow: 2px 3px 16px -8px;z-index: 4;margin-bottom: 17px;margin-top: 11px;">
                    <div
                        style="/* background-image: url('wave-textures-white-background-vector_53876-60286.jpg'); */text-align: center;background-color: rgba(240,255,240,0.5); min-height: 25px; max-height: 41px;width: 86%;border-bottom-left-radius: 39px;border-bottom-right-radius: 39px;margin-left: 14px;box-shadow: 0px 0px 9px 1px;top: 2px;position: relative;">
                        <h4 style="top: 0px;position: relative;width: 170px;">{{$seller->shop_name}}</h4>
                    </div>
                    <div
                        style="background-image: url('wave-textures-white-background-vector_53876-60286.jpg');
                         height: 165px;
                         width: 165px;
                         /* background-color: #cb6fd7; */
                         margin: 18px;box-shadow: 0px 0px 9px 0px;
                         border-radius: 5%;">

                        <a href="{{route('frontend.seller.shop.show', $seller->slug)}}">
                            <img loading="lazy" src="{{asset($seller->profile->product_image ?? '') }}"
                                 style="height: 165px;
                                 width: 165px;
                                 /* background-color: rgba(255,255,255,1); */
                                 border-radius:5%;">
                        </a>
                    </div>
                    <div class="row" style="height: 71px;background-color: rgba(255,255,255,0.4);z-index: 0;width: 200px;margin-left: 0px;/* border-bottom-left-radius: 14px; *//* border-bottom-right-radius: 14px; *//* margin-top: -10px; */box-shadow: -1px -3px 20px -17px;position: absolute;bottom: 21px;">
                         @forelse(collect($seller->random_items)->take(3) as $item)
                            <div class="col-4"
                                style="height: 52px;padding: 0;margin-top: 9px;border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;">
                                <a href="{{ route('frontend.product',$item->slug) }}">
                                    <img loading="lazy"

                                    src="{{ asset($item->feature_image) }}"
                                    style="height: 52px;width: 100%;">
                                </a>
                            </div>
                        @empty
                            <div class="col-4"
                                 style="height: 52px;/* background-color: lightskyblue; */padding: 0;margin-top: 9px;border-left: 1px solid grey;border-right: 1px solid grey;">
                                <img loading="lazy"
                                    src="https://purepng.com/public/uploads/large/purepng.com-black-t-shirtclothingblack-t-shirtfashion-dress-shirt-black-cloth-tshirt-631522326884bzr0p.png"
                                    style="height: 52px;width: 100%;">
                            </div>

                        @endforelse

                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>
@endif
@push('js')
    <script>
        var owl2 = $('#carou_spt');
        owl2.owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });
    </script>
@endpush
