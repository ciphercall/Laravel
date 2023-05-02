
        <li class="{{ strpos($routeName, 'backend.comment') === 0 ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-user-plus"></i>
                <span class="menu-text">
                   Comment
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>
            <ul class="submenu">
                <li class="{{ $routeName === 'backend.comment.unpublished' ? 'open' : ''}}">
                    <a href="{{ route('backend.comment.unpublished') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Unpublished Comment
                    </a>
                    <b class="arrow"></b>
                </li>

                 <li class="{{ $routeName === 'backend.comment.published' ? 'open' : ''}}">
                    <a href="{{ route('backend.comment.published') }}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Published Comment
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
        </li>
