<div class="featured-products-wrapper py-3">
    <div class="">
        <div class="section-heading d-flex align-items-center justify-content-between">
            <h6 class="pl-1">Anaz Spotlight</h6><a class="btn btn-warning btn-sm" href="{{route('frontend.seller.shop.index')}}">View All</a>
        </div>
        <div class="row g-3">
{{--            <div class="flash-sale-slide owl-carousel">--}}
                <div id="carou_mob_sellers" class="owl-carousel">
                <!-- Featured Product Card-->
                @foreach ($premium_sellers as $seller)
                    <div>
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
            </div>
        </div>
    </div>
</div>
@push('js')
    <script>
        var owl2 = $('#carou_mob_sellers');
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
