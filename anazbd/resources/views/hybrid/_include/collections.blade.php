@if(collect($collections)->count())
    <div class="featured-products-wrapper py-3">
        <div class="">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6 class="pl-1">Blue Berry</h6><a class="btn btn-primary btn-sm" href="{{route('frontend.global_collections')}}">View All</a>
            </div>
            <div class="row g-3">
{{--                <div class="flash-sale-slide owl-carousel">--}}
                    <div id="carou_mob_col" class="owl-carousel">
                    <!-- Featured Product Card-->
                    @forelse ($collections as $col)
                        <div>
                            <div class="card flash-sale-card">
                                <div class="card-body" style="height: 186px;width: 127px;">
                                    {{--                                  <span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>--}}
                                    <div class="product-thumbnail-side">
                                        <a class="product-thumbnail d-block" href="{{  route('frontend.collection',$col->slug) }}">
                                            <img style="height: 72px;width: 100%;position: relative;left: -7px;" src="{{ asset($col->cover_photo) }}" alt="{{ ($col->cover_photo) }}">
                                        </a>
                                    </div>
                                    <div class="product-description" style="text-align: center;padding-top: 14px;">
                                        <a style="position: relative; left: -7px;font-size: 10px;" class="product-title d-block" href="{{ route('frontend.collection',$col->slug)  }}">{{ $col->title??' ' }}</a>
{{--                                        <div class="row"><p style="margin-bottom: 0;" class="sale-price">{{ $col->items_count??' ' }}</p></div>--}}

                                        <div class="row">
                                            <div class="col-12">
                                                <div style="text-align: center;height: 29px;width: 29px;border: 2px solid black;border-radius: 50%;background-color: orangered;color: white;position: relative;left: 25px;">
                                                    <a>
                                                        {{ $col->items_count??' ' }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row"><p class="sale-price" style="font-size: 12px;position: relative;left: -10px;">Products</p></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endif
@push('js')
    <script>
        var owl2 = $('#carou_mob_col');
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
