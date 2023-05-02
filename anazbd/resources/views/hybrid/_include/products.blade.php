<div class="row g-3" id="product-card-holder">
    <!-- Single Top Product Card-->

    @foreach($items as $item)
        <div class="col-6 col-md-4 col-lg-3" style="padding-right:0;padding-left: 0;margin-top: 0;">
            <div class="card top-product-card">
                <div class="card-body">
                    {{-- <span class="badge badge-success">Sale</span> --}}
                    <div style="text-align: left; width: 100%">
                        <a class="{{ $item->isWishlisted ? 'fas fa-heart' : 'far fa-heart' }}" style="font-size: 25px; color: #a52a2a; margin-left: 81%; margin-top: 5%;" onclick="heartChange(this,'{{ $item->slug }}')"></a>
                    </div>
                    <a class="product-thumbnail d-block" href="{{route('frontend.product',$item->slug)}}">
                        <img class="mb-2" style="height: 200px; width:auto;" src="{{ asset($item->thumb_feature_image) }}" alt="{{ $item->name }}" /></a>
                        <a class="product-title d-block" href="{{route('frontend.product',$item->slug)}}"> {{$item->name}}</a>
                    {{-- <p class="sale-price">$13<span>$42</span></p> --}}

                    @if($item->sale_price)
                        <p class="sale-price">TK {{$item->sale_price}}<span>TK {{$item->original_price}}</span></p>
                    @else
                        <p class="sale-price">TK {{$item->original_price}}</p>
                    @endif
                    {{-- <p class="sale-price">$13<span>$42</span></p> --}}
                    <div class="product-rating">
                        @php $rating = $item->rating; @endphp
                        @foreach(range(2,6) as $i)
                            @if($rating > 0)
                                <i class="lni lni-star-filled"></i>
                            @endif
                            @php $rating--; @endphp
                        @endforeach
                    </div>
                    <div class="add_to_cart">
                        <a class="btn btn-success btn-sm add2cart-notify" href="#"
                           data-item="{{$item->slug}}"
                           data-color="{{$v->color->name ?? ''}}"
                           data-size="{{$v->size->name ?? ''}}">
                            @php
                                $v = collect($item->variants)->first()
                            @endphp

                            <i class="lni lni-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
