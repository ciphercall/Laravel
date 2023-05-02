<li class="{{ strpos($routeName, 'seller.order') === 0 ? 'active open' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-shopping-cart"></i>
        <span class="menu-text">
           Order
        </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'seller.order.pending.') === 0 ? 'open' : ''}}">
            <a href="{{ route('seller.order.pending.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Pending
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'seller.order.delivered.') === 0 ? 'open' : ''}}">
            <a href="{{ route('seller.order.delivered.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Delivered
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'seller.order.cancelled.') === 0 ? 'open' : ''}}">
            <a href="{{ route('seller.order.cancelled.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Cancelled
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
