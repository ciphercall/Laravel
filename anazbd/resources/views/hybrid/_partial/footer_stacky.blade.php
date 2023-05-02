<style>
    .column {
        border: aliceblue;
        border-radius: 50%;
        text-align: center;
    }

    @media screen and (min-width: 768px) and (max-width: 892px) {
        .btn-circle.btn-xl {
        !important;
            width: 110px;
            height: 110px;
            padding: 10px 16px;
            font-size: 24px;
            line-height: 1.33;
            border-radius: 60px;
        }

        img {
        !important;
            width: 68px;
            height: 68px;
        }

        p {
        !important;
            font-size: 97%;
        }

        .column {
        !important;
            border: aliceblue;
            border-radius: 25px;
            width: 20%;
            height: 60px;
            text-align: center;
        }
    }

    /*@media screen and (min-width: 920px) and (max-width: 1115px) {*/
    /*    .column {*/
    /*        width: 25%;*/
    /*    }*/
    /*}*/

    /*@media screen and (min-width: 720px) and (max-width: 919px) {*/
    /*    .column {*/
    /*        width: 33.33%;*/
    /*    }*/
    /*}*/

    /*@media screen and (min-width: 443px) and (max-width: 719px) {*/
    /*    .column {*/
    /*        width: 50%;*/
    /*    }*/
    /*}*/

    .btn-circle {
        width: 30px;
        height: 30px;
        text-align: center;
        padding: 6px 0;
        /*font-size: 12px;*/
        /*line-height: 1.428571429;*/
        border-radius: 15px;
    }

    .btn-circle.btn-xl {
        width: 61px;
        height: 61px;
        padding: 10px 16px;
        /*font-size: 24px;*/
        /*line-height: 1.33;*/
        border-radius: 40px;
    }

    p {
        margin: 1% 0 0 1%;
        font-size: 76%;
    }

    img {
        width: 35px;
        height: 35px;
    }

    .row.anaz-short-cateory {
        padding-top: 15px;
        margin: 2% 5% 9% 0%;
    }

    /*button click anim*/
    .Button {
        border-radius: 50%;
        width: 100px;
        height: 100px;
        border: none;
        background-color: transparent;
        font-size: 100px;
        color: lightseagreen;
        cursor: pointer;
        position: relative;
        transition-property: color, transform;
        transition-duration: 150ms;
        transition-timing-function: cubic-bezier(0.420, 0.000, 0.580, 1.000);
    }

    .Button:hover,
    .Button:focus {
        color: #FD6E8A;
    }

    .Button.is-toggled {
        color: #A2122F;
    }

    .Button-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .Button-icon--toggled {
        opacity: 0;
        color: #FD6E8A;
        transition: opacity 150ms cubic-bezier(0.420, 0.000, 0.580, 1.000);
    }

    .Button.is-toggled .Button-icon--toggled {
        opacity: 1;
    }

    .Button:focus {
        outline: none;
        transform: scale(0.92);
    }

    .Button::before,
    .Button::after {
        content: '';
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        border-radius: 50%;
        background-image:
            linear-gradient(to top   , rgba(255,255,255,0) 0%, currentColor 90%, rgba(255,255,255,0) 100%),
            linear-gradient(to right , rgba(255,255,255,0) 0%, currentColor 90%, rgba(255,255,255,0) 100%),
            linear-gradient(to bottom, rgba(255,255,255,0) 0%, currentColor 90%, rgba(255,255,255,0) 100%),
            linear-gradient(to left  , rgba(255,255,255,0) 0%, currentColor 90%, rgba(255,255,255,0) 100%);
        background-repeat:
            no-repeat,
            no-repeat,
            no-repeat,
            no-repeat;
        background-position:
            center top,
            right center,
            center bottom,
            left center;
        background-size:
            1px 20px,
            20px 1px,
            1px 20px,
            20px 1px;
        opacity: 0;
    }

    .Button::after {
        transform: rotate(45deg);
    }

    .Button.is-active::before {
        animation: explode1 400ms cubic-bezier(0.215, 0.610, 0.355, 1.000);
    }

    .Button.is-active::after {
        animation: explode2 400ms cubic-bezier(0.215, 0.610, 0.355, 1.000);
    }

    @keyframes explode1 {
        0%   { opacity: 1; transform: scale(0.6) }
        60%  { opacity: 0.8; }
        100% { opacity: 0; transform: scale(3.6) }
    }

    @keyframes explode2 {
        0%   { opacity: 1; transform: scale(0.6) rotate(45deg) }
        60%  { opacity: 0.8; }
        100% { opacity: 0; transform: scale(3.6) rotate(45deg) }
    }
    /*button click anim*/

</style>


<div class="footer-nav-area" id="footerNav">
    <a href="" class="btn btn btn-primary btn-circle btn-xl mt-3 Button js-button"
    style="
    box-shadow: 1px 3px grey;
    position: absolute;
    top: -56%;
    left: 42%;
    border: white;
    background-image: url(https://static.vecteezy.com/system/resources/thumbnails/001/313/973/small_2x/colorful-watercolor-rainbow-texture-free-vector.jpg);
    background-size: cover;
    ">
        <span>
            <img style="position: absolute;top: 14px;left: 16px;height: 29px;width: 30px;" src="{{ asset('mobile\img\icons\ficon.png') }}" alt="">
        </span>
    </a>

    <div class="container h-100 px-0">
        <div class="suha-footer-nav h-100">
            <ul class="h-100 d-flex align-items-center justify-content-between pl-0">
                <li class="active"><a href="{{ url('/') }}"><i class="lni lni-home"></i>Home</a></li>
                <li><a href="{{route('mobile.pages.cart')}}"><i class="lni lni-shopping-basket"></i>Cart <span
                            class="badge badge-danger cart_count">{{ session()->has('cart') ? session()->get('cart')->cart_items->count() : '0' }}</span></a>
                </li>


                {{--             <li><a href="message.html"><i class="lni lni-life-ring"></i>Support</a></li>--}}

                <li class="column col-auto">
                    {{--  <br>  --}}
                    {{--                <p><strong>Global Collection</strong></p>--}}
                </li>

                <li><a href="{{route('user.wishlist')}}"><i class="lni lni-heart"></i>Wishlist
                        @if(session()->has('wish.count'))
                            <span class="badge badge-danger wishlist_count" id="wishtlistCount">{{ session()->get('wish.count') }}</span>
                        @else
                            <span class="badge badge-danger wishlist_count" id="wishtlistCount">0</span>
                        @endif</a></li>
                <li>
                    @auth
                        <a href="{{ url('account')}}"><i class="lni lni-user"></i>My Account</a>
                    @else
                        <div class="col">
                            <div class="row">
                                {{--                            <div class="col"><a href="{{ url('/register')}}"><i class="fas fa-user-plus" aria-hidden="true"></i>Sign Up</a>--}}
                                {{--                            </div>--}}
                                <div class="col"><a href="{{ url('login') }}"><i class="lni lni-user"></i>Sign In</a>
                                </div>
                            </div>
                        </div>
                    @endauth

                </li>
            </ul>
        </div>
    </div>
</div>
<script>
    const btn = document.querySelector('.js-button')
    btn.addEventListener('click', (e) => {
        e.preventDefault()
        btn.classList.add('is-active')
        btn.classList.toggle('is-toggled')
        btn.blur()
        setTimeout(() => btn.classList.remove('is-active'), 400)

        location.replace('{{route('frontend.anazmall-seller.shops')}}');
    })

</script>
