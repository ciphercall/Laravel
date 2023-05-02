<li class="{{-- {{ strpos($routeName, 'backend.purchase.') === 0 ? 'open active' : ''}} --}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon glyphicon glyphicon-user"></i>
        <span class="menu-text">
            Seller-Info
        </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ strpos($routeName, 'seller.profile') === 0 ? 'open' : ''}}">
            <a href="{{route('seller.profile.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Profile
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ strpos($routeName, 'seller.profile') === 0 ? 'open' : ''}}">
            <a href="{{route('seller.profile.bank-info')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Bank Account
            </a>
            <b class="arrow"></b>
        </li>
        {{-- <li class="{{ strpos($routeName, 'backend.purchase.sources') === 0 ? 'open' : ''}}">
            <a href="{{route('backend.purchase.sources.index')}}">
                <i class="menu-icon fa fa-caret-right"></i>
                Sources
            </a>
            <b class="arrow"></b>
        </li> --}}
    </ul>
</li>
