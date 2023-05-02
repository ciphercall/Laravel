<li class="{{ strpos($routeName, 'seller.product') === 0 ? 'open active' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-sitemap"></i>
        <span class="menu-text">
                    Product
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'seller.product.items') === 0 ? 'open' : ''}}">
            <a href="{{route('seller.product.items.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Items
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
