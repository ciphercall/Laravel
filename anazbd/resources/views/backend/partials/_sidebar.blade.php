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
        @include('backend.partials.sidebar_modules.dashboard')

        @can('manage_blog_old_panel')
            
        @endcan
                
        @can('update', Model::class)
            {{-- Order --}}
            @include('backend.partials.sidebar_modules.order') 
        @endcan

        {{-- Transaction --}}
        @include('backend.partials.sidebar_modules.transaction')

        {{-- Product --}}
        @include('backend.partials.sidebar_modules.product')

        @can('manage_econfig_old_panel')
            {{-- e_config --}}
            @include('backend.partials.sidebar_modules.e_config')
        @endcan

        @can('manage_sellers_old_panel')
            {{-- seller --}}
            @include('backend.partials.sidebar_modules.seller')
        @endcan

        {{-- seller --}}
        @include('backend.partials.sidebar_modules.question')

        @can('manage_agent_old_panel')
            {{-- agent --}}
            @include('backend.partials.sidebar_modules.agent')
        @endcan

        @can('manage_customer_old_panel')
            {{-- Customer --}}
            @include('backend.partials.sidebar_modules.customer')
        @endcan

        @can('manage_admin_old_panel')
            {{-- Admin --}}
            @include('backend.partials.sidebar_modules.admin')
        @endcan

        @can('manage_blog_old_panel')
            {{-- blog --}}
            @include('backend.partials.sidebar_modules.blog') 
        @endcan

        {{-- Campaign --}}
        @include('backend.partials.sidebar_modules.campaign')

        @can('manage_comment_old_panel')
            {{-- coommnet --}}
            @include('backend.partials.sidebar_modules.comment')
        @endcan



        @can('manage_social_old_panel')
            {{-- social link Config --}}
            @include('backend.partials.sidebar_modules.sociallink')
        @endcan

        @can('manage_site_config_old_panel')
            {{-- Site Config --}}
            @include('backend.partials.sidebar_modules.site_config')
        @endcan

        {{-- SMS & Email Config --}}
        @include('backend.partials.sidebar_modules.sms_email')

        {{-- @can('manage_area_division_old_panel') --}}
            {{-- area-division --}}
            @include('backend.partials.sidebar_modules.area_division')
        {{-- @endcan --}}

    </ul>

    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
        <i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state"
           data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>
</div>
