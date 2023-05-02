<style>
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


<div class="col-lg-2 col-md-4 col-sm-6 col-lg-3">
    <article class="single_product">
        @php
            $count = ($item->variants[0]->qty);
        @endphp
        <div style="text-align: left;width: 100%;position: relative;z-index: 1;"><a class="{{ $item->isWishlisted ? 'fas fa-heart' : 'far fa-heart' }}"
                                                      style="font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;"
                                                      onclick="heartChange(this,'{{ $item->slug }}')"></a>
        </div>
        <figure style="width: 100%;">
            <div class="product_thumb">
                <a class="primary_img"
                   href="{{route('frontend.product', $item->slug)}}"><img
                        src="{{asset($item->thumb_feature_image)}}"
                        alt="{{$item->name}}"></a>

                @if($item->sale_price)
                    <div class="label_product">
                        <span class="label_sale">Sale</span>
                    </div>
                @endif
            </div>

            <div class="product_content grid_content">
                <div class="product_content_inner">
                    <h4 class="product_name">
                        <a href="{{route('frontend.product', $item->slug)}}">
                            @if(mb_check_encoding($item->name, 'ASCII'))
                                {{Illuminate\Support\Str::limit($item->name, 38)}}
                            @else
                                {{Illuminate\Support\Str::limit($item->name, 60)}}
                            @endif
                        </a>
                    </h4>
                    <div class="product_rating">
                        <ul>
                            @php $rating = $item->rating; @endphp
                            @foreach(range(2,6) as $i)
                                     @if($rating > 0)
                                        <li>
                                            <span class="fa fa-star checked"></span>
                                        </li>
                                     @endif
                             @php $rating--; @endphp
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
                        @php $rating = $item->rating; @endphp
                        @foreach(range(2,6) as $i)
                                 @if($rating > 0)
                                    <li>
                                        <span class="fa fa-star checked"></span>
                                    </li>
                                 @endif
                         @php $rating--; @endphp
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
                    style="position: absolute;top: 45%;left: 23%;">Out of
                    Stock</h3></div>
        @endif
    </article>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
<script>
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
