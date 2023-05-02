<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">

        <div class="navbar-header pull-left">
            <a href="{{ route('backend.dashboard.index') }}" class="navbar-brand">
                <small class="text-primary font-weight-bold" style="font-weight: 600">
                    <span class="white">
                        <i class="fa fa-flag"></i> <span>Admin Panel</span>
{{--                        {{ $info->name }}--}}
                    </span>
                </small>
            </a>
        </div>

        <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
            <span class="sr-only">Toggle sidebar</span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>

            <span class="icon-bar"></span>
        </button>
        <div class="navbar-buttons navbar-header" style="float: right !important;" role="navigation">
            <ul class="nav ace-nav" style="border-top-width: 0;">

                <li class="light-blue dropdown-modal">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{asset(auth()->user()->image)}}" alt="{{auth()->user()->name}}">
                        <span class="user-info">
                                    <small>Welcome,</small>
                                    {{auth()->user()->name}}
                                </span>
                        <i class="ace-icon fa fa-caret-down"></i>
                    </a>

                    <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-cog"></i>
                                Settings
                            </a>
                        </li>

                        <li>
                            <a href="#">
                                <i class="ace-icon fa fa-user"></i>
                                Profile
                            </a>
                        </li>

                        <li class="divider"></li>

                        <li>
                            <a href="#logout" onclick="$('#logout').submit();">
                                <i class="ace-icon fa fa-power-off"></i>
                                Logout
                            </a>
                            <form id="logout" action="{{route('backend.logout')}}" method="post">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
