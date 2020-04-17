{{--<!-- Main Header -->--}}
<header class="main-header">

        <!-- Logo -->
        <a href="{{url(config('common.org.admin.prefix').'/admin')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>M</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ config('company.info.short_name') }}</b></span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">

                    <!-- Add Menu -->
                    <li class="dropdown tasks-menu add-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-plus"></i>
                        </a>
                        <ul class="dropdown-menu">

                            <li class="header _none">
                                <a href="{{url('/admin/module/create')}}">
                                    <i class="fa fa-plus text-green"></i> 添加模块
                                </a>
                            </li>

                            <li class="header">添加目录</li>
                            <li class="header">
                                <a href="{{url('/admin/menu/create')}}">
                                    <i class="fa fa-plus text-blue"></i> 添加目录
                                </a>
                            </li>

                            <li class="header">添加内容</li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=about')}}">
                                    <i class="fa fa-plus text-green"></i> 添加关于企业
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=advantage')}}">
                                    <i class="fa fa-plus text-green"></i> 添加选择我们
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=cooperation')}}">
                                    <i class="fa fa-plus text-green"></i> 添加合作伙伴
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=service')}}">
                                    <i class="fa fa-plus text-green"></i> 添加业务
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=product')}}">
                                    <i class="fa fa-plus text-green"></i> 添加产品
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=case')}}">
                                    <i class="fa fa-plus text-green"></i> 添加案例
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=faq')}}">
                                    <i class="fa fa-plus text-green"></i> 添加常见问题
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=coverage')}}">
                                    <i class="fa fa-plus text-green"></i> 添加资讯
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url('/admin/item/create?category=activity')}}">
                                    <i class="fa fa-plus text-green"></i> 添加活动
                                </a>
                            </li>

                            <li class="header">
                                <a href="{{url('/admin/item/create?category=client')}}">
                                    <i class="fa fa-plus text-green"></i> 添加客户
                                </a>
                            </li>

                            <li class="footer"><a href="javascript:void(0);">...</a></li>
                        </ul>
                    </li>

                    <!-- Messages: style can be found in dropdown.less-->
                    <li class="dropdown messages-menu" style="display:none;">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope-o"></i>
                            <span class="label label-success">4</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 4 messages</li>
                            <li>
                                <!-- inner menu: contains the messages -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <!-- User Image -->
                                                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                            </div>
                                            <!-- Message title and timestamp -->
                                            <h4>
                                                Support Team
                                                <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                            </h4>
                                            <!-- The message -->
                                            <p>Why not buy a new awesome theme?</p>
                                        </a>
                                    </li>
                                    <!-- end message -->
                                </ul>
                                <!-- /.menu -->
                            </li>
                            <li class="footer"><a href="#">See All Messages</a></li>
                        </ul>
                    </li>

                    <!-- Notifications Menu -->
                    <li class="dropdown notifications-menu" style="display:none;">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-bell-o"></i>
                            <span class="label label-warning">10</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 10 notifications</li>
                            <li>
                                <!-- Inner Menu: contains the notifications -->
                                <ul class="menu">
                                    <li><!-- start notification -->
                                        <a href="#">
                                            <i class="fa fa-users text-aqua"></i> 5 new members joined today
                                        </a>
                                    </li>
                                    <!-- end notification -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">View all</a></li>
                        </ul>
                    </li>

                    <!-- Tasks Menu -->
                    <li class="dropdown tasks-menu" style="display:none;">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag-o"></i>
                            <span class="label label-danger">9</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have 9 tasks</li>
                            <li>
                                <!-- Inner menu: contains the tasks -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <!-- Task title and progress text -->
                                            <h3>
                                                Design some buttons
                                                <small class="pull-right">20%</small>
                                            </h3>
                                            <!-- The progress bar -->
                                            <div class="progress xs">
                                                <!-- Change the css width attribute to simulate progress -->
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">20% Complete</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">View all tasks</a>
                            </li>
                        </ul>
                    </li>

                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            @if(Auth::guard('admin')->user()->portrait_img)
                                <img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.Auth::guard('admin')->user()->portrait_img)}}" class="user-image" alt="User Image">
                            @else
                                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::guard('admin')->user()->nickname}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if(Auth::guard('admin')->user()->portrait_img)
                                    <img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.Auth::guard('admin')->user()->portrait_img)}}" class="img-circle" alt="User Image">
                                @else
                                    <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                @endif

                                <p>
                                    {{Auth::guard('admin')->user()->nickname}} - 管理员
                                    <small>Member since Nov. 2012</small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <div class="row">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </div>
                                <!-- /.row -->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="{{url(config('common.org.admin.prefix').'/admin/administrator/index')}}" class="btn btn-default btn-flat">个人资料</a>
                                </div>
                                <div class="pull-right">
                                    <a href="{{url(config('common.org.admin.prefix').'/admin/logout')}}" class="btn btn-default btn-flat">退出</a>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- Control Sidebar Toggle Button -->
                    <li style="display:none;">
                        <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>