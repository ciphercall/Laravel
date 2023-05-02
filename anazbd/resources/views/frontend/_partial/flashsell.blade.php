@php
    $flash_sale_items = collect($flash_sale_items)
@endphp

@if($flash_sale_items->count())
    @push('css')
        <style>
            .card-header {
                padding: .75rem 0;
            }

            .card-deck .flash-card-decoration {
                min-width: 210px;
                min-height: 313px;
            }

            a.flash-card-decoration > .card {
                transition: all 0s;
                border-radius: 5px;
            }

            a.flash-card-decoration > .card:hover {
                -webkit-box-shadow: 0px 3px 7px -3px rgba(58, 58, 58, 0.5);
                box-shadow: 0px 3px 7px -3px rgba(58, 58, 58, 0.5);
            }
        </style>
    @endpush

    <div id="flash_sale_area" class="categories_product_area mb-55">
        <div class="container" style="background: white; width: 98%;    min-width: 1430px;
">
            <div class="card-body" style="padding: 0;">
                <div class="card-header"
                     style="background: white; display: flex; justify-content: space-between; align-items: center;">
                    <span class="area_name" style="font-weight: 500;">Flash Sale Ends :
                        <span id="demo" style="color: orange;"></span>
                    </span>
                    <a href="{{route('frontend.flash_sale')}}"
                       style="color: #ff7700; float: right; display: inline-block; border: 1px solid #ff7700; padding: 2px 10px;">
                        SHOP MORE
                    </a>
                </div>
                <div class="card-body row">
                    <div id="flash-sale-deck " class="card-deck owl-carousel" style="grid-gap: 0px;">
                        @foreach($flash_sale_items as $item)
                            <span class="flash-card-decoration col-md-2"
                                  style="padding-left: 0px; padding-right: 0px;">
                                <div class="card flash-card-responsive" style="height: 368px;">
                                    <span> <a class="{{ $item->isWishlisted ? 'fas fa-heart' : 'far fa-heart' }}"
                                                      style="font-size: 25px; color: #a52a2a; margin-left: 7%; margin-top: 5%;"
                                                      onclick="heartChange(this,'{{ $item->slug }}')"></a></span>
                                    <img class="card-img-top" loading="lazy"
                                         src="{{ $item->image }}"
                                         style="width: 178px; height: 178px;"
                                         alt="Card image cap">
                                    <div class="card-body">
                                        <a href="{{$item->url}}">
                                            <h5 class="card-text">{{Illuminate\Support\Str::limit($item->name, 30)}}</h5>
                                        <p class="card-text ">
                                            @if($item->sale_percentage)
                                                <i class="card_product_price">&#2547; {{$item->sale_price}}</i>
                                                <br>
                                                <i style="text-decoration: line-through; color: gray">&#2547; {{$item->original_price}}</i>
                                                <span style="color: orange">-{{$item->sale_percentage}}%</span>
                                            @else
                                                <i class="card_product_price">&#2547; {{$item->original_price}}</i>
                                            @endif
                                        </p>
                                        </a>

                                    </div>
{{--                                    <div class="add_to_cart">--}}
{{--                                            <a href="#"--}}
{{--                                               data-item="{{$item->slug}}"--}}
{{--                                               data-color="{{$v->color->name ?? ''}}"--}}
{{--                                               data-size="{{$v->size->name ?? ''}}">--}}
{{--                                                Add to cart--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
                                </div>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!--   ====================== flash on sale ====================-->
        <script>
            {{--            @dd($first_flash_sale->start_time->format('Y-m-d h:i:s'))--}}
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
                                        <div class="card flash-card-responsive" style="height: 368px;">
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
    @endpush
@endif
