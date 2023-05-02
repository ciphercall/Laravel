<li class="nav-item {{ strpos($routeName, 'admin.orders') === 0 ? 'active open' : ''}}">
    <a class="nav-link" href="#" id="orders">
        <div class="row">
            <div class="col-2">            <i class="material-icons">receipt</i>
            </div>
            <div class="col-7">            <p>Orders</p>
            </div>
            <div class="col-3"><i id="coupon_arrow" class="fas fa-arrow-circle-down"></i></div>
        </div>
    </a>
    <ul class="nav" id="orders_child" style="display: {{ strpos($routeName, 'admin.orders') === 0 ? 'block' : 'none'}};">
        <li class="nav-item {{ strpos($routeName, 'admin.orders.pending') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.pending.index')}}">
                <i class="material-icons">pending_actions</i>
                <p>Pending Orders</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.accepted') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.accepted.index')}}">
                <i class="material-icons">thumb_up_alt</i>
                <p>Accepted Orders</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.picked') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.picked.index')}}">
                <i class="material-icons">airport_shuttle</i>
                <p>Product Pickup</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.arrived') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.arrived.index')}}">
                <i class="material-icons">festival</i>
                <p>Product Arrived</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.qc') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.qc.index')}}">
                <i class="material-icons">verified</i>
                <p>Quality Control</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.in-packing') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.in-packing.index')}}">
                <i class="material-icons">inventory2</i>
                <p>In Packing</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.chalan') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.chalan.index')}}">
                <i class="material-icons">list_alt</i>
                <p>Invoice</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.on-delivery') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.on-delivery.index')}}">
                <i class="material-icons">local_shipping</i>
                <p>On Delivery</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.not-delivered') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.not-delivered.index')}}">
                <i class="material-icons">assignment_return</i>
                <p>Not Delivery</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.delivery-date-enhanced') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.delivery-date-enhanced.index')}}">
                <i class="material-icons">event</i>
                <p>Delivery Date Enhanced</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.delivered') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.delivered.index')}}">
                <i class="fa fa-box-open"></i>
                <p>Delivered</p>
            </a>
        </li>
        <li class="nav-item {{ strpos($routeName, 'admin.orders.cancelled') === 0 ? 'active open' : ''}}">
            <a class="nav-link" href="{{route('admin.orders.cancelled.index')}}">
                <i class="material-icons">cancel</i>
                <p>Cancelled</p>
            </a>
        </li>
    </ul>
</li>

