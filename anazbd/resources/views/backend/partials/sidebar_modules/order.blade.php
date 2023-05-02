@php
    $class = '';

    if(strpos($routeName,'backend.order') === 0 || strpos($routeName,'backend.chalan') === 0){
        $class = 'open active';
    }
@endphp
<li class="{{ $class }}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-cart-arrow-down"></i>
        <span class="menu-text">
                    Order
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'backend.order.pending.') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.order.pending.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Pending
            </a>
            <b class="arrow"></b>
        </li>

        <li class="{{ strpos($routeName, 'backend.order.waiting.') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.order.waiting.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Waiting
            </a>
            <b class="arrow"></b>
        </li>
        @can('manage_invoice_old_panel')
            <li class="{{ strpos($routeName, 'backend.chalan.index') === 0 ? 'open' : ''}}">
                <a href="{{route('backend.chalan.index')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Chalan
                </a>
                <b class="arrow"></b>
            </li>
        @endcan
        <li class="{{ strpos($routeName, 'backend.order.on-delivery.') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.order.on-delivery.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                On Delivery
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'backend.order.not-delivered.') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.order.not-delivered.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Not Delivered
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'backend.order.delivered.') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.order.delivered.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Delivered
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'backend.order.cancelled.') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.order.cancelled.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Cancelled
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
<li class="{{ (strpos($routeName, 'backend.cart.index') === 0) || (strpos($routeName, 'backend.wishlist.index') === 0) ? 'open active' : '' }}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-shopping-cart"></i>
        <span class="menu-text">
                    Cart & Wishlist
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ $routeName === 'backend.cart.index' ? 'open' : ''}}">
            <a id="bk_cart_idx" href="{{ route('backend.cart.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                All Cart Items
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ $routeName === 'backend.wishlist.index' ? 'open' : ''}}">
            <a id="bk_wish_idx" href="{{ route('backend.wishlist.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                All Wishlist Items
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"--}}
{{--        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="--}}
{{--        crossorigin="anonymous"></script>--}}
{{--<script>--}}
{{--    $('#bk_cart_idx').on('click', function () {--}}
{{--        $.ajaxSetup({--}}
{{--            headers: {--}}
{{--                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--            }--}}
{{--        });--}}
{{--        $.post($('#bk_cart_idx').data('url'), {place: 'bk'}).done(function (res) {--}}
{{--            alert('hi');--}}
{{--        }).fail(function (xhr, status, error) {--}}

{{--        });--}}
{{--    });--}}
{{--</script>--}}
