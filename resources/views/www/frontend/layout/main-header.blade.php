{{--<!-- Main Header -->--}}
<header class="main-header">

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0;background-color:#1a2226;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle visible-xs _none" data-toggle="offcanvas" role="button" style="padding:18px 16px;">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu" style="height:50px;line-height:50px;margin-left:8px;float:left;">
            <a href="{{ url('/') }}">
                <span class="logo-big hidden-xs">
                    <img src="{{ asset('/resource/custom/www/frontend/images/logo-white-transparent-64.png') }}" class="img-icon" alt="Image">
                    <span class="hidden-xs">首页</span>
                </span>
                <span class="logo-big visible-xs">
                    <img src="{{ asset('/resource/custom/www/frontend/images/logo-white-transparent-64.png') }}" class="img-icon" alt="Image">
                    <span class="header-text" style="">首页</span>
                </span>
            </a>
        </div>



        {{--<div class="header-logo" >--}}
            {{--<span class="logo-lg"><b>@yield('header_title')</b></span>--}}
        {{--</div>--}}


        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

            @if(!$auth_check)
            <div class="navbar-custom-menu" style="height:50px;line-height:50px;padding:0 8px;float:left;">
                <a href="{{ url('/login-link') }}">
                    <i class="fa fa-sign-in"></i>
                    <span>登录</span>
                </a>
            </div>
            @endif

            <ul class="nav navbar-nav hidden-xs- hidden-sm-">


                @if($auth_check)
                    <li class="">
                        <a  href="{{ url('/item/item-create') }}" data-type="notification">
                            <i class="fa fa-plus"></i>
                        </a>
                    </li>
                    <li class="">
                        <a  href="{{ url('/my-notification') }}" data-type="notification">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">@if(!empty($notification_count)){{ $notification_count or '' }}@endif</span>
                        </a>
                    </li>
                @endif


                @if($auth_check)
                @if(!empty($notification_count))
                <li class="_none">
                    <a href="{{ url('/my-notification') }}" data-type="notification">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success">@if(!empty($notification_count)){{ $notification_count or '' }}@endif</span>
                    </a>
                </li>
                @endif
                @endif

                {{--<!-- Notifications Menu -->--}}
                <li class="dropdown notifications-menu _none">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-list" style="width:16px;"></i>
                        {{--<span class="label label-warning">10</span>--}}
                    </a>
                    <ul class="dropdown-menu">
                        {{--<li class="header">You have 10 notifications</li>--}}
                        <li>
                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">
                                @if($auth_check)
                                    <li>
                                        <a href="{{ url('/home') }}">
                                            <i class="fa fa-home text-default" style="width:16px;"></i>
                                            <span>{{ $me->username }}</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/logout') }}">
                                            <i class="fa fa-sign-out text-default" style="width:16px;"></i>
                                            <span>退出</span>
                                        </a>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ url('/login-link') }}">
                                            <i class="fa fa-sign-in"></i>
                                            <span>登录</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                        {{--<li class="footer"><a href="#">View all</a></li>--}}
                    </ul>
                </li>

                {{--<!-- User Account Menu -->--}}
                @if($auth_check)
                <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ url(env('DOMAIN_CDN').'/'.$me->portrait_img) }}" class="user-image" alt="User">
                            <span class=""><span> &nbsp; </span></span>
                            <span class="hidden-xs pull-right"><span>{{ $me->username }}</span></span>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.$me->portrait_img) }}" class="img-circle" alt="User">
                                    <p>
                                        {{ $me->username }}
                                        <small>{{ $me->company }}</small>
                                        <small>{{ $me->position }}</small>
                                    </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-6 text-center">
                                        <a href="{{ url('/user/'.$me->id) }}">
                                            <i class="fa fa-user text-red"></i> 我的名片
                                        </a>
                                    </div>
                                    <div class="col-xs-6 text-center">
                                        <a href="{{ url('/my-cards') }}">
                                            <i class="fa fa-list-alt text-red"></i> 名片夹
                                        </a>
                                    </div>
                                    <div class="col-xs-6 text-center _none">
                                        <a href="{{ url('/my-favor') }}">
                                            <i class="fa fa-heart text-red"></i> 收藏
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                @if($me->user_type == 1)
                                <div class="pull-left">
                                    <a href="{{ url('/mine/my-card-edit') }}" class="btn btn-default btn-flat">
                                        <i class="fa fa-edit"></i>
                                        <span>编辑名片</span>
                                    </a>
                                </div>
                                @elseif($me->user_type == 11)
                                    <div class="pull-left">
                                        <a href="{{ url('/org') }}" class="btn btn-default btn-flat">
                                            <i class="fa fa-home"></i>
                                            <span>返回后台</span>
                                        </a>
                                    </div>
                                @elseif($me->user_type == 88)
                                    <div class="pull-left">
                                        <a href="{{ url('/sponsor') }}" class="btn btn-default btn-flat">
                                            <i class="fa fa-home"></i>
                                            <span>返回后台</span>
                                        </a>
                                    </div>
                                @endif
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">
                                        <i class="fa fa-sign-in"></i>
                                        <span>退出</span>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </li>
                    @endif


                <!-- Control Sidebar Toggle Button -->
                <li class="_none">
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
            </ul>

        </div>
    </nav>

</header>