<style>@import url(https://fonts.googleapis.com/css?family=Open+Sans);

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
    .wrap {
        width: 30%;
        position: absolute;
        top: 50%;
        left: 81%;
        transform: translate(-50%, -50%);
    }

    /*.col-lg-2 .col-md-4 .col-sm-6{*/
    /*    padding-left: 0px !important;*/
    /*    padding-right: 0px !important;*/
    /*}*/
    .single_product:hover .add_to_cart {
        visibility: visible;
        opacity: 1;
        bottom: -61px;
        -webkit-box-shadow: 0px 4px 5px 0px rgba(0, 0, 0, 0.15);
        box-shadow: 0px 4px 5px 0px rgba(0, 0, 0, 0.15);
    }

    .overlay {
        position: absolute;
        top: 0;
        /*background: rgb(0, 0, 0);*/
        background: linear-gradient(to right, rgba(248, 80, 50, 0.6) 0%, rgba(231, 56, 39, 0.6) 100%); /* Black see-through */
        color: #f1f1f1;
        width: 100%;
        transition: .5s ease;
        opacity: 0;
        color: white;
        font-size: 20px;
        padding: 20px;
        text-align: center;
        height: 100%;
    }

    .single_product:hover .overlay {
        opacity: 1;
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"
        integrity="sha512-pXR0JHbYm9+EGib6xR/w+uYs/u2V84ofPrBpkgLYyKvhZYJtUUvKSy1pgi8tJZAacsPwgf1kbhI4zwgu8OKOqA=="
        crossorigin="anonymous"></script>

{{--<script>--}}
{{--    $(document).ready(--}}
{{--        $("#a2Cart").show()--}}
{{--    );--}}
{{--</script>--}}


@php
    $just_for_you = collect($just_for_you);
@endphp

@if($just_for_you->count())
    <div class="product_area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="categories_product_area" style="margin-left: 0;">
                        <div class="section_title" style="width: 100%">
                            <h2 style="margin: 0">Anaz Galaxy</h2>
                            <a style="margin-left: 80%">
                                <div class="wrap">
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
                        <div class="product_tab_btn">
                            <ul class="nav" role="tablist">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--  ==========just for you======-->
            <div class="categories_product_area" style="margin: 14px;">
                <div class="card-deck" id="product-card-holder" style="grid-gap: 0px;">
                    @foreach($just_for_you as $item)
                        {{--                        <div>--}}
                        {{--                            <h3>this is variants count...</h3> {{$item->variants[0]->qty}}--}}
                        {{--                        </div>--}}
                        <div class="col-lg-2 col-md-4 col-sm-6 no-padding-margin">
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
        <div style="text-align: center;width: 100%;padding-top: 5%;">
            <button class="button" id="load-more"><span>Load More </span></button>
        </div>
    </div>
@endif

@push('js')
    <script>
        $('#load-more').on('click', function (e) {
            let data = {
                "token": "{{ csrf_token() }}",
            }
            loadMoreProducts(data, 'col-lg-2 col-md-4 col-sm-6 no-padding-margin')
        })

        // let overlay = $(".overlay");

        $('.single_product').on('mouseover', function (event) {

            console.log(this.childNodes);
            // console.log($(".single_product").find('div.overlay'));
            // let figure = $(".single_product").find('div.overlay');


            var overlay = null;
            for (var i = 0; i < this.childNodes.length; i++) {
                if (this.childNodes[i].className == "overlay") {
                    overlay = this.childNodes[i].id;
                    console.log('this is my target mother: ' + overlay);
                    console.log('this is my target: ' + (parseInt(overlay)+1));
                    if (overlay !== undefined || overlay !== null) {
                        $('#'+(parseInt(overlay)+1)).hide();
                    }

                    break;
                }
            }
        });

    </script>
    @include('frontend.include.loadMoreProducts')
@endpush
