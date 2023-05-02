
        <li class="{{ strpos($routeName, 'backend.admin') === 0 ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-user-md"></i>
                <span class="menu-text">
                   Admin
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="{{ $routeName === 'backend.admin.index' ? 'open' : ''}}">
                    <a href="{{ route('backend.admin.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        All Admin
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>

        </li>
