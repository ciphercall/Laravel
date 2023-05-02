<li class="{{ strpos($routeName, 'backend.blog') === 0 ? 'active open' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-th-large"></i>
        <i class="fas fa-blog"></i>
        <span class="menu-text">
                   Blog
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        <li class="{{ $routeName === 'backend.blog.index' ? 'open' : ''}}">
            <a href="{{ route('backend.blog.create') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                Create New Blog
            </a>
            <b class="arrow"></b>
        </li>
        <li class="{{ $routeName === 'backend.blog.index' ? 'open' : ''}}">
            <a href="{{ route('backend.blog.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                All Blog
            </a>
            <b class="arrow"></b>
        </li>
    </ul>

</li>
