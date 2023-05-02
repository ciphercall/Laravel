<li class="{{ strpos($routeName, 'backend.transaction.') === 0 || strpos($routeName, 'backend.withdrawal.') === 0 ? 'open active' : ''}}">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-usd"></i>
        <span class="menu-text">
                    Transaction
                </span>
        <b class="arrow fa fa-angle-down"></b>
    </a>
    <b class="arrow"></b>
    <ul class="submenu">
        @can('view_transactions_old_panel')
            <li class="{{ $routeName == 'backend.transaction.index' ? 'open' : ''}}">
                <a href="{{route('backend.transaction.index')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    All Transactions
                </a>
                <b class="arrow"></b>
            </li>
        @endcan

        @can('manage_withdrawals_old_panel')
            <li class="{{ strpos($routeName, 'backend.withdrawal.') === 0 ? 'open' : ''}}">
                <a href="{{route('backend.withdrawal.index')}}">
                    <i class="menu-icon fa fa-caret-right"></i>
                    Withdraw Requests
                </a>
                <b class="arrow"></b>
            </li>
        @endcan

    </ul>
</li>
