     {{-- Site Config [Site info, about-us,Banner, Slider] --}}
        <li class="{{ strpos($routeName, 'backend.site_config') === 0 ? 'active open' : ''}}">
            <a href="#" class="dropdown-toggle">
                <i class="menu-icon fa fa-gear"></i>
                <span class="menu-text">
                    Site Config
                </span>
                <b class="arrow fa fa-angle-down"></b>
            </a>
            <b class="arrow"></b>

            @can('manage_banner_old_panel')
                <ul class="submenu">
                    <li class="{{ $routeName === 'backend.site_config.banner' ? 'open' : ''}}">
                        <a href="{{route('backend.site_config.banner.index')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                        Banner
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            @endcan

            @can('manage_slider_old_panel')
                <ul class="submenu">
                    <li class="{{ $routeName === 'backend.site_config.slider' ? 'open' : ''}}">
                        <a href="{{route('backend.site_config.slider.index')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                        Slider
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            @endcan

            @can('manage_offer_old_panel')
                <ul class="submenu">
                    <li class="{{ $routeName === 'backend.site_config.offer' ? 'open' : ''}}">
                        <a href="{{route('backend.site_config.offer.index')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                        Offer
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            @endcan

            @can('manage_quick_page_old_panel')
                <ul class="submenu">
                    <li class="{{ $routeName === 'backend.site_config.quick-page' ? 'open' : ''}}">
                        <a href="{{route('backend.site_config.quick.page.index')}}">
                            <i class="menu-icon fa fa-caret-right"></i>
                        Quick Page
                        </a>
                        <b class="arrow"></b>
                    </li>
                </ul>
            @endcan


            <ul class="submenu">
                <li class="{{ $routeName === 'backend.site_config.info' ? 'open' : ''}}">
                    <a href="{{route('backend.site_config.info')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        Information
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>
            <ul class="submenu">
                <li class="{{ $routeName === 'backend.site_config.info' ? 'open' : ''}}">
                    <a href="{{route('backend.site_config.keyword')}}">
                        <i class="menu-icon fa fa-caret-right"></i>
                        SEO key Word
                    </a>
                    <b class="arrow"></b>
                </li>
            </ul>



        </li>
