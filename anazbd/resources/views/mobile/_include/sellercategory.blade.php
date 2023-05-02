<div class="weekly-best-seller-area py-3">
        <div class="">
          <div class="section-heading d-flex align-items-center justify-content-between">
            {{-- <h6 class="pl-1">Categories</h6><a class="btn btn-success btn-sm" href="{{route('seller.category.show')}}">View All</a> --}}
          </div>
          @foreach(collect($categories)->take(6) as $category)
          <div class="row g-3">
            <div class="col-md-4">
              <div class="card weekly-product-card">
                <div class="card-body d-flex align-items-center">
                  <div class="product-thumbnail-side">
                      {{-- <span class="badge badge-success">Sale</span> --}}
                    {{-- <a class="wishlist-btn" href="#"><i class="lni lni-heart"></i></a> --}}
                    <a class="product-thumbnail d-block" href="{{route('frontend.category', $category->slug)}}">
                        <img src="{{ asset($category->image)}}" alt=""></a></div>
                    <div class="product-description">
                        <a class="product-title d-block" href="">{{ $category->name }}</a>
                        <p class="sale-price">
                            Porduct : {{ $category->items->count() }}p
                            {{-- <i class="lni lni-dollar"></i>$64 --}}
                            {{-- <span>$89</span> --}}
                        </p>
                        {{-- <div class="product-rating">
                            <i class="lni lni-star-filled"></i>4.88 (39)
                        </div> --}}
                        <a class="btn btn-success btn-sm add2cart-notify" href="#">View All</a>
                  </div>
                </div>
              </div>
            </div>
            @endforeach

          </div>
        </div>
      </div>
