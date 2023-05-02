
        <li class="{{ strpos($routeName, 'backend.econfig') === 0 ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-cogs"></i>
                <span class="menu-text">
                   EConfig
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="{{ $routeName === 'backend.econfig.vat' ? 'open' : ''}}">
                    <a href="{{ route('backend.econfig.vat') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Vat List
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ $routeName === 'backend.econfig.commission' ? 'open' : ''}}">
                    <a href="{{ route('backend.econfig.commission') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                       Commission List
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ strpos($routeName, 'backend.econfig.delivery-size.') === 0 ? 'open' : ''}}">
                    <a href="{{ route('backend.econfig.delivery-size.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Delivery Size
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>

        </li>
