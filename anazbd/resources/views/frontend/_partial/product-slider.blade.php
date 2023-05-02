

@if($items != null && $items->count() > 0)
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="categories_product_area" style="margin-left: 0;">
                        <div class="section_title" style="width: 100%">
                            <h2 style="margin: 0">{{ $title }}</h2>
                        </div>
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--  ==========just for you======-->
            <div class="" >
                <div class="card-deck owl-carousel" id="product-card-holder2" style="grid-gap: 0px;">
                    @foreach($items as $item)
                        <div class="col m-0 p-0">
                            <article class="single_product">
                                @php
                                    $count = ($item->variants[0]->qty);
                                @endphp
                                <div style="text-align: left;width: 100%;position: relative;z-index: 1;"><a
                                        class="{{ $item->isWishlisted ? 'fas fa-heart' : 'far fa-heart' }}"
                                        style="font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;"
                                        onclick="heartChange(this,'{{ $item->slug }}')"></a>
                                </div>
                                <figure style="width: 100%;">
                                    <div class="product_thumb">
                                        <a class="primary_img"
                                           href="{{route('frontend.product', $item->slug)}}"><img loading="lazy"
                                                                                                  src="{{asset($item->thumb_feature_image)}}"
                                                                                                  alt="{{$item->name}}"
                                                                                                  style='display: block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'></a>

                                        @if($item->sale_price)
                                            <div class="label_product">
                                                <span class="label_sale">Sale</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="product_content grid_content">
                                        <div class="product_content_inner">
                                            <h4 class="product_name" style="min-height: 37.33px;">
                                                <a href="{{route('frontend.product', $item->slug)}}">
                                                    {{--                                                    @if(mb_check_encoding($item->name, 'ASCII'))--}}
                                                    {{--                                                        {{Illuminate\Support\Str::limit($item->name, 38)}}--}}
                                                    {{--                                                    @else--}}
                                                    {{--                                                        {{Illuminate\Support\Str::limit($item->name, 60)}}--}}
                                                    {{--                                                    @endif--}}
                                                    @if(mb_check_encoding($item->name, 'ASCII'))
                                                        {{Illuminate\Support\Str::limit($item->name, 15)}}
                                                    @else
                                                        {{Illuminate\Support\Str::limit($item->name, 15)}}
                                                    @endif
                                                </a>
                                            </h4>
                                            <div class="product_rating">
                                                <ul>
                                                    @php $rating = $item->rating @endphp
                                                    @foreach(range(2,6) as $i)
                                                        @if($rating > 0)
                                                            <li>
                                                                <span class="fa fa-star checked"></span>
                                                            </li>
                                                        @endif
                                                        @php $rating-- @endphp
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="price_box">
                                                @if($item->sale_price)
                                                    <span class="old_price">TK {{$item->original_price}}</span>
                                                    <span class="current_price">TK {{$item->sale_price}}</span>
                                                @else
                                                    <span class="current_price">TK {{$item->original_price}}</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="add_to_cart" id="{{$item->variants[0]->id + 1}}">
                                            @php
                                                $v = collect($item->variants)->first();
                                            @endphp
                                            <a href="#"
                                               data-item="{{$item->slug}}"
                                               data-color="{{$v->color->name ?? ''}}"
                                               data-size="{{$v->size->name ?? ''}}">
                                                Add to cart
                                            </a>
                                        </div>
                                    </div>
                                    <div class="product_content list_content" style="width: 100%;">
                                        <h4 class="product_name">
                                            <a href="{{route('frontend.product', $item->slug)}}">{{$item->name}}</a>
                                        </h4>
                                        <div class="product_rating">
                                            <ul>
                                                @php $rating = $item->rating @endphp
                                                @foreach(range(2,6) as $i)
                                                    @if($rating > 0)
                                                        <li>
                                                            <span class="fa fa-star checked"></span>
                                                        </li>
                                                    @endif
                                                    @php $rating-- @endphp
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="price_box">
                                            @if($item->sale_price)
                                                <span class="old_price">TK {{$item->original_price}}</span>
                                                <span class="current_price">TK {{$item->sale_price}}</span>
                                            @else
                                                <span class="current_price">TK {{$item->original_price}}</span>
                                            @endif
                                        </div>
                                        <div class="product_desc">
                                            <p>{{$item->short_description}}</p>
                                        </div>
                                        <div class="add_to_cart" id="{{$item->variants[0]->id + 1}}">
                                            <a href="#"
                                               data-item="{{$item->slug}}"
                                               data-color="{{$v->color->name ?? ''}}"
                                               data-size="{{$v->size->name ?? ''}}">
                                                Add to cart
                                            </a>
                                        </div>
                                    </div>
                                </figure>
                                @if($count === 0)
                                    <div class="overlay" id="{{$item->variants[0]->id}}"><h3
                                            style="position: absolute;top: 45%;">Out of
                                            Stock</h3></div>
                                @endif

                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endif

