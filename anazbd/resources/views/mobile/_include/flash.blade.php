<style>
    .wishlist-btn {
        font-size: 21px;
        color: red;
    }

</style>


@if($flash_sale_items->count())
    <div class="flash-sale-wrapper">
        <div class="" style="padding-top: 15px;">
            <div class="section-heading d-flex align-items-center justify-content-between">
                <h6 class="ml-1">Flash Sale</h6>
                <span id="demo" style="color: orange;font-size:blod"></span>
                <a class="btn btn-primary btn-sm" href="{{route('frontend.flash_sale')}}">View All</a>
            </div>
            <!-- Flash Sale Slide-->
            <div class="flash-sale-slide owl-carousel">
                <!-- Single Flash Sale Card-->
                @foreach ($flash_sale_items as $item)
                    {{-- @dd($item->url); --}}
                    <div class="card flash-sale-card top-product-card">
                        <div class="card-body" style="height: 242px;">
                            <div style="text-align: left; width: 100%">
                                <a class="{{ $item->isWishlisted ? 'fas fa-heart' : 'far fa-heart' }}" style="font-size: 25px; color: #a52a2a; margin-left: 81%; margin-top: 5%;" onclick="heartChange(this,'{{ $item->slug }}')"></a>
                            </div>                            <a href="{{$item->url}}">
                                <img style="height: 100px;width: auto;" src="{{ asset($item->image)}}" alt="">
                                <span class="product-title">{{ $item->name }}</span>
                                <p class="sale-price">&#2547; {{$item->sale_price}}
                                    <span class="real-price">&#2547; {{$item->original_price}}</span>
                                </p>
                            {{-- <span class="progress-title">33% Sold Out</span> --}}
                            <!-- Progress Bar-->
                                {{-- <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: 33%" aria-valuenow="33" aria-valuemin="0" aria-valuemax="100"></div>
                                </div> --}}
                            </a>
                            <div class="add_to_cart">
                                <a class="btn btn-success btn-sm add2cart-notify" href="#"
                                   data-item="{{$item->slug}}"
                                   data-color="{{$item->variants->color->name ?? ''}}"
                                   data-size="{{$item->variants->size->name ?? ''}}">
                                    <i class="lni lni-plus"></i>
                                </a>
                            </div>                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>

    <script>
        {{-- @dd($first_flash_sale->start_time->format('Y-m-d h:i:s'))--}}
        // Set the date we're counting down to
        let countDownDate = new Date("{{$flash_sale_items->first()->end_time}}").getTime();

        function padZero(number) {
            if (number < 10)
                return "0" + number.toString();
            return number;
        }

        // Update the count down every 1 second
        let x = setInterval(function () {

            // Get today's date and time
            let now = new Date().getTime();

            // Find the distance between now and the count down date
            let distance = countDownDate - now;

            // Time calculations for days, hours, minutes and seconds
            // let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = "" + padZero(hours) + " : " + padZero(minutes) + " : " + seconds;

            // If the count down is over, write some text
            if (distance < 0) {
                $.get('{{route('frontend.flash_sale.ajax')}}', function (res) {
                    $('#flash-sale-deck').html('');
                    if (res.items instanceof Array && res.items.length > 0) {
                        countDownDate = new Date(res.items[0].end_time);
                        res.items.forEach(function (item) {
                            $('#flash-sale-deck').append(`
                            <a href="${item.url}" class="flash-card-decoration col-md-2">
                                <div class="card flash-card-responsive">
                                    <img class="card-img-top"
                                         src="${item.image}"
                                         style="width: 178px; height: 178px;"
                                         alt="Card image cap">
                                    <div class="card-body">
                                        <h5 class="card-text">${item.name}</h5>
                                        <p class="card-text ">
                                            <i class="card_product_price">&#2547; ${item.sale_price}</i>
                                            <br>
                                            <i style="text-decoration: line-through; color: gray">&#2547; ${item.original_price}</i>
                                            <span style="color: orange">-${item.sale_percentage}%</span>
                                        </p>
                                    </div>
                                </div>
                            </a>`);
                        });
                    } else {
                        clearInterval(x);
                        $('#flash_sale_area').css('display', 'none');
                    }
                });
            }
        }, 1000);
    </script>
@endif
@push('script')
    <script>
        $(window).scroll(function () {
            if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
                let data = {
                    "_token": "{{ csrf_token() }}",
                }
                loadMoreProducts(data)
            }
        })
    </script>
@endpush
