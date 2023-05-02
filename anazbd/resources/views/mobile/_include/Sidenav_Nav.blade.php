<style>
    .lni-chevron-down{
        position: relative;
        top: -11px;
    }
</style>

<ul class="sidenav-nav pl-0">
{{--    <li>--}}
{{--        @auth--}}
{{--            <a href="{{ url('account')}}"><i class="lni lni-user"></i>My Account</a>--}}
{{--        @else--}}
{{--            <a href="{{ url('/register')}}"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign Up</a>--}}
{{--            <a href="{{ url('/login') }}"><i class="lni lni-user"></i>Sign In</a>--}}
{{--        @endauth--}}

{{--    </li>--}}
{{--    <li>--}}
{{--        <a href="{{route('mobile.pages.cart')}}"><i class="lni lni-cart"></i>Cart--}}
{{--            <span class="ml-3 badge badge-warning"></span>--}}
{{--        </a>--}}
{{--    </li>--}}
{{--     @php--}}
{{--        if (Auth::check()) {--}}
{{--            $wishlist = App\Models\Wishlist::where('user_id',Auth::id('web'))->count();--}}
{{--        }--}}
{{--    @endphp--}}
{{--     <li>--}}
{{--        <a href="{{ route('user.wishlist')}}"><i class="lni lni-cart"></i>Wishlist--}}
{{--            @if(session()->has('wish.count'))--}}
{{--                <span class="ml-3 badge badge-warning">">{{ session()->get('wish.count') }}</span>--}}
{{--            @else--}}
{{--                <span class="ml-3 badge badge-warning">{{ $wishlist??' ' }}</span>--}}
{{--            @endif--}}
{{--        </a>--}}
{{--    </li>--}}

    @php
        $categories =   App\Models\Category::with([
                            'sub_categories' => function ($q) {
                                $q->with(['child_categories' => function ($r) {
                                    $r->select('id', 'subcategory_id', 'name', 'slug');
                                }])->select('id', 'category_id', 'name', 'slug');
                            }
                        ])
                        ->where('show_on_top', true)
                        //->take(10)
                        ->get(['id', 'name', 'slug', 'image']);
    @endphp
{{--    @foreach(collect($categories ?? null)->take(10) as $category)--}}
    <li class="suha-dropdown-menu" style="color: white">
        CATEGORIES
    <ul>
        @foreach(collect($categories ?? null) as $category)
            <li class="suha-dropdown-menu">
                <a href="{{route('frontend.category',$category->slug)}}"><i class="fa fa-tag" aria-hidden="true"></i>{{$category->name}}</a>
                @if(collect($category->sub_categories)->count())
                    <ul>
                        @foreach(collect($category->sub_categories) as $sub_category)
                            <li>
                                <a href="{{route('frontend.sub_category',$sub_category->slug)}}">-{{$sub_category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
    </li>

    <li>
        <a href="{{ route('mobile.blog') }}"><i class="fa fa-th" aria-hidden="true"></i>Blog</a>
    </li>
    <li>
        @auth
            <a href="" onclick="event.preventDefault(); $('#logout').submit()"><i class="lni lni-power-switch"></i>Sign Out</a>
        @endauth
    </li>
    <li>
        <div class="single-settings d-flex align-items-center justify-content-between">
            <div class="title"><i class="lni lni-night"></i><span class="text-white">Night Mode</span></div>
            <div class="data-content">
                <div class="toggle-button-cover">
                    <div class="button r">
                        <input class="checkbox" id="darkSwitch" type="checkbox">
                        <div class="knobs"></div>
                        <div class="layer"></div>
                    </div>
                </div>
            </div>
        </div>
    </li>


 </ul>
