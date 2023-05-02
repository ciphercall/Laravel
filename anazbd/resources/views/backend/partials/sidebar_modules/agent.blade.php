
        <li class="{{ strpos($routeName, 'backend.agent') === 0 ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-user-md"></i>
                <span class="menu-text">
                   Agent
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="{{ $routeName === 'backend.agent.create' ? 'open' : ''}}">
                    <a href="{{ route('backend.agent.create') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Add Agent
                    </a>
                    <b class="arrow"></b>
                </li>
                <li class="{{ $routeName === 'backend.agent.index' ? 'open' : ''}}">
                    <a href="{{ route('backend.agent.index') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Agent List
                    </a>
                    <b class="arrow"></b>
                </li>

            </ul>

        </li>
