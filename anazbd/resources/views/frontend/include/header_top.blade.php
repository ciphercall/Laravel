<div class="main_header header_four m-0">
    <div class="container" style="margin: 0;max-width: 100%;padding-top: 0;">
        <!--header top start-->
        <div class="header_top">
            <div class="row align-items-center" style="background-color: whitesmoke">
                <div class="col-lg-4 col-md-5">
                </div>
                <div class="col-lg-8 col-md-7">
                    <div class="header_top_settings text-right">
                        <ul>
                            <!-- <li><a href="#">SAVE MORE ON APP</a></li> -->
                            <li><a href="{{url('/jobs')}}">Career with AnazBD</a></li>
                            <li><a href="{{route('seller.register.form')}}">SELL ON ANAZ</a></li>
                            <li>
                                <div class="dropdown">
                                    <span class="">CUSTOMER CARE</span>
                                    <div class="dropdown-content">
                                        @forelse(collect($quickpages ?? '')->where('section',1) as $quickpage)
                                                <a href="{{ route('frontend.quickpage',$quickpage->slug) }}">{{ $quickpage->name }}</a>
                                            @empty
                                        @endforelse
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="dropdown">
                                    <span class="">Track MY Order</span>
                                    <div class="dropdown-content new-style">
                                        <form action="{{ route('tracking') }}" method="POST">
                                            @csrf
                                            <strong style="
                                                        font-weight: 500;
                                                        color: #28a745;
                                                    ">Track My Order
                                            </strong>
                                            <label for="gmail">Please Confirm Your Gmail/Mobile </label><br>
                                            <input class="input_1" type="text" name="user" id="gmail"><br>
                                            @if($errors->first('user'))
                                                <span style="color: red">{{ $errors->first('user') }}</span><br>
                                            @endif
                                            <span>Your Order Number</span><br>
                                            <input class="input_2" type='text' name="order_id"><br>
                                            @if($errors->first('order_id'))
                                                <span style="color: red">{{ $errors->first('order_id') }}</span><br>
                                            @endif
                                            <button class="btn btn-sm btn-success" style="position: relative;top: 11px;">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                            @guest('web')
                                <li><a href="{{ url('login') }}">LOGIN/SIGNUP</a></li>
{{--                                <li><a href="{{ url('register') }}">SIGN UP</a></li>--}}
                            @endguest
                            @auth('web')
                                <li><a href="{{ url('account')}}">MY ACCOUNT</a></li>
                                <li><a id="logOutOpt" href="#" onclick="event.preventDefault(); $('#logout').submit()">LOG OUT</a></li>
                            @endauth
                            <li><a href="#">ভাষা</a></li>
                        </ul>
                        <form id="logout" action="{{url('logout')}}" method="post">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--header top start-->

        <!--header middel start-->
        <div class="header_middle header_middle_style4">
            <div class="row align-items-center">
                <div class="column1 col-lg-3 col-md-3 col-4">
                    <div class="logo categories_title active">
                        <a href="{{ url('/') }}" class="categori_toggle ">
                            <img src="{{ asset('frontend') }}/assets/anazlogo.png" alt="anazlogo.png">
                        </a>
                    </div>
                </div>
                <div class="column2 col-lg-6 col-md-12">
                    <div class="search_container">
                        <form action="{{route('search')}}">
                            <div class="search_box">
                                <input id="searchbox" placeholder="Search product..." name="search" type="text" required>
                                <button type="submit"><i class="fa fa-search" aria-hidden="true"
                                                         style="font-size: 20px"></i></button>
                            </div>
                        </form>
                        <div class="container-fluid" id="searchRes" style="display: none; border: 1px solid darkgrey; border-radius: 1px 1px 10px 10px;position: absolute;z-index: 2;background-color: rgba(255,255,255,0.9);width: 94.9%;">

                        </div>
                    </div>
                </div>
                <div class="column3 col-lg-3 col-md-7 col-6">
                    <div class="header_configure_area header_configure_four">
                        @php
                            if (Auth::check()) {
                                $wishlist = App\Models\Wishlist::where('user_id',Auth::id('web'))->count();
                            }
                        @endphp
                        <div class="header_wishlist">
                            <a href="{{ route('user.wishlist')}}"><i class="ion-android-favorite-outline"></i>
                                @if(session()->has('wish.count'))
                                    <span class="wishlist_count" id="wishtlistCount">{{ session()->get('wish.count') }}</span>
                                @else
                                    <span class="wishlist_count" id="wishtlistCount">{{ $wishlist??' ' }}</span>
                                @endif

                            </a>
                        </div>

                        <div class="mini_cart_wrapper">
                            <a href="{{route('frontend.cart.index')}}">
                                <i class="fa fa-cart-arrow-down"></i>
                                <span
                                    class="cart_count">{{ session()->has('cart') ? session()->get('cart')->cart_items->count() : '0' }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--header middel start-->
        <div class="header_middle sticky_header_four sticky-header">
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-6">
                    <div class="logo">
                        <a href="{{ url('/')}}">
                            <img src="{{ asset('frontend') }}/assets/anazlogo.png" alt="anazlogo.png">
                        </a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="main_menu menu_position">
                        <div class="search_container">
                            <form action="{{route('search')}}">
                                <div class="search_box">
                                    <input id="searchboxSticky" placeholder="Search product..." name="search" type="text" required>
                                    <button type="submit"><i class="fa fa-search" aria-hidden="true"
                                                             style="font-size: 20px"></i></button>
                                </div>
                            </form>
                            <div class="container-fluid" id="searchResSticky" style="display: none; border: 1px solid darkgrey; border-radius: 1px 1px 10px 10px;position: absolute;z-index: 2;background-color: rgba(255,255,255,0.9);">
                                {{--  <div class="row">
                                    <div class="col-12">
                                        <p id="searchResSticky1">This is a test result! bla bla bla...</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p id="searchResSticky2">This is a test result! bla bla bla...</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p id="searchResSticky3">This is a test result! bla bla bla...</p>
                                    </div>
                                </div>
                                <br>  --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="header_configure_area">
                    <div class="header_configure_area header_configure_four">
                        <div class="header_wishlist">
                            <a href="{{ route('user.wishlist')}}"><i class="ion-android-favorite-outline"></i>
                                @if(session()->has('wish.count'))
                                    <span class="wishlist_count" id="wishtlistCount">{{ session()->get('wish.count') }}</span>
                                @else
                                    <span class="wishlist_count" id="wishtlistCount">{{ $wishlist??' ' }}</span>
                                @endif

                            </a>
                        </div>

                        <div class="mini_cart_wrapper">
                            <a href="{{route('frontend.cart.index')}}">
                                <i class="fa fa-cart-arrow-down"></i>
                                <span
                                    class="cart_count">{{ session()->has('cart') ? session()->get('cart')->cart_items->count() : '0' }}</span>
                            </a>
                        </div>
                    </div>

                    </div>
                </div>
            </div>
        </div>
        <!--header middel end-->


        <!--header bottom satrt-->

            <style>
                .categories{
                    position: relative;
                }

                .menu {
                    padding: 13px 0 7px;
                    /* border: 2px solid #c40316; */
                    background: #fff;
                    position: absolute;
                    width: 100%;
                    top: 140%;
                    z-index: 9;
                }
                .sub-menu{
                    padding: 13px 0 7px;
                    /* border: 2px solid #c40316; */
                    background: #fff;
                    position: relative;
                    width: 100%;
                }
                .menu ul{
                    padding-left: 10px;

                }

                .menu ul ul{
                    position: absolute;
                    visibility: hidden;
                    opacity: 0;
                    left: 100%;
                    transition: all 0.3s;
                    width: 300px;
                }
                .menu ul li:hover > ul {
                    visibility: visible;
                    opacity: 1;
                }
                .menu ul li a:hover{
                    color: orange;
                }
                .menu ul li a{
                    font-size: 14px;
                    line-height: 26px;
                    text-transform: capitalize;
                    font-weight: 400;
                    display: block;
                    cursor: pointer;
                    padding: 0 20px 0 30px;
                }
                .menu ul li a i.fa-angle-right{
                    float: right;
                    font-size: 15px;
                    margin-top: 2%;
                    -o-transition: .3s;
                    transition: .3s;
                    -webkit-transition: .3s;
                }
            </style>

        @if(request()->path() == '/')
        <div class="header_bottom">
            <div class="row align-items-center">
                <div class="column1 col-lg-3 col-md-6">
                    <div class="categories">
                        <div class="menu" style="background: rgba(255,255,255,0.8);">
                            <ul>
                                @foreach(collect($categories) as $category)
                                    @if(collect($category->sub_categories)->count())
                                        <li>
                                            <a href="{{ route('frontend.category',$category->slug) }}">{{ $category->name }}
                                                <i class="fa fa-angle-right"></i></a>
                                                <ul class="sub-menu" style="background: rgba(255,255,255,0.8);">
                                                    @foreach(collect($category->sub_categories) as $sub_category)
                                                        @if(collect($sub_category->child_categories)->count())
                                                            <li class=""><a
                                                                    href="{{route('frontend.sub_category',$sub_category->slug)}}"">{{$sub_category->name}}<i class="fa fa-angle-right"></i></a>
                                                                <ul class="sub-menu" style="background: rgba(255,255,255,0.8);">
                                                                    @foreach(collect($sub_category->child_categories) as $child_category)
                                                                        <li>
                                                                            <a href="{{route('frontend.child_category', $child_category->slug)}}">{{$child_category->name}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <li class=""><a
                                                                    href="{{route('frontend.sub_category', $sub_category->slug)}}">{{$sub_category->name}}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- <div class="header_bottom">
                <div class="row align-items-center">
                    <div class="column1 col-lg-3 col-md-6">
                        <div class="categories_menu categories_four">
                            <div class="categories_menu_toggle" @yield('active') >
                                <ul>
                                    {{-- @dd($categories) --}}
                                    @foreach(collect($categories) as $category)

                                        @if(collect($category->sub_categories)->count())
                                            <li class="menu_item_children">
                                                <a href="{{route('frontend.category',$category->slug)}}">{{$category->name}}
                                                    <i class="fa fa-angle-right"></i></a>
                                                <ul class="categories_mega_menu" style="width: 1000px;">
                                                    @foreach(collect($category->sub_categories) as $sub_category)
                                                        @if(collect($sub_category->child_categories)->count())
                                                            <li class="menu_item_children" style="width:15%"><a
                                                                    href="{{route('frontend.sub_category',$sub_category->slug)}}" style="font-size: 15px;font-family: cursive;color: chocolate;">{{$sub_category->name}}</a>
                                                                <ul class="categorie_sub_menu">
                                                                    @foreach(collect($sub_category->child_categories) as $child_category)
                                                                        <li>
                                                                            <a href="{{route('frontend.child_category', $child_category->slug)}}">{{$child_category->name}}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                        @else
                                                            <li class=""><a
                                                                    href="{{route('frontend.sub_category', $sub_category->slug)}}">{{$sub_category->name}}</a>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li><a href="#">{{$category->name}}</a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
    @endif
    <!--header bottom end-->
    </div>
</div>
