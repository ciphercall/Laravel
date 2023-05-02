<div id="navbar" class="navbar navbar-default ace-save-state">
    <div class="navbar-container ace-save-state" id="navbar-container">

        <div class="navbar-header pull-left">
            <a href="{{ route('delivery.dashboard.index_1') }}" class="navbar-brand">
                <small class="text-primary font-weight-bold" style="font-weight: 600">
                    <span class="white">
                        <i class="fa fa-flag"></i> <span>Delivery Panel</span>
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
                <li class="light-blue dropdown-modal" title="Notifications">
                    <a class="dropdown-toggle" href="{{route('delivery.orders.new-index')}}">
                        <i class="fa fa-2x fa-bell" style="margin-top: 10px;"></i>
                        <sup
                            style="color: white;font-size: 12px;margin-left: -16px;background-color: red;padding: 2px;border-radius: 50%;">
                            <b>
                                @php
                                    $count = \App\Models\AgentSuggestOrder::whereAuthAgent()->count();
                                @endphp
                                {{$count}}
                            </b>
                        </sup>
                    </a>

                    {{--                    <ul class="dropdown-menu-right dropdown-navbar navbar-default dropdown-menu dropdown-caret dropdown-close">--}}

                    {{--                        <li class="dropdown-content ace-scroll" style="position: relative;">--}}
                    {{--                            <div class="scroll-track" style="display: none;">--}}
                    {{--                                <div class="scroll-bar"></div>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="scroll-content" style="max-height: 200px;">--}}
                    {{--                                <ul class="dropdown-menu dropdown-navbar navbar-default">--}}

                    {{--                                    <li>--}}
                    {{--                                        <a href="">--}}
                    {{--                                            <div class="clearfix">--}}
                    {{--                                                <span class="pull-left dark">--}}
                    {{--                                                    New Orders--}}
                    {{--                                                </span>--}}
                    {{--                                                <span class="pull-right">--}}
                    {{--                                                    <span class="badge badge-danger"--}}
                    {{--                                                          style="border-radius: 50%;">--}}
                    {{--                                                        22--}}
                    {{--                                                    </span>--}}
                    {{--                                                </span>--}}
                    {{--                                            </div>--}}
                    {{--                                        </a>--}}
                    {{--                                    </li>--}}

                    {{--                                </ul>--}}
                    {{--                            </div>--}}
                    {{--                        </li>--}}

                    {{--                    </ul>--}}
                </li>

                <li class="light-blue dropdown-modal" style="border-left: 1px solid #438eb9">
                    <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                        <img class="nav-user-photo" src="{{asset(auth()->user()->image)}}" alt="">
                        <span class="user-info" style="margin-top: 8px">
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
                            <form id="logout" action="{{route('seller.logout')}}" method="post">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
