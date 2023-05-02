<div class="product-catagories-wrapper py-3">
    <div class="">
        <div class="product-catagory-wrap">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6 class="pl-1">Categories</h6><a class="btn btn-warning btn-sm" href="{{route('categories.show')}}">View All</a>
            </div>

        {{--              <!-- Single Catagory Card-->--}}
        {{--              --}}{{--           @dd(collect($categories))--}}
        {{--              @foreach(collect($categories)->take(8) as $category)--}}
        {{--                  <div class="col-3" style="padding-right: 0">--}}
        {{--                      <div class="card catagory-card">--}}
        {{--                          <div class="card-body">--}}
        {{--                              <a href="{{route('frontend.category', $category->slug)}}">--}}
        {{--                                  <img src="{{ asset($category->image)}}" alt="{{ ($category->image) }}" style="height: 40px; width:40px">--}}
        {{--                              </a>--}}
        {{--                          </div>--}}
        {{--                      </div>--}}
        {{--                      <span style="font-size: 12px;color:black">{{ Str::limit( $category->name, 12) }}</span>--}}
        {{--                  </div>--}}
        {{--              @endforeach--}}



        <!-- Single Catagory Card-->
            {{--           @dd(collect($categories))--}}
            <div class="container" style="border-radius: 10px;">
                <div class="row">
                    @foreach(collect($categories)->take(8) as $category)
{{--                        <div class="col-3" style="padding-right: 0; padding-left: 0">--}}
{{--                            <div class="card catagory-card" style="border-radius: 0; padding-bottom: 8px;">--}}
{{--                                <div class="card-body">--}}
{{--                                    <a href="{{route('frontend.category', $category->slug)}}">--}}
{{--                                        <img src="{{ asset($category->image)}}" alt="{{ ($category->image) }}"--}}
{{--                                             style="height: 50px; width:50px">--}}
{{--                                    </a>--}}
{{--                                </div>--}}
{{--                                <span style="font-size: 12px;color:black">{{ Str::limit( $category->name, 12) }}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-3" style="padding-right: 0; padding-left: 0">
                            <div class="card catagory-card" style="padding-bottom: 8px;border-radius: 11px;margin: 2px;box-shadow: 3px 4px 3px 0px #d7def4;">
                                <div class="card-body">
                                    <a href="{{route('frontend.category', $category->slug)}}">
                                        <img src="{{ asset($category->image)}}" alt="{{ ($category->image) }}"
                                             style="height: 50px; width:50px">
                                    </a>
                                </div>
                                <span style="font-size: 12px;color:black">{{ Str::limit( $category->name, 10) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>


            {{--              <div class="flash-sale-slide owl-carousel">--}}
            {{--                  <!-- Featured Product Card-->--}}
            {{--                  @foreach(collect($categories) as $category)--}}
            {{--                      <div>--}}
            {{--                          <div class="card flash-sale-card">--}}
            {{--                              <div class="card-body">--}}
            {{--                                  --}}{{--                                  <span class="badge badge-warning custom-badge"><i class="lni lni-star"></i></span>--}}
            {{--                                  <div class="product-thumbnail-side">--}}
            {{--                                      <a class="product-thumbnail d-block" href="{{route('frontend.category', $category->slug)}}">--}}
            {{--                                          <img src="{{ asset($category->image)}}" alt="{{ ($category->image) }}" style="height: 40px; width:40px">--}}
            {{--                                      </a>--}}
            {{--                                  </div>--}}
            {{--                                  <div class="product-description" style="text-align: center">--}}
            {{--                                      <a class="product-title d-block" href="">{{ Str::limit( $category->name, 12) }}</a>--}}
            {{--                                      <p class="sale-price">{{ $seller->slogan ?? ' ' }}</p>--}}
            {{--                                  </div>--}}
            {{--                              </div>--}}
            {{--                          </div>--}}
            {{--                      </div>--}}
            {{--                  @endforeach--}}
            {{--              </div>--}}
        </div>
    </div>
</div>
