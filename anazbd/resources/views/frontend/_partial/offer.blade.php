<style>
    @keyframes anim-glow {
        0% {
            box-shadow: 0 0 rgba(#61EF61, 1);
        }
        100% {
            box-shadow: 0 0 10px 8px orangered;
            border-width: 2px;
        }
    }

    .col-auto {
        /*padding: 50px;*/
        background-color: green;
        transition: transform .2s; /* Animation */
        width: 200px;
        height: 200px;
        margin: 0 auto;
        animation: anim-glow 4s ease infinite;
        animation-direction: alternate;
    }

    /*.col-auto:hover {*/
    /*    transform: scale(1.5); !* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) *!*/
    /*    z-index: 1;*/
    /*}*/

    strong {
        font-family: 'sans-serif';
        font-size: 100%;
    }

    @media only screen and (min-width: 1366px) {
        strong {
            /*font-size: 122%;*/
            font-size: 111%;
        }
    }

    @media only screen and (max-width: 1365px) and (min-width: 1076px) {
        strong {
            font-size: 110%;
        }
    }

    @media only screen and (max-width: 1075px) and (min-width: 1010px) {
        strong {
            font-size: 100%;
        }
    }

    @media only screen and (max-width: 1009px) {
        strong {
            font-size: 60%;
        }
    }

    .owl-stage-outer {
        min-height: 88px;
    }
</style>

{{--<div class="row anaz-short-cateory" style="padding-top: 32px;">--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(245,245,59,0.58) 0%, rgba(230,39,185,0.58) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;">--}}
{{--        <a href="{{ route('frontend.digital_sheba') }}">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\digital-sheba.png') }}" alt=""--}}
{{--                 style="width:35px;height: 35px;">--}}
{{--            <strong>Digital Sheba</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(92,54,245,0.58) 0%, rgba(71,230,39,0.58) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;">--}}
{{--        <a href="{{ route('frontend.best_seller') }}">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\best-seller-icon.png') }}" alt=""--}}
{{--                 style="width: 59px;height: 50px;">--}}
{{--            <strong>Best Sellers</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(247,247,52,0.58) 0%, rgba(231,56,39,0.58) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;">--}}
{{--        <a href="{{ route('frontend.discounts') }}">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\discounts.png') }}" alt=""--}}
{{--                 style="width:35px;height: 35px;">--}}
{{--            <strong>Discounts</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(210,255,82,0.6) 0%, rgba(67,225,230,0.53) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;">--}}
{{--        <a href="{{ route('frontend.anaz_mall') }}">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\Anaz-mall.png') }}" alt=""--}}
{{--                 style="width:35px;height: 35px;">--}}
{{--            <strong>Anaz Empire</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(245,24,105,0.31) 0%, rgba(20,222,44,0.56) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;">--}}
{{--        <a href="{{ route('frontend.global_collections') }}">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\global-collection.png') }}" alt=""--}}
{{--                 style="width:35px;height: 35px;">--}}
{{--            <strong>Global Collection</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(219,245,24,0.31) 0%, rgba(24,18,224,0.56) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;">--}}
{{--        <a href="{{ route('frontend.recipes') }}">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\anaz-recipe.png') }}" alt=""--}}
{{--                 style="width:35px;height: 35px;">--}}
{{--            <strong>Anaz Receipe</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--    <div style="width: 2%;"></div>--}}
{{--    <button class="col-auto"--}}
{{--            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(169,54,245,0.46) 0%, rgba(0,255,234,0.4) 100%);border: aliceblue;border-radius: 25px;width: 14%;height: 54px;margin-top: 24px;">--}}
{{--        <a href="{{ route('frontend.self.order.index') }}" style="position: relative;top: -4px;">--}}
{{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\anaz-recipe.png') }}" alt=""--}}
{{--                 style="width:35px;height: 35px;">--}}
{{--            <i style="font-size: 31px;position: relative;top: 3px;color: brown;" class="fas fa-cloud-upload-alt"></i>--}}
{{--            <strong>Upload & Order</strong>--}}
{{--        </a>--}}
{{--    </button>--}}
{{--</div>--}}

<div class="row">
    <button class="col-auto"
            style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(169,54,245,0.46) 0%, rgba(0,255,234,0.4) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 96px;margin-left: 3%;display: inline-block;top: -50px;">
        <a href="{{ route('frontend.self.order.index') }}">
            {{--            <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\anaz-recipe.png') }}" alt=""--}}
            {{--                 style="width:35px;height: 35px;">--}}
            <i style="font-size: 31px;color: brown;width: auto;height: 36px;" class="fas fa-cloud-upload-alt"></i>
            <strong style="position: relative;top: -6px;">Upload & Order</strong>
        </a>
    </button>
    <div class="col" style="max-width: 80%;margin-right: 1px;padding: 0;">
        <div id="carou_offer" class="row anaz-short-cateory owl-carousel"
             style="padding-top: 32px;min-height: 128px;margin-right: 3px;max-width: 94%;">
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(219,245,24,0.31) 0%, rgba(24,18,224,0.56) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{route('categories.show')}}">
                    <img loading="lazy" src="https://drive.google.com/uc?export=download&id=1fm_RonuBpjr7YdGGOuP09faT13VUxhbp" alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong style="position: relative;left: 3%;">Categories</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(245,245,59,0.58) 0%, rgba(230,39,185,0.58) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{ route('frontend.digital_sheba') }}">
                    <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\digital-sheba.png') }}" alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong>Digital Sheba</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(92,54,245,0.58) 0%, rgba(71,230,39,0.58) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{ route('frontend.best_seller') }}">
                    <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\best-seller-icon.png') }}"
                         alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong>Best Sellers</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(247,247,52,0.58) 0%, rgba(231,56,39,0.58) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{ route('frontend.discounts') }}">
                    <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\discounts.png') }}" alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong>Discounts</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(210,255,82,0.6) 0%, rgba(67,225,230,0.53) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{ route('frontend.anaz_mall') }}">
                    <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\Anaz-mall.png') }}" alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong>Anaz Empire</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(245,24,105,0.31) 0%, rgba(20,222,44,0.56) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{ route('frontend.global_collections') }}">
                    <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\global-collection.png') }}"
                         alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong>Global Collection</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
            <button class="col-auto"
                    style="box-shadow: 0 10px 16px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);background: linear-gradient(to right, rgba(219,245,24,0.31) 0%, rgba(24,18,224,0.56) 100%);border: aliceblue;border-radius: 25px;height: 54px;margin-top: 6%;margin-left: 6%;">
                <a href="{{ route('frontend.recipes') }}">
                    <img loading="lazy" src="{{ asset('frontend/assets\img\short-category\anaz-recipe.png') }}" alt=""
                         style="width: auto;height: 50px;display: inline-flex;">
                    <strong>Anaz Receipe</strong>
                </a>
            </button>
            {{--    <div style="width: 2%;"></div>--}}
        </div>
    </div>
</div>
@push('js')
    <script>
        var owlOffer = $('#carou_offer');
        owlOffer.owlCarousel({
            items: 5,
            loop: true,
            margin: 10,
            autoplay: false,
            autoplayTimeout: 3000,
            autoplayHoverPause: true
        });

        $(document).ready(function (){
            for(var i = 0;i<4;i++){
                $('#carou_offer').delay(2000).effect('shake','slow');
            }
        });
    </script>
@endpush

