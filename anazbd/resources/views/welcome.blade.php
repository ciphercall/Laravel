@if((new \Jenssegers\Agent\Agent())->isDesktop())
    {{--    @dd(get_defined_vars())--}}
    @extends('frontend.layouts.master')
    @section('title','Home')
    @push('css')
        <link rel="stylesheet" href="{{asset('frontend/assets/css/loadMore.css')}}">
        <style>
            .single_slider {
                background-size: 100% 100%;
                /*border-radius: 48px;*/
            }

            div#wrapper{
                /*height: 427px;*/
            }

            /*.owl-item{*/
            /*    width: 1003px !important;*/
            /*}*/
        </style>
    @endpush
@section('content')
    <!--slider area start-->
    <div id="wrapper">
        {{--        <div id="wrapper" style="height: 427px;background-size: 100% 217%;background-image: url(https://drive.google.com/uc?export=download&id=1nNVF3tZJHczT7fUFbWOAu1HpoVfj02D7);background-repeat: no-repeat;background-position-y: 90%;">--}}
        <section class="slider_section slider_s_four slider-responsive"
                 style="width: 66%;position: relative;left: 20%;top: 9%;">

            @include('frontend.include.slider')

        </section>
    </div>

    <!--shipping area end-->
    <div class="banner_area mb-55">
        <div class="container" style="padding: 0;max-width: 1920px;">
        {{-- banner section --}}

        @include('frontend._partial.banner')

        {{-- end offer section --}}

        <!-- offer section -->
        @include('frontend._partial.offer')

        <!--end offer section -->
        </div>
    </div>

    <!--home section bg area start-->
    <div class="home_section_bg">

        <!--    ================ FLASH SALL DIV START==============-->
    @include('frontend._partial.flashsell')

    <!--============= FLASH SALL DIV END==============-->
        <!--   div start of Categories products-->
     {{--  @include('frontend._partial.categories')  --}}
     @include('frontend._partial.product-slider',['items' => $recommanded,'title' => 'Recommanded For You'])
      @include('frontend._partial.product-slider',['items' => $discounted,'title' => 'Lowest Price Guaranteed'])

    <!--  =========================ANAZ-MALL div-start =======================-->
    @include('frontend._partial.anazmall')

    <!--  =========================Premium Sellers div-start =======================-->
    @include('frontend._partial.premium')

    <!--=============ANAZ-MALL div-end==========-->

        <!-- =====collection==== -->
    @include('frontend._partial.collection')

    <!--======just-for you-->

        @include('frontend._partial.justforyou')
    </div>

    @include('frontend.include.product-script')
    @push('js')
        <script>
            $(document).ready(function () {

                // localStorage.setItem('newReg','no');

                {{--var chkReg = localStorage.getItem('newReg');--}}
                {{--if (chkReg === 'yes') {--}}
                {{--    let url = "{{ url('/account') }}"--}}
                {{--    window.location.replace(url);--}}
                {{--}--}}

// image slider wrapper function

                let owl = $('.owl-carousel');
                // owl.owlCarousel();
// Listen to owl events:
//                 old code
//                 owl.on('changed.owl.carousel', function (event) {
//                     // alert('hello');
//                     console.log(this);
//                     $('.single_slider').mousemove(function (e) {      // Or $('.active img.single_slider').mousemove(function (e) {...
//
//                         if (!this.canvas) {                    //this = e.currentTarget
//                             this.canvas = $('<canvas />')[0];
//                             this.canvas.width = this.width;
//                             this.canvas.height = this.height;
//                             this.canvas.getContext('2d').drawImage(this, 0, 0, this.width, this.height);
//                         }
//
//                         // var pixelData = this.canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;
//                         var pixelData = this.canvas.getContext('2d').getImageData(7, 94, 1, 1).data;
//                         var capture = 'rgba(' + pixelData[0] + ',' + pixelData[1] + ',' + pixelData[2] + ',' + pixelData[3] + ')';
//
//                         $('#output').html('R: ' + pixelData[0] + '<br>G: ' + pixelData[1] + '<br>B: ' + pixelData[2] + '<br>A: ' + pixelData[3]);
//
//                         $('#wrapper').css('background-color', capture);
//                         // console.log(event.offsetX + ' ' + event.offsetY);
//                         // console.log(this.id);
//
//                     });
//                 });
// old code

                // new code

                owl.on('changed.owl.carousel', function (event) {
                    var current = event.item.index;
                    var src = $(event.target).find(".owl-item").eq(current).find("img").attr('src');
                    var width = $(event.target).find(".owl-item").eq(current).find("img").width();
                    var height = $(event.target).find(".owl-item").eq(current).find("img").height();
                    // console.log('Image current is ' + src);
                    let img = new Image;

                    img.src = src;
                    img.width = width;
                    img.height = height;

                    if (width === 1002 && height === 350) {
                        if (!img.canvas) {                    //this = e.currentTarget
                            img.canvas = $('<canvas />')[0];
                            img.canvas.width = img.width;
                            img.canvas.height = img.height;
                            // img.canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);

                            try {
                                img.canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);
                                console.log('Image is drawn!');
                            } catch (err) {
                                console.log('this is an error: ' + error);
                            }
                        }else{
                            img.canvas.width = img.width;
                            img.canvas.height = img.height;
                            // img.canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);

                            try {
                                img.canvas.getContext('2d').drawImage(img, 0, 0, img.width, img.height);
                                console.log('Image is drawn!');
                            } catch (err) {
                                console.log('this is an error: ' + err);
                            }
                        }

                        // var pixelData = this.canvas.getContext('2d').getImageData(event.offsetX, event.offsetY, 1, 1).data;
                        var pixelData = img.canvas.getContext('2d').getImageData(7, 94, 1, 1).data;
                        var capture = 'rgba(' + pixelData[0] + ',' + pixelData[1] + ',' + pixelData[2] + ',' + pixelData[3] + ')';

                        $('#output').html('R: ' + pixelData[0] + '<br>G: ' + pixelData[1] + '<br>B: ' + pixelData[2] + '<br>A: ' + pixelData[3]);

                        $('#wrapper').css('background-color', capture);
                        console.log(img);
                    }
                });
                //new code


            });


            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items: 6,
                loop: true,
                margin: 4,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });

            var owl2 = $('.owl-carousel2');
            owl2.owlCarousel({
                items: 5,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 3000,
                autoplayHoverPause: true
            });
        </script>
    @endpush
    <!--home section bg area end-->
@endsection

@else
    @include('mobile.index')
@endif
