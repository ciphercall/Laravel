<div id="sidebar" class="sidebar responsive ace-save-state menu-min">
    <script type="text/javascript">
        try {
            ace.settings.loadState('sidebar')
        } catch (e) {
        }
    </script>

    @php
        $routeName = request()->route()->getName();
    @endphp

    <ul class="nav nav-list">
        {{-- Dashboard --}}
        @include('delivery.partials.sidebar_modules.dashboard')

        {{-- Order --}}
        @include('delivery.partials.sidebar_modules.order')

        {{-- Transaction --}}
        @include('delivery.partials.sidebar_modules.transaction')

        {{-- Profile --}}
        {{-- @include('seller.partials.sidebar_modules.profile') --}}

        {{-- Product --}}
        {{-- @include('seller.partials.sidebar_modules.product') --}}

        {{-- Product --}}
        {{-- @include('seller.partials.sidebar_modules.campaign') --}}
    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
           data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
