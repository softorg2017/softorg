{{--<!-- Main Header -->--}}
<header class="main-header">

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation" style="margin-left:0;background-color:#1a2226;">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle visible-xs" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu" style="height:50px;line-height:50px;float:left;">
            <a href="{{ url('/') }}">
                <span class="logo-big hidden-xs">
                    <img src="/favicon_transparent.png" class="img-icon" alt="Image">
                    <b class="hidden-xs">朝鲜族组织平台</b>
                </span>
                <span class="logo-big visible-xs">
                    <img src="/favicon_transparent.png" class="img-icon" alt="Image">
                    <b class="">首页</b>
                </span>
            </a>
        </div>



        {{--<div class="header-logo" >--}}
            {{--<span class="logo-lg"><b>@yield('header_title')</b></span>--}}
        {{--</div>--}}


        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">

            @if(!Auth::check())
            <div class="navbar-custom-menu" style="height:50px;line-height:50px;padding:0 8px;float:left;">
                <a href="{{ url('/login-link') }}">
                    <i class="fa fa-sign-in"></i>
                    <span>登录</span>
                </a>
            </div>
            @endif

            <ul class="nav navbar-nav hidden-xs- hidden-sm-">


                @if(Auth::check())
                <li class="">
                    <a  href="{{ url('/my-notification') }}" data-type="notification">
                        <i class="fa fa-envelope-o"></i>

                        <span class="label label-success">@if(!empty($notification_count)){{ $notification_count or '' }}@endif</span>
                    </a>
                </li>
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
                                @if(Auth::check())
                                    <li>
                                        <a href="{{ url('/home') }}">
                                            <i class="fa fa-home text-default" style="width:16px;"></i>
                                            <span>{{ Auth::user()->username }}</span>
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
                @if(Auth::check())
                <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ url(env('DOMAIN_CDN').'/'.Auth::user()->portrait_img) }}" class="user-image" alt="User Image">
                            <span class="hidden-xs"><span>{{ Auth::user()->username }}</span></span>
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.Auth::user()->portrait_img) }}" class="img-circle" alt="User Image">
                                    <p>
                                        {{ Auth::user()->username }}
                                        <small>Member since Nov. 2020</small>
                                    </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="{{ url('/user/'.Auth::user()->id) }}">
                                            <i class="fa fa-home text-red"></i> 主页
                                        </a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="{{ url('/my-follow') }}">
                                            <i class="fa fa-user text-red"></i> 关注
                                        </a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="{{ url('/my-favor') }}">
                                            <i class="fa fa-heart text-red"></i> 收藏
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                @if(Auth::user()->user_type == 1)
                                <div class="pull-left">
                                    <a href="{{ url('/my-info/index') }}" class="btn btn-default btn-flat">
                                        <i class="fa fa-info"></i>
                                        <span>个人资料</span>
                                    </a>
                                </div>
                                @elseif(Auth::user()->user_type == 11)
                                    <div class="pull-left">
                                        <a href="{{ url('/org') }}" class="btn btn-default btn-flat">
                                            <i class="fa fa-home"></i>
                                            <span>返回后台</span>
                                        </a>
                                    </div>
                                @elseif(Auth::user()->user_type == 88)
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