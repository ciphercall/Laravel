<li class="{{ strpos($routeName, 'seller.campaign.') === 0 ? 'open active' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-flash"></i>
        <span class="menu-text">
                    Campaign
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'seller.campaign.flash_sale.') === 0 ? 'open' : ''}}">
            <a href="{{route('seller.campaign.flash_sale.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Flash Sale
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
