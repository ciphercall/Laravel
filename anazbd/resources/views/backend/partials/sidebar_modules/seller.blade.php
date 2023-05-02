
<li class="{{ strpos($routeName, 'backend.seller.') === 0 ? 'active open' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-users"></i>
        <span class="menu-text">
                   Seller
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">

        <li class="{{ $routeName === 'backend.seller.create' ? 'open' : ''}}">
            <a href="{{ route('backend.seller.create') }}">
                <i class="menu-icon fa fa-caret-right"></i>
               Add Seller
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ $routeName === 'backend.seller.index' ? 'open' : ''}}">
            <a href="{{ route('backend.seller.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                All Sellers
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'backend.seller.premium.') === 0 ? 'open' : ''}}">
            <a href="{{ route('backend.seller.premium.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Premium Sellers
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'backend.seller.anazmall.') === 0 ? 'open' : ''}}">
            <a href="{{ route('backend.seller.anazmall.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Anazmall Sellers
            </a>
            <b class="arrow"></b>
        </li>
    </ul>

</li>
