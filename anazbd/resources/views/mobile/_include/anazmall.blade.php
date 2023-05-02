@if(isset($anazmall_sellers))
    <div class="featured-products-wrapper py-3" style="width: 202px;height: 341px;">
        <div class="row">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6 class="pl-1">Anaz Empire</h6><a class="btn btn-info btn-sm"
                                                    href="{{route('frontend.anazmall-seller.shops')}}">View All</a>
            </div>

            @foreach ($anazmall_sellers->chunk((($anazmall_sellers->count())/2)+1) as $chunk1)
                <div class="row g-3" style="margin-top: -10px;">
                    {{--              <div class="flash-sale-slide owl-carousel2" id="carou_mob_empire">--}}
                    <div class="owl-carousel carou_mob_empire">
                        <!-- Featured Product Card-->
                        @foreach ($chunk1 as $seller)
                            <div>
                                <div class="card flash-sale-card">
                                    <div class="card-body" style="height: 131px;width: 109px;">
                                        {{--                                  <span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>--}}
                                        <div class="product-thumbnail-side">
                                            <a class="product-thumbnail d-block"
                                               href="{{route('frontend.seller.shop.show', $seller->slug)}}">
                                                {{-- @dump($seller->profile->product_image) --}}
                                                <img style="height: 78px;width: auto;position: relative;left: -8px;"
                                                     src="{{asset($seller->profile->product_image ?? 'https://drive.google.com/uc?export=download&id=1XaDf3lLjAOZKcp6F2MPBACJPDbPb7EGS')}}"
                                                     alt="{{ ($seller->profile->product_image ?? ' ')}}">
                                            </a>
                                        </div>
                                        <div class="product-description" style="text-align: center">
                                            <a class="product-title d-block"
                                               style="position: relative;left: -8px;font-size: 12px;"
                                               href="{{route('frontend.seller.shop.show', $seller->slug)}}">{{$seller->shop_name??' '}}</a>
                                            <p class="sale-price">{{ $seller->slogan ?? ' ' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            @foreach($anazmall_sellers->where('id', '60') as $seller)
                <div class="row g-3"
                     style="margin-top: -10px;width: 149px;height: 272px;position: relative;left: 215px;top: -262px;background-image: url('https://drive.google.com/uc?export=download&id=1K3Puou5PY3_mE0rais_DjpXQ6Hx9npQJ');background-size: 300% 100%;background-repeat: no-repeat;border-radius: 15px;">
                    {{-- <div class="flash-sale-slide owl-carousel2" id="carou_mob_empire"> --}}
                    <div class="">
                        <!-- Featured Product Card-->
                        <div>
                            <div class="card flash-sale-card"
                                 style="width: 98px;position: relative;left: 18px;top: 57px;">
                                <div class="card-body" style="height: 131px;width: 109px;">
                                    {{--                                  <span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>--}}
                                    <div class="product-thumbnail-side">
                                        <a id="prod_thumb" class="product-thumbnail d-block"
                                           href="{{route('frontend.seller.shop.show', $seller->slug)}}">
                                            {{--                                        @dump($seller->profile->product_image)--}}
                                            <img style="height: 78px;width: auto;position: relative;left: -8px;"
                                                 src="{{asset($seller->profile->product_image ?? 'https://drive.google.com/uc?export=download&id=1XaDf3lLjAOZKcp6F2MPBACJPDbPb7EGS')}}"
                                                 alt="{{ ($seller->profile->product_image ?? ' ')}}">
                                        </a>
                                    </div>
                                    <div class="product-description" style="text-align: center">
                                        <a id="prod_title" class="product-title d-block"
                                           style="position: relative;left: -8px;font-size: 12px;"
                                           href="{{route('frontend.seller.shop.show', $seller->slug)}}">{{$seller->shop_name??' '}}</a>
                                        {{--                                        <p class="sale-price">{{ $seller->slogan ?? ' ' }}</p>--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach




            {{--          <div class="row g-3">--}}
            {{--              <div class="flash-sale-slide owl-carousel2" id="carou_mob_empire">--}}
            {{--                  <div class="owl-carousel" id="carou_mob_empire">--}}
            {{--                  <!-- Featured Product Card-->--}}
            {{--                  @foreach ($anazmall_sellers as $seller)--}}
            {{--                      <div>--}}
            {{--                          <div class="card flash-sale-card">--}}
            {{--                              <div class="card-body" style="height: 131px;width: 109px;">--}}
            {{--                                  --}}{{--                                  <span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>--}}
            {{--                                  <div class="product-thumbnail-side">--}}
            {{--                                      <a class="product-thumbnail d-block" href="{{route('frontend.seller.shop.show', $seller->slug)}}">--}}
            {{--                                          --}}{{--                                        @dump($seller->profile->product_image)--}}
            {{--                                          <img style="height: 78px;width: auto;position: relative;left: -8px;" src="{{asset($seller->profile->product_image ?? 'https://drive.google.com/uc?export=download&id=1XaDf3lLjAOZKcp6F2MPBACJPDbPb7EGS')}}" alt="{{ ($seller->profile->product_image ?? ' ')}}">--}}
            {{--                                      </a>--}}
            {{--                                  </div>--}}
            {{--                                  <div class="product-description" style="text-align: center">--}}
            {{--                                      <a class="product-title d-block" style="position: relative;left: -8px;font-size: 12px;" href="{{route('frontend.seller.shop.show', $seller->slug)}}">{{$seller->shop_name??' '}}</a>--}}
            {{--                                      <p class="sale-price">{{ $seller->slogan ?? ' ' }}</p>--}}
            {{--                                  </div>--}}
            {{--                              </div>--}}
            {{--                          </div>--}}
            {{--                      </div>--}}
            {{--                  @endforeach--}}
            {{--              </div>--}}
            {{--          </div>--}}
        </div>
    </div>
@endif
@push('js')
    <script>
        var owl2 = $('.carou_mob_empire');
        owl2.owlCarousel({
            items: 2,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });


        $(document).ready(function () {
            $.get('{{route("frontend.home.empireajax")}}'
            ).done(
                function (res) {

                    setInterval(function (){
                        for (var i = 0; i < res.length; i++) {
                            var arrayIdx = Math.floor(res.length * Math.random());

                            var slug = res[arrayIdx].slug;
                            var prod_image = res[arrayIdx].profile.product_image;
                            var shop_name = res[arrayIdx].shop_name;
                            // var slogan = res[arrayIdx].slogan;

                            // console.log("slug: " + slug + "product_image: " + prod_image + " shop_name: " + shop_name + " slogan: " + slogan);
                            // console.log(res[arrayIdx]);
                            $('#prod_thumb').prop('href', "{{url('/shops')}}/" + slug);

                            if (prod_image !== null || undefined) {
                                $('#prod_thumb img').prop('src', "{{asset('/')}}" + prod_image);
                            } else {
                                $('#prod_thumb img').prop('src', 'https://drive.google.com/uc?export=download&id=1XaDf3lLjAOZKcp6F2MPBACJPDbPb7EGS');
                            }

                            if (shop_name !== null || undefined) {
                                $('#prod_title').prop('href', "{{url('/shops')}}/" + slug).html(shop_name);
                            }
                            break;
                        }
                    },10*1000);
                }
            ).fail(
                function (xhr, status, error) {
                    console.log('hi');
                });

        });
    </script>
@endpush
