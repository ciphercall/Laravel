<li class="nav-item {{ (strpos($routeName, 'admin.users') === 0) || (strpos($routeName, 'backend.seller') === 0) ||( strpos($routeName, 'admin.role') === 0) || (strpos($routeName, 'admin.permission') === 0) || (strpos($routeName, 'admin.role') === 0) || (strpos($routeName, 'admin.admin') === 0) || (strpos($routeName, 'backend.agent') === 0) ? 'active open' : ''}}">
    <a class="nav-link" href="#" id="coupon">
        <div class="row">
            <div class="col-2">            <i class="material-icons">person</i>
            </div>
            <div class="col-7">            <p>Users</p>
            </div>
            <div class="col-3"><i id="coupon_arrow" class="fas fa-arrow-circle-down"></i></div>
        </div>
    </a>
    <ul class="nav" id="coupon_child" style="display: {{ (strpos($routeName, 'admin.users') === 0) || (strpos($routeName, 'backend.seller') === 0) ||( strpos($routeName, 'admin.role') === 0) || (strpos($routeName, 'admin.permission') === 0) || (strpos($routeName, 'admin.role') === 0) || (strpos($routeName, 'admin.admin') === 0) || (strpos($routeName, 'backend.agent') === 0) ? 'block' : 'none'}}">
        @can('view_customers')
            <li class="nav-item {{ strpos($routeName, 'admin.users.customer') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.users.customers')}}">
                    <i class="material-icons">portrait</i>
                    <p>Customers</p>
                </a>
            </li>
        @endcan  
        @can('view_sellers')
            <li class="nav-item {{ (strpos($routeName, 'admin.users.seller') === 0) || (strpos($routeName, 'backend.seller') === 0) ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.users.sellers')}}">
                    <i class="material-icons">store</i>
                    <p>Sellers</p>
                </a>
            </li> 
        @endcan
          
        @can('manage_delivery_agents')
            <li class="nav-item {{ strpos($routeName, 'backend.agent') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('backend.agent.index')}}">
                    <i class="material-icons">local_shipping</i>
                    <p>Delivery Agents</p>
                </a>
            </li>
        @endcan
        
        @can('view_admins', Model::class)
            <li class="nav-item {{ strpos($routeName, 'admin.admin.index') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.admin.index')}}">
                    <i class="material-icons">local_police</i>
                    <p>Admins</p>
                </a>
            </li> 
        @endcan
        @can('view_roles', Model::class)
            <li class="nav-item {{ strpos($routeName, 'admin.role.index') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.role.index')}}">
                    <i class="material-icons">admin_panel_settings</i>
                    <p>Roles</p>
                </a>
            </li>
        @endcan
        @can('view_permissions', Model::class)
            <li class="nav-item {{ strpos($routeName, 'admin.permission.index') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.permission.index')}}">
                    <i class="material-icons">admin_panel_settings</i>
                    <p>Permissions</p>
                </a>
            </li>
        @endcan
      </ul>
  </li>
