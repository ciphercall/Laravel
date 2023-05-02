<li class="{{ strpos($routeName, 'delivery.order') === 0 ? 'active open' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-shopping-cart"></i>
        <span class="menu-text">
           Orders
        </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'delivery.orders.new-') === 0 ? 'open' : ''}}">
            <a href="{{ route('delivery.orders.new-index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                New
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'delivery.orders.on-delivery-') === 0 ? 'open' : ''}}">
            <a href="{{ route('delivery.orders.on-delivery-index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                On Delivery
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'delivery.orders.delivered-') === 0 ? 'open' : ''}}">
            <a href="{{ route('delivery.orders.delivered-index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Delivered
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
