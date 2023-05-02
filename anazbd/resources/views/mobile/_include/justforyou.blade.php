<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
      integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
      crossorigin="anonymous"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"
        integrity="sha512-pXR0JHbYm9+EGib6xR/w+uYs/u2V84ofPrBpkgLYyKvhZYJtUUvKSy1pgi8tJZAacsPwgf1kbhI4zwgu8OKOqA=="
        crossorigin="anonymous"></script>

<div class="top-products-area clearfix py-3">
    <div class="">
      <div class="section-heading d-flex align-items-center justify-content-between">
         <h6 class="ml-1">Anaz Galaxy</h6><a class="btn btn-danger btn-sm" href="{{route("frontend.justforyou")}}">View All</a>
      </div>
      <div class="row g-3" id="product-card-holder" style="--bs-gutter-y: 1px;--bs-gutter-x: 1px;">

        @foreach($just_for_you as $item)
        <div class="col-6 col-md-4 col-lg-3" style="--bs-gutter-x: 1px; --bs-gutter-y: 1px; padding: 0;">
                    <div class="card top-product-card" style="box-shadow: -1px -1px 1px 0px #d7def4;">
                        <div class="card-body">
                            <span class="badge badge-success">Sale</span>
                            <div style="text-align: left; width: 100%">
                                <a class="{{ $item->isWishlisted ? 'fas fa-heart' : 'far fa-heart' }}" style="font-size: 25px; color: #a52a2a; margin-left: 81%; margin-top: 5%;" onclick="heartChange(this,'{{ $item->slug }}')"></a>
                            </div>
                                <a class="product-thumbnail d-block" href="{{ route('frontend.product',$item->slug) }}">
                                    <img style="height: 200px;width: auto;" class="mb-2" src="{{ asset($item->thumb_feature_image)}}" alt="{{$item->name}}" /></a>
                                <a class="product-title d-block" href="{{ route('frontend.product',$item->slug) }}"> {{Illuminate\Support\Str::limit($item->name, 22)}}</a>
                            {{-- <p class="sale-price">$13<span>$42</span></p> --}}

                            @if($item->sale_price)
                            <p class="sale-price">TK {{ $item->sale_price }}<span>TK {{ $item->original_price }}</span></p>
                            @else
                                <p class="sale-price">TK {{ $item->original_price }}</p>
                            @endif
                            {{-- <p class="sale-price">$13<span>$42</span></p> --}}
                            <div class="product-rating">
                                @if($item->rating)
                                    @for($i = 0; $i < $item->rating; $i++)
                                        <i class="lni lni-star-filled"></i>
                                    @endfor
                                @endif
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
        {{-- @endforeach --}}
        @endforeach
      </div>
    </div>
  </div>
