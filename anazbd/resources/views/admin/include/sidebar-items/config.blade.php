<li class="nav-item {{ (strpos($routeName, 'admin.site.setting') === 0 || strpos($routeName, 'admin.bankinfo') === 0 || strpos($routeName, 'backend.site_config') === 0 || strpos($routeName, 'admin.notification.index') === 0) ? 'active open' : ''}}">
    <a class="nav-link" href="#" id="config">
        <div class="row">
            <div class="col-2"><i class="material-icons">settings</i>
            </div>
            <div class="col-7"><p>Site Configurations</p>
            </div>
            <div class="col-3"><i id="config_arrow" class="fas fa-arrow-circle-down"></i></div>
        </div>
    </a>
    <ul class="nav" id="config_child"
        style="display: {{ (strpos($routeName, 'admin.site.setting.index') === 0 || strpos($routeName, 'admin.bankinfo') === 0 || strpos($routeName, 'backend.site_config') === 0 || strpos($routeName, 'admin.notification.index') === 0) ? 'block' : 'none'}};">
        <li class="nav-item {{ strpos($routeName, 'admin.site.setting.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.site.setting.index')}}">
                <i class="material-icons">engineering</i>
                <p>Settings</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.bankinfo.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.bankinfo.index')}}">
                <i class="material-icons">account_balance</i>
                <p>Banks</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.notification.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.notification.index')}}">
                <i class="material-icons">notifications</i>
                <p>Push Notification</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'backend.site_config.slider.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.site_config.slider.index')}}">
                <i class="material-icons">slideshow</i>
                <p>Slider</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'backend.site_config.banner.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.site_config.banner.index')}}">
                <i class="material-icons">wallpaper</i>
                <p>Banner</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'backend.site_config.offer.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.site_config.offer.index')}}">
                <i class="material-icons">collections</i>
                <p>Offers Image</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'backend.site_config.quick.page') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.site_config.quick.page.index')}}">
                <i class="material-icons">web</i>
                <p>Quick Page</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'backend.site_config.info') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.site_config.info')}}">
                <i class="material-icons">info</i>
                <p>Information</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'backend.site_config.keyword') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.site_config.keyword')}}">
                <i class="material-icons">tag</i>
                <p>SEO Key Word</p>
            </a>
        </li>
    </ul>
</li>
@can('view_jobs')
<li class="nav-item {{ strpos($routeName, 'jobs.index') === 0 ? 'active open' : ''}}">
    <a class="nav-link" href="{{route('jobs.index')}}">
        <i class="material-icons">work</i>
        <p>Job Openings</p>
    </a>
</li>
@endcan
<li class="nav-item {{ strpos($routeName, 'admin.self-order.pending.index') === 0 ? 'active open' : ''}}">
    <a class="nav-link" href="{{route('admin.self-order.pending.index')}}">
        <i class="fas fa-th-list"></i>
        <p>Self-Order list</p>
    </a>
</li>
