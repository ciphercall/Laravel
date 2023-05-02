<link rel="stylesheet" href="{{ asset('public/assets/css/owl-anazmall.css')}}">

@if(isset($anazmall_sellers))
    <div class="categories_product_area mb-55">
        <div class="container">
            <div class="section_title" style="width: 100%">
                <h2 style="margin-left: 0">Anaz Empire</h2>
            </div>
            <div class="card-header"
                 style="background: white; display: flex; justify-content: space-between; align-items: center;width: 66%;">
                    <span class="area_name" style="font-weight: 500;">
                        <span id="demo" style="color: orange;"></span>
                    </span>
                <a href="{{route('frontend.anazmall-seller.shops')}}"
                   style="color: #ff7700; float: right; display: inline-block; border: 1px solid #ff7700; padding: 2px 10px; margin-right: 1%;">
                    SEE MORE
                </a>
            </div>

            <div class="container-fluid" style="padding: 0;">
                <div class="row">
                    <div class="col-8">
                        @foreach($anazmall_sellers->chunk(9) as $chunk1)
                            <div class="row owl-carousel2 carou_kaka" style="background-color: white;margin-left: 0%;padding: 7px 7px 7px 7px;">
                                @foreach($chunk1 as $seller)
                                    <div>
                                        <div
                                            style="background-image: url('public/assets/images/decoration-images/Wallpaper-flowers-texture-white-background-white-pattern-.png');width: 261px;height: 243px;/* border-radius: 5% 5% 5% 5%; margin: 76px;*/box-shadow: 6px 10px 15px -8px;z-index: 4;margin: 15px 14px 17px 13px;border: 1px solid lightslategrey;border-radius: 6px;">
                                            <div
                                                style="text-align: center;background-color: transparent;max-height: 52px; min-height: 30px; width: 64%;border-bottom-left-radius: 39px;border-bottom-right-radius: 39px;margin-left: 14px;box-shadow: 0px 0px 9px 0px;">
                                                <h4 style="width: 163px;">{{$seller->shop_name}}</h4>
                                            </div>
                                            <div
                                                style="height: 165px;width: 165px;/* background-color: #cb6fd7; */margin: 15px 18px 18px 8px;box-shadow: 0px 0px 9px 0px;border-radius: 5%;">
                                                <a href="{{route('frontend.seller.shop.show', $seller->slug)}}">
                                                    <img src="{{asset($seller->profile->product_image ?? '') }}" style="height: 165px;width: 165px;border-radius: 5%;">
                                                </a>
                                            </div>
                                            <div class="row" style="height: 67px;/* background-color: #6f8a3c; */z-index: -1;width: 220px;margin-left: 105px;/* border-bottom-left-radius: 14px; *//* border-bottom-right-radius: 14px; */margin-top: -133px;box-shadow: 0px -7px 13px -12px;transform: rotate(-90deg);">

                                                @forelse(collect($seller->random_items)->take(3) as $item)
                                                    <div class="col-4"
                                                         style="height: 59px;/* background-color: lightskyblue; */padding: 0;transform: rotate(90deg);margin-top: 4%;border-bottom: 1px solid;">
                                                        <a href="{{ route('frontend.product',$item->slug) }}">
                                                            <img src="{{ asset($item->feature_image) }}" style="height: 52px;width: 100%;">
                                                        </a>
                                                    </div>
                                                @empty
                                                    <div class="col-4"
                                                         style="height: 59px;/* background-color: lightskyblue; */padding: 0;transform: rotate(90deg);margin-top: 4%;border-bottom: 1px solid;">
                                                        <img
                                                            src="https://purepng.com/public/uploads/large/purepng.com-black-t-shirtclothingblack-t-shirtfashion-dress-shirt-black-cloth-tshirt-631522326884bzr0p.png"
                                                            style="height: 52px;width: 90%;left: 5px;position: absolute;">
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="col-4">
                        <div class="container-fluid" style="width: 451px;height: 549px;background-image: url('https://drive.google.com/uc?export=download&id=1uwle2xsrEIpEIt4Vg2HvS_lbs-nu6GSW');background-size: 119% 100%;background-repeat: no-repeat;border-radius: 43px;">
                            @foreach($anazmall_sellers->where('id', '60') as $seller)
                                <div class="row" style="margin-left: 0;padding: 7px 7px 7px 7px;position: relative;top: 87px;left: 24px;">
                                    <div>
                                        <div style="background-image: url('https://drive.google.com/uc?export=download&id=1QXt7vKHfBzTbPPp8OOr6gzg82MZMUxGF');width: 337px;height: 315px;/* border-radius: 5% 5% 5% 5%; margin: 76px;*/box-shadow: 6px 10px 15px -8px;z-index: 4;margin: 15px 14px 17px 13px;border: 1px solid lightslategrey;border-radius: 6px;">
                                            <div style="text-align: center;background-color: transparent;max-height: 52px;min-height: 30px;width: 92%;border-bottom-left-radius: 39px;border-bottom-right-radius: 39px;margin-left: 14px;box-shadow: 0px 0px 9px 0px;">
                                                <h4 style="/* width: 163px; */text-align: center;">{{$seller->shop_name}}</h4>
                                            </div>
                                            <div style="height: 259px;width: 318px;/* background-color: #cb6fd7; */margin: 15px 18px 18px 8px;box-shadow: 0px 0px 9px 0px;border-radius: 5%;">
                                                <a href="{{route('frontend.seller.shop.show', $seller->slug)}}">
                                                    <img src="{{asset($seller->profile->product_image ?? '') }}" style="height: 259px;width: 318px;border-radius: 5%;">
                                                </a>
                                            </div>
                                            {{--                                    <div class="row" style="height: 67px;/* background-color: #6f8a3c; */z-index: -1;width: 220px;margin-left: 105px;/* border-bottom-left-radius: 14px; *//* border-bottom-right-radius: 14px; */margin-top: -133px;box-shadow: 0px -7px 13px -12px;transform: rotate(-90deg);">--}}

                                            {{--                                        @forelse(collect($seller->random_items)->take(3) as $item)--}}
                                            {{--                                            <div class="col-4"--}}
                                            {{--                                                 style="height: 59px;/* background-color: lightskyblue; */padding: 0;transform: rotate(90deg);margin-top: 4%;border-bottom: 1px solid;">--}}
                                            {{--                                                <a href="{{ route('frontend.product',$item->slug) }}">--}}
                                            {{--                                                    <img src="{{ asset($item->feature_image) }}" style="height: 52px;width: 100%;">--}}
                                            {{--                                                </a>--}}
                                            {{--                                            </div>--}}
                                            {{--                                        @empty--}}
                                            {{--                                            <div class="col-4"--}}
                                            {{--                                                 style="height: 59px;/* background-color: lightskyblue; */padding: 0;transform: rotate(90deg);margin-top: 4%;border-bottom: 1px solid;">--}}
                                            {{--                                                <img--}}
                                            {{--                                                    src="https://purepng.com/public/uploads/large/purepng.com-black-t-shirtclothingblack-t-shirtfashion-dress-shirt-black-cloth-tshirt-631522326884bzr0p.png"--}}
                                            {{--                                                    style="height: 52px;width: 90%;left: 5px;position: absolute;">--}}
                                            {{--                                            </div>--}}
                                            {{--                                        @endforelse--}}
                                            {{--                                    </div>--}}
                                        </div>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
@push('js')
    <script>
        var owl2 = $('.carou_kaka');
        owl2.owlCarousel({
            items: 3,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });
    </script>
@endpush
