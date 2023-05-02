
<li class="{{ strpos($routeName, 'backend.campaign.') === 0 ? 'active open' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-flash"></i>
        <span class="menu-text">
                   Campaign
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        {{--  <li class="{{ strpos($routeName, 'backend.campaign.coupons.') === 0 ? 'open active' : ''}}">
            <a href="{{ route('backend.campaign.coupons.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                <span class="menu-text">Coupons</span>
            </a>
            <b class="arrow"></b>
        </li>  --}}
        @can('manage_flash_sale_old_panel')
            <li class="{{ strpos($routeName, 'backend.campaign.flash_sale.') === 0 ? 'open' : ''}}">
                <a href="{{ route('backend.campaign.flash_sale.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Flash Sale
                </a>
                <b class="arrow"></b>
            </li>
        @endcan
        
    </ul>

</li>
