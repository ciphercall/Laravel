<li class="nav-item {{ (strpos($routeName, 'backend.cart') === 0) || (strpos($routeName, 'backend.wishlist') === 0) ? 'active open' : ''}}">
    <a class="nav-link" href="#" id="cart_wishlist">
        <div class="row">
            <div class="col-2">            <i class="material-icons">category</i>
            </div>
            <div class="col-7">            <p>Cart & Wishlist</p>
            </div>
            <div class="col-3"><i id="coupon_arrow" class="fas fa-arrow-circle-down"></i></div>
        </div>
    </a>
    <ul class="nav" id="cart_wishlist_child" style="display:  none;">
        @can('view_cart')
            <li class="nav-item {{ strpos($routeName, 'backend.cart') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('backend.cart.index')}}">
                    <i class="material-icons">unarchive</i>
                    <p>All Cart Items</p>
                </a>
            </li>
        @endcan
        @can('view_wishlist')
            <li class="nav-item {{ strpos($routeName, 'backend.wishlist') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('backend.wishlist.index')}}">
                    <i class="material-icons">unarchive</i>
                    <p>All Wishlist Items</p>
                </a>
            </li>
        @endcan
        
    </ul>
</li>
