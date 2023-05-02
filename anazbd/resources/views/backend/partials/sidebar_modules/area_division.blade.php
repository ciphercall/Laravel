

{{--<li class="{{ strpos($routeName, 'backend.customer') === 0 ? 'active open' : ''}}">--}}
<li>
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-area-chart"></i>
        {{-- <i class="fa fa-area-chart" aria-hidden="true"></i> --}}
        <span class="menu-text">
                   Area-Division
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
{{--        <li class="{{ $routeName === 'backend.customer.index' ? 'open' : ''}}">--}}
        <li>
            <a href="{{ route('backend.area.index') }}">
                <i class="menu-icon fa fa-caret-right"></i>
                 Division
            </a>
            <b class="arrow"></b>
        </li>
        @can('manage_city_old_panel')
            <li>
                <a href="{{ route('backend.area.city.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    City
                </a>
                <b class="arrow"></b>
            </li>
        @endcan
        @can('manage_post_code_old_panel')
            <li>
                <a href="{{ route('backend.area.post_code.index') }}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Area
                </a>
                <b class="arrow"></b>
            </li> 
        @endcan

    </ul>

</li>

