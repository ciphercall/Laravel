<li class="nav-item {{ (strpos($routeName, 'admin.product') === 0 || strpos($routeName, 'backend.product') === 0) ? 'active open' : ''}}">
    <a class="nav-link" href="#" id="products">
        <div class="row">
            <div class="col-2">            <i class="material-icons">category</i>
            </div>
            <div class="col-7">            <p>Products</p>
            </div>
            <div class="col-3"><i id="coupon_arrow" class="fas fa-arrow-circle-down"></i></div>
        </div>
    </a>
    <ul class="nav" id="products_child" style="display: {{ (strpos($routeName, 'admin.product') === 0 || strpos($routeName, 'backend.product') === 0) ? 'block' : 'none'}};">
            <li class="nav-item {{ strpos($routeName, 'admin.product.item.index') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.product.item.index')}}">
                    <i class="material-icons">unarchive</i>
                    <p>All Items</p>
                </a>
            </li>
        @can('export_products')
            <li class="nav-item {{ strpos($routeName, 'admin.product.item.export') === 0 ? 'active open' : ''}}">
                <a class="nav-link" href="{{route('admin.product.item.export')}}">
                    <i class="material-icons">file_download</i>
                    <p>Export Items</p>
                </a>
            </li>
        @endcan
        <li class="nav-item {{ strpos($routeName, 'backend.product.tags.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.tags.index')}}">
                <i class="material-icons">tag</i>
                <p>Tags</p>
            </a>
        </li>
        @can('manage_color')
        <li class="nav-item {{ strpos($routeName, 'backend.product.colors.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.colors.index')}}">
                <i class="material-icons">palette</i>
                <p>Colors</p>
            </a>
        </li>
        @endcan
        @can('manage_size')
        <li class="nav-item {{ strpos($routeName, 'backend.product.sizes.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.sizes.index')}}">
                <i class="material-icons">linear_scale</i>
                <p>Sizes</p>
            </a>
        </li>
        @endcan
        @can('manage_unit')
        <li class="nav-item {{ strpos($routeName,'backend.product.units.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.units.index')}}">
                <i class="material-icons">straighten</i>
                <p>Units</p>
            </a>
        </li>
        @endcan
        @can('manage_brand')
        <li class="nav-item {{ strpos($routeName, 'backend.product.brands.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.brands.index')}}">
                <i class="material-icons">bolt</i>
                <p>Brands</p>
            </a>
        </li>
        @endcan
        @can('manage_origin')
        <li class="nav-item {{ strpos($routeName, 'backend.product.origins.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.origins.index')}}">
                <i class="material-icons">public</i>
                <p>Origins</p>
            </a>
        </li>
        @endcan
        @can('manage_collection')
        <li class="nav-item {{ strpos($routeName, 'backend.product.collections.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.collections.index')}}">
                <i class="material-icons">library_books</i>
                <p>Collections</p>
            </a>
        </li>
        @endcan
        @can('manage_category')
        <li class="nav-item {{ strpos($routeName, 'backend.product.categories.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.categories.index')}}">
                <i class="material-icons">table_rows</i>
                <p>Categories</p>
            </a>
        </li>
        @endcan
        @can('manage_sub_category')
        <li class="nav-item {{ strpos($routeName, 'backend.product.sub_categories.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.sub_categories.index')}}">
                <i class="material-icons">grid_3x3</i>
                <p>Sub Categories</p>
            </a>
        </li>
        @endcan
        @can('manage_child_category')
        <li class="nav-item {{ strpos($routeName, 'backend.product.child_categories.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.child_categories.index')}}">
                <i class="material-icons">grid_4x4</i>
                <p>Child Categories</p>
            </a>
        </li>
        @endcan
        @can('manage_warranty_type')
        <li class="nav-item {{ strpos($routeName, 'backend.product.warranty-types.index') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('backend.product.warranty-types.index')}}">
                <i class="material-icons">local_police</i>
                <p>Warranty Type</p>
            </a>
        </li>
        @endcan
    </ul>
</li>

