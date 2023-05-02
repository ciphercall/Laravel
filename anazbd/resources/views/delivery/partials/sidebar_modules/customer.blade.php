  
        <li class="{{ strpos($routeName, 'backend.customer') === 0 ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-users"></i>
                <span class="menu-text">
                   Customer
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="{{ $routeName === 'backend.customer.index' ? 'open' : ''}}">
                    <a href="{{ route('backend.customer.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        All Customer
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
            
        </li>
