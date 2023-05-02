@extends('mobile.layouts.master')
@section('mobile')
    <div class="page-content-wrapper">
        <!-- Product Slides-->
        <div class="product-slides owl-carousel">
            <!-- Single Hero Slide-->
            @forelse($item->other_images as $image)
                {{-- @if($image->path_resized) --}}
                <div class="single-product-slide" style="background-image: url('{{asset($image->path)}}')"></div>
                {{-- @endif --}}
            @empty
                <div class="single-product-slide"
                     style="background-image: url('{{asset($item->feature_image)}}')"></div>
            @endforelse
            {{-- <div class="single-product-slide" style="background-image: url('{{asset('mobile/img/bg-img/6.jpg')}}')"></div> --}}
        </div>
        <div class="product-description">
            <!-- Product Title & Meta Data-->
            <div class="product-title-meta-data bg-white mb-3 py-3">
                <div class="container d-flex justify-content-between">
                    <div class="p-title-price">
                        <h6 class="mb-1">{{$item->name}}</h6><br>

                        {{--  @dd($item->original_price,$item->original_price,$item)  --}}

                        @foreach($item->variants as $variant)

                            <span style="display: {{$loop->index == 0 ? 'block': 'none'}}">
                                @if($variant->sale_percentage)
                                    <span style="text-decoration: line-through; color: gray;">
                                        ৳ {{ $variant->price + $item->getPriceAdditionAttribute($variant)  }}
                                    </span>
                                    <span class="text-danger">&emsp;৳ {{ $variant->sale_price }}</span>

                                @else
                                    <span>৳ {{ $variant->price + $item->getPriceAdditionAttribute($variant) }}</span>
                                @endif
                            </span>
                        @endforeach
                        @if($item->is_online_pay_only)
                            <small style="font-size: 8pt;" class="text-muted">This Item supports online payment only.</small>
                        @endif
                    </div>
                    <div style="text-align: left;">
                        <a class="far fa-heart"
                           style="font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;"
                           onclick="heartChange(this,'{{ $item->slug }}')"></a>
                    </div>
                </div>
                <!-- Ratings-->
                {{--  <div class="product-ratings">
                <div class="container d-flex align-items-center justify-content-between">
                    <div class="ratings">
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <i class="lni lni-star-filled"></i>
                        <span class="pl-1">3 ratings</span>
                    </div>
                    <div class="total-result-of-ratings"><span>5.0</span><span>Very Good                                </span></div>
                </div>
                </div>  --}}
            </div>
{{--            <!-- Flash Sale Panel-->--}}
{{--          <div class="flash-sale-panel bg-white mb-3 py-3">--}}
{{--          <div class="container">--}}
{{--            <!-- Sales Offer Content-->--}}
{{--            <div class="sales-offer-content d-flex align-items-end justify-content-between">--}}
{{--              <!-- Sales End-->--}}
{{--              <div class="sales-end">--}}
{{--                <p class="mb-1 font-weight-bold"><i class="lni lni-bolt"></i> Flash sale end in</p>--}}
{{--                <!-- Please use event time this format: YYYY/MM/DD hh:mm:ss-->--}}
{{--                <ul class="sales-end-timer pl-0 d-flex align-items-center" data-countdown="2022/01/01 14:21:37">--}}
{{--                  <li><span class="days">0</span>d</li>--}}
{{--                  <li><span class="hours">0</span>h</li>--}}
{{--                  <li><span class="minutes">0</span>m</li>--}}
{{--                  <li><span class="seconds">0</span>s</li>--}}
{{--                </ul>--}}
{{--              </div>--}}
{{--              <!-- Sales Volume-->--}}
{{--              <div class="sales-volume text-right">--}}
{{--                <p class="mb-1 font-weight-bold">82% Sold Out</p>--}}
{{--                <div class="progress" style="height: 6px;">--}}
{{--                  <div class="progress-bar bg-warning" role="progressbar" style="width: 82%;" aria-valuenow="82" aria-valuemin="0" aria-valuemax="100"></div>--}}
{{--                </div>--}}
{{--              </div>--}}
{{--            </div>--}}
{{--          </div>--}}
{{--        </div>  --}}
        @php
            $colors = $item->variants->groupBy('color_id');
            $sizes = $item->variants->groupBy('size_id');
        @endphp
        @if ($item->variants->count() > 1)
            <!-- Selection Panel-->
                <div class="selection-panel bg-white mb-3 py-3">

                    <div class="container d-flex align-items-center justify-content-between">


                        <!-- Choose Color-->
                        <div class="choose-color-wrapper">
                            @if($colors->keys()[0] != '')
                            <p class="mb-1 font-weight-bold">Color</p>
                            <div class="choose-color-radio d-flex align-items-center">

                                @foreach($item->variants as $variant)
                                    <!-- Single Radio Input-->
                                    <div class="form-check mb-0">
                                        <input class="form-check-input {{ $variant->color->name }}" id="colorRadio1" type="radio"
                                            name="color" checked>
                                        <label class="form-check-label" for="colorRadio1"></label>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        </div>


                        <!-- Choose Size-->
                        <div class="choose-size-wrapper text-right">
                            @if($sizes->keys()[0] != '')

                                <p class="mb-1 font-weight-bold">Size</p>
                                <div class="choose-size-radio d-flex align-items-center">
                                    @foreach($item->variants as $variant)
                                    <div class="form-check mb-0 mr-2">
                                        <input class="form-check-input" id="sizeRadio1" value="{{ $variant->size->name }}" type="radio" name="size">
                                        <label class="form-check-label" for="sizeRadio1">{{ $variant->size->name }}</label>
                                    </div>
                                    @endforeach

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
        @endif
        <!-- Add To Cart-->
            <div class="cart-form-wrapper bg-white mb-3 py-3">
                <div class="container">
                    <form class="cart-form" action="#" method="">
                        @csrf
                        <div class="order-plus-minus d-flex align-items-center">
                            <div class="quantity-button-handler">-</div>
                            <input class="form-control cart-quantity-input" type="text" step="1" name="quantity"
                                   value="1" min="1">
                            <div class="quantity-button-handler">+</div>
                        </div>
                        <button type="button" style="margin-left: 50px;" class="btn btn-danger">
                            @php
                                $v = collect($item->variants)->first()
                            @endphp
                            <a id="add_to_cart_mobile" style="color: black" href="#"
                               data-item="{{$item->slug}}"
                               data-color=""
                               data-max="{{ $item->max_orderable_qty }}"
                               data-size="">
                                Add to cart
                            </a>
                        </button>
                    </form>
                </div>
            </div>
            <!-- Product Specification-->
            <div class="p-specification bg-white mb-3 py-3">
                <div class="container">
                    <h6>Specifications</h6>
                    {!! $item->description??'' !!}
                    @if($item->is_online_pay_only)
                        <small style="font-size: 10pt;" class="text-muted">This Item supports online payment only.</small>
                    @endif
                </div>
            </div>
            <!-- Rating & Review Wrapper-->
            @if($item->comments->count() > 0)
                <div class="rating-and-review-wrapper bg-white py-3 mb-3">
                    <div class="container">
                        <h6>Ratings &amp; Reviews</h6>
                        <div class="rating-review-content">
                            <ul class="pl-0">
                                @foreach($comments as $comment)
                                    <li class="single-user-review d-flex">
                                        <div class="user-thumbnail"><img src="{{ asset($comment->user->image) }}"
                                                                         alt=""></div>
                                        <div class="rating-comment">
                                            <div class="rating">
                                                @for ($i = 1; $i <= 5; $i++)
                                                    <i class="fa fa-star @if($i <= $comment->rating) text-warning @else text-muted @endif"></i>
                                                @endfor
                                            </div>
                                            {{ $comment->review }}
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        <!-- Ratings Submit Form-->

            <div class="ratings-submit-form bg-white py-3">
                @auth
                    <div class="container">
                        <h6>Submit A Review</h6>
                        <form action="{{ route('frontend.comment',$item->slug) }}" method="Post">
                            @csrf
                            <div class="stars mb-3">
                                <input class="star-1" value="1" type="radio" name="rating" id="star1">
                                <label class="star-1" for="star1"></label>
                                <input class="star-2" value="2" type="radio" name="rating" id="star2">
                                <label class="star-2" for="star2"></label>
                                <input class="star-3" value="3" type="radio" name="rating" id="star3">
                                <label class="star-3" for="star3"></label>
                                <input class="star-4" value="4" type="radio" name="rating" id="star4">
                                <label class="star-4" for="star4"></label>
                                <input class="star-5" value="5" type="radio" name="rating" id="star5">
                                <label class="star-5" for="star5"></label><span></span>
                            </div>
                            <textarea class="form-control mb-3" id="review_comment" name="review" cols="30" rows="10"
                                      data-max-length="200" placeholder="Write your review..."></textarea>
                            <button class="btn btn-sm btn-primary" type="submit">Save Review</button>
                        </form>
                    </div>
                @else
                    <div class="container">
                        <h6>Submit A Review ? At First <a href="{{ url('/login') }}">Login.</a></h6>
                    </div>
                @endauth

            </div>

            <!-- Rating & Review Wrapper-->
            @if($item->questions->count() > 0)
                <br>
                <div class="rating-and-review-wrapper bg-white py-3 mb-3">
                    <div class="container">
                        <h6>Questions</h6>
                        <div class="rating-review-content">
                            <ul class="pl-0">
                            @if($questionsByUser != null)
                                @forelse($questionsByUser as $question)
                                    <li class=" d-flex">
                                        <div class="row"><span class="text-danger">In Review</span></div>
                                        <br>

                                        <div class="rating-comment">
                                            {{ $question->question }}
                                        </div>
                                        @if($question->answer)
                                            <div class="row">
                                                <span class="text-muted">{{ $question->answer->answer }}</span>
                                            </div>
                                        @endif
                                    </li>
                                @empty
                                    <small class="text-muted">No Questions by You</small>
                                @endforelse
                            @endif
                            </ul>
                            <ul class="pl-0">
                                @foreach ($item->questions as $question)
                                    <li class="single-user-review d-flex">
                                        <div class="user-thumbnail"><img src="{{ asset($question->user->image) }}"
                                                                         alt=""></div>
                                        <div class="rating-comment">
                                            {{ $question->question }}
                                        </div>
                                        @if($question->answer)
                                            <div class="row">
                                                <span class="text-muted">{{ $question->answer->answer }}</span>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
        <!-- Ratings Submit Form-->

            <div class="ratings-submit-form bg-white py-3">
                @auth
                    <div class="container">
                        <h6>Submit A Question</h6>
                        <form action="{{ route('frontend.question.store',$item->slug) }}" method="Post">
                            @csrf
                            {{--                                <div class="stars mb-3">--}}
                            {{--                                    <input class="star-1" value="1" type="radio" name="rating" id="star1">--}}
                            {{--                                    <label class="star-1" for="star1"></label>--}}
                            {{--                                    <input class="star-2" value="2" type="radio" name="rating" id="star2">--}}
                            {{--                                    <label class="star-2" for="star2"></label>--}}
                            {{--                                    <input class="star-3" value="3" type="radio" name="rating" id="star3">--}}
                            {{--                                    <label class="star-3" for="star3"></label>--}}
                            {{--                                    <input class="star-4" value="4" type="radio" name="rating" id="star4">--}}
                            {{--                                    <label class="star-4" for="star4"></label>--}}
                            {{--                                    <input class="star-5" value="5" type="radio" name="rating" id="star5">--}}
                            {{--                                    <label class="star-5" for="star5"></label><span></span>--}}
                            {{--                                </div>--}}
                            <textarea class="form-control mb-3" id="question_box" name="question" cols="30" rows="10"
                                      data-max-length="200" placeholder="Write your review..."></textarea>
                            <button class="btn btn-sm btn-danger" type="submit">Ask Your Question?</button>
                        </form>
                        @if($item->questions)
                            <h6>Questions for : {{ $item->name }}</h6>
                            @if($questionsByUser != null)
                                <hr>
                                @foreach ($questionsByUser as $question)
                                    <div class="reviews_comment_box">
                                        <div class="comment_thmb"></div>
                                        <div class="comment_text" style="margin-left: 0">
                                            <p>
                                                <strong>{{ $question->user->name }} </strong>- {{  $question->created_at->format('d-M-Y') }}
                                                <span class="text-danger"></span></p>
                                            <span>{{ $question->question }}</span>
                                        </div>
                                    </div>
                    </div>
                    @endforeach
                    <hr>
                @endif

                @foreach ($item->questions as $question)
                    <div class="reviews_comment_box">
                        <div class="comment_thmb"></div>
                        <div class="comment_text" style="margin-left: 0">
                            <p>
                                <strong>{{ $question->user->name }} </strong>- {{  $question->created_at->format('d-M-Y') }}
                            </p>
                            <span>{{ $question->question }}</span>
                        </div>
                    </div>
            </div>
            @if($question->answer)
                <div class="reviews_comment_box ml-5">
                    <div class="comment_thmb"></div>
                    <div class="comment_text" style="margin-right: 0">
                        <p><strong>Replied By
                                Seller </strong>- {{  Carbon\Carbon::parse($question->answer->created_at)->diffForhumans($question->created_at) }}
                        </p>
                        <span>{{ $question->answer->answer }}</span>
                    </div>
                </div>
        </div>
        @endif
        @endforeach
        @endif

    </div>
    @else
        <div class="container">
            <h6>Have a Question ? At First <a href="{{ url('/login') }}">Login.</a></h6>
        </div>
        @endauth
        </div>

        @include('mobile._include.products',['items' => $related_items])
        </div>
        </div>
@endsection
@include('mobile.includes.product-script')
