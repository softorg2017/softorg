<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/AdminLTE/bootstrap/css/bootstrap.min.css">
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
    <!-- Font Awesome -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">--}}
    <link href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">--}}
    <link href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <!-- Theme style -->
    <link rel="stylesheet" href="/AdminLTE/dist/css/AdminLTE.min.css">
    {{--<link href="https://cdn.bootcss.com/admin-lte/2.3.11/css/AdminLTE.min.css" rel="stylesheet">--}}
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="/AdminLTE/dist/css/skins/skin-blue.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    {{--<!--[if lt IE 9]>--}}
    {{--<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>--}}
    {{--<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>--}}
    {{--<![endif]-->--}}
    {{--<link href="https://cdn.bootcss.com/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css" rel="stylesheet">--}}

    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/css/fileinput.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('common/css/component/fileinput.css') }}" media="all" />

    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">

    <link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">

    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <link href="https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">

    <link href="https://cdn.bootcss.com/Swiper/4.2.2/css/swiper.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('common/css/common.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('common/css/frontend/index.css') }}" media="all" />
    <link rel="stylesheet" href="{{ asset('common/css/backend/index.css') }}" media="all" />

    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    <link rel="stylesheet" href="{{asset('css/admin/index.css')}}">

    @yield('style')

</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url(config('common.org.admin.prefix').'/admin')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>轻</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>Softorg</b></span>
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
                            <li class="header">
                                <a href="{{url(config('common.org.admin.prefix').'/admin/module/create')}}">
                                    <i class="fa fa-circle-o text-red"></i> 添加模块
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url(config('common.org.admin.prefix').'/admin/menu/create')}}">
                                    <i class="fa fa-circle-o text-red"></i> 添加目录
                                </a>
                            </li>
                            <li class="header">
                                <a href="{{url(config('common.org.admin.prefix').'/admin/item/create')}}">
                                    <i class="fa fa-circle-o text-red"></i> 添加内容
                                </a>
                            </li>

                            <li class="header _none">
                                <a href="{{url('/admin/product/create')}}"><i class="fa fa-circle-o text-red"></i>添加产品</a>
                            </li>
                            <li class="header _none">
                                <a href="{{url('/admin/article/create')}}"><i class="fa fa-circle-o text-red"></i>添加文章</a>
                            </li>
                            <li class="header _none">
                                <a href="{{url('/admin/activity/create')}}"><i class="fa fa-circle-o text-red"></i>添加活动</a>
                            </li>
                            <li class="header _none">
                                <a href="{{url('/admin/survey/create')}}"><i class="fa fa-circle-o text-red"></i>添加问卷</a>
                            </li>
                            <li class="header _none">
                                <a href="{{url('/admin/slide/create')}}"><i class="fa fa-circle-o text-red"></i>添加幻灯片</a>
                            </li>

                            <li class="footer"><a href="#">See All Messages</a></li>
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
                            @if(Auth::guard('org_admin')->user()->portrait_img)
                                <img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.Auth::guard('org_admin')->user()->portrait_img)}}" class="user-image" alt="User Image">
                            @else
                                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            @endif
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{Auth::guard('org_admin')->user()->nickname}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                @if(Auth::guard('org_admin')->user()->portrait_img)
                                    <img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.Auth::guard('org_admin')->user()->portrait_img)}}" class="img-circle" alt="User Image">
                                @else
                                    <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                @endif

                                <p>
                                    {{Auth::guard('org_admin')->user()->nickname}} - 管理员
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



    {{--<!-- Left side column. contains the logo and sidebar -->--}}
    <aside class="main-sidebar">

        {{--<!-- sidebar: style can be found in sidebar.less -->--}}
        <section class="sidebar">

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel" style="display:none;">
                <div class="pull-left image">
                    <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{Auth::guard('org_admin')->user()->nickname}}</p>
                    <!-- Status -->
                    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                </div>
            </div>

            <!-- search form (Optional) -->
            <form action="#" method="get" class="sidebar-form" style="display:none;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
                </div>
            </form>
            <!-- /.search form -->

            <!-- Sidebar Menu -->
            <ul class="sidebar-menu">

                {{--机构基本信息--}}
                <li class="header">机构(企业)管理</li>
                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/info/index')}}">
                        <i class="fa fa-sun-o text-aqua"></i> <span>基本信息</span>
                    </a>
                </li>
                
                <li class="treeview" style="display:none;">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/info/edit')}}">
                        <i class="fa fa-circle-o text-aqua"></i> <span>编辑基本信息</span>
                    </a>
                </li>

                <li class="treeview" style="display:none;">
                    <a href=""><i class="fa fa-th text-aqua"></i> <span>更多信息</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li style="display:none;">
                            <a href="{{url(config('common.org.admin.prefix').'/admin/website/edit')}}">
                                <i class="fa fa-circle-o text-aqua"></i>详细编辑
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/softorg/edit/home')}}">
                                <i class="fa fa-circle-o text-aqua"></i>编辑展示主页
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/softorg/edit/introduction')}}">
                                <i class="fa fa-circle-o text-aqua"></i>编辑简介详情
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/softorg/edit/contactus')}}">
                                <i class="fa fa-circle-o text-aqua"></i>编辑联系我们
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/softorg/edit/culture')}}">
                                <i class="fa fa-circle-o text-aqua"></i>编辑企业文化
                            </a>
                        </li>
                        {{--<li><a href="{{url('/admin/administrator/list')}}"><i class="fa fa-circle-o text-aqua"></i>管理员列表</a></li>--}}
                    </ul>
                </li>



                {{--主页管理--}}
                <li class="header">主页管理</li>
                <!-- Optionally, you can add icons to the links -->

                <li class="treeview">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/module/list')}}">
                        <i class="fa fa-sun-o text-aqua"></i> <span>模块列表</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/website/style')}}">
                        <i class="fa fa-sun-o text-aqua"></i> <span>主页样式</span>
                    </a>
                </li>



                {{--内容管理--}}
                <li class="header">内容管理</li>

                <li class="treeview">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/menu/list')}}">
                        <i class="fa fa-folder-open-o text-yellow"></i> <span>目录列表</span>
                    </a>
                </li>

                <li class="treeview">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/item/list')}}">
                        <i class="fa fa-file-text-o text-yellow"></i> <span>内容列表</span>
                    </a>
                </li>

                <li class="treeview" style="display:none;">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/menu/sort')}}">
                        <i class="fa fa-sort text-red"></i> <span>目录排序</span>
                    </a>
                </li>


                <li class="treeview" style="display:none;">
                    <a href=""><i class="fa fa-th text-aqua"></i> <span>特殊内容</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/product/list')}}">
                                <i class="fa fa-file-text text-red"></i> <span>产品列表</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/article/list')}}">
                                <i class="fa fa-file-text text-red"></i> <span>文章列表</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/activity/list')}}">
                                <i class="fa fa-calendar-check-o text-red"></i> <span>活动/会议列表</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/survey/list')}}">
                                <i class="fa fa-question-circle text-red"></i> <span>调研问卷列表</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{url(config('common.org.admin.prefix').'/admin/slide/list')}}">
                                <i class="fa fa-th-large text-red"></i> <span>幻灯片列表</span>
                            </a>
                        </li>
                    </ul>
                </li>



                {{--流量统计--}}
                <li class="header">流量统计</li>

                <li class="treeview">
                    {{--<a href="{{url(config('common.org.admin.prefix').'/admin/website/statistics')}}"><i class="fa fa-bar-chart text-green"></i> <span>流量统计</span></a>--}}
                    <a href="{{url(config('common.org.admin.prefix').'/admin/statistics/website')}}"><i class="fa fa-bar-chart text-green"></i> <span>流量统计</span></a>
                </li>


                {{--前台展示--}}
                <li class="header">前台展示</li>

                <li class="treeview">
                    <a target="_blank" href="/{{config('common.org.front.index')}}/{{ $org->website_name }}">
                        <i class="fa fa-cube text-red"></i><span>前台主页</span>
                    </a>
                </li>

                <li class="header" style="display:none;">管理员管理</li>

                <li class="treeview" style="display:none;">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/administrator/password/reset')}}">
                        <i class="fa fa-circle-o text-aqua"></i><span>修改密码</span>
                    </a>
                </li>

            </ul>
            <!-- /.sidebar-menu -->
        </section>
        {{--<!-- /.sidebar -->--}}
    </aside>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('header')
                <small>@yield('description')</small>
            </h1>
            <ol class="breadcrumb">
                @yield('breadcrumb')
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content') {{--Your Page Content Here--}}
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    {{--<!-- Main Footer -->--}}
    <footer class="main-footer">
        <!-- To the right -->
        <div class="pull-right hidden-xs">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 上海如哉网络科技有限公司 2017 <a href="#">Company</a>.</strong> All rights reserved. 沪ICP备17052782号-1
    </footer>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Create the tabs -->
        <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
            <li class="active"><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
            <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
        </ul>
        <!-- Tab panes -->
        <div class="tab-content">
            <!-- Home tab content -->
            <div class="tab-pane active" id="control-sidebar-home-tab">
                <h3 class="control-sidebar-heading">Recent Activity</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <i class="menu-icon fa fa-birthday-cake bg-red"></i>

                            <div class="menu-info">
                                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                                <p>Will be 23 on April 24th</p>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

                <h3 class="control-sidebar-heading">Tasks Progress</h3>
                <ul class="control-sidebar-menu">
                    <li>
                        <a href="javascript:;">
                            <h4 class="control-sidebar-subheading">
                                Custom Template Design
                <span class="pull-right-container">
                  <span class="label label-danger pull-right">70%</span>
                </span>
                            </h4>

                            <div class="progress progress-xxs">
                                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
                            </div>
                        </a>
                    </li>
                </ul>
                <!-- /.control-sidebar-menu -->

            </div>
            <!-- /.tab-pane -->
            <!-- Stats tab content -->
            <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
            <!-- /.tab-pane -->
            <!-- Settings tab content -->
            <div class="tab-pane" id="control-sidebar-settings-tab">
                <form method="post">
                    <h3 class="control-sidebar-heading">General Settings</h3>

                    <div class="form-group">
                        <label class="control-sidebar-subheading">
                            Report panel usage
                            <input type="checkbox" class="pull-right" checked>
                        </label>

                        <p>
                            Some information about this general settings option
                        </p>
                    </div>
                    <!-- /.form-group -->
                </form>
            </div>
            <!-- /.tab-pane -->
        </div>
    </aside>
    <!-- /.control-sidebar -->
    <!-- Add the sidebar's background. This div must be placed
         immediately after the control sidebar -->
    <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

{{--<!-- jQuery 2.2.3 -->--}}
<script src="/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
{{--<!-- Bootstrap 3.3.6 -->--}}
<script src="/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
{{--<!-- AdminLTE App -->--}}
<script src="/AdminLTE/dist/js/app.min.js"></script>

<script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>--}}

<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.8/js/fileinput.min.js"></script>
<script src="{{ asset('common/js/component/fileinput.js') }}"></script>

<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="https://cdn.bootcss.com/moment.js/2.19.0/moment.min.js"></script>

<script src="{{asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

<script src="https://cdn.bootcss.com/Swiper/4.2.2/js/swiper.min.js"></script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<script>

</script>


<script src="{{asset('js/admin/index.js')}}"></script>

@yield('js')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
