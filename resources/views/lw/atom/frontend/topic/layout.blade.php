<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" type="image/ico" href="{{ url('favicon.ico') }}">
    <link rel="shortcut icon" type="image/png" href="{{ url('favicon.png') }}">
    <link rel="icon" sizes="16x16 32x32 64x64" href="{{ url('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="196x196" href="{{ url('favicon.png') }}">
    <title>@yield('title')</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="robots" content="all" />
    <meta name="title" content="@yield('meta_title')" />
    <meta name="author" content="@yield('meta_author')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
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

    <link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/css/fileinput.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css')}}">

    <link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">

    <script src="https://cdn.bootcss.com/moment.js/2.19.0/moment.min.js"></script>

    <link href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">

    <link href="https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('css/common.css')}}">
    <link rel="stylesheet" href="{{asset('css/frontend/index.css')}}">

    @yield('style')
    <style>
        .main-sidebar {width:300px;background-color:#1a2226;}
        .main-header .logo {width:300px;background-color:#222d32;}
        .main-header .logo span {color:#fff;}
        .main-header .navbar {margin-left:300px;background-color:#1a2226;}
        .content-wrapper {margin-left:300px;}
        .main-footer {margin-left:300px;}

        .fold-button {height:24px;line-height:24px;cursor:pointer;}
        .fold-button:hover { color:#222;background-color:#ccc; }

        .recursion-menu {height:28px;line-height:28px;margin:4px 0;}
        .recursion-icon {margin-right:0;cursor:pointer;}
        .recursion-icon .fa-file-text {color:#bbb;}
        /*.recursion-icon .fa-plus-square {color:#3c8dbc;}*/
        /*.recursion-icon .fa-minus-square {color:green;}*/
        .recursion-text { width:calc(100% - 16px);width:-moz-calc(100% - 16px);width:-webkit-calc(100% - 16px);float:right; }
        .recursion-text a { width:100%;padding:6px 8px;line-height:16px;color:#eee;float:right; }
        .recursion-text a:hover { color:#222;background-color:#ccc; }
        .recursion-text.active { background-color:#ccc; }
        .recursion-text.active a { color:#222; }
        @media (max-width: 767px) {
            .content-wrapper, .right-side, .main-footer {
                margin-left: 0;
            }
            .main-header .navbar {
                margin: 0;
            }
            .main-header .logo, .main-header .navbar {
                width: 100%;
                float: none;
            }
            .main-sidebar, .left-side {
                 -webkit-transform: translate(-300px, 0);
                 -ms-transform: translate(-300px, 0);
                 -o-transform: translate(-300px, 0);
                 transform: translate(-300px, 0);
             }
            .sidebar-open .main-sidebar, .sidebar-open .left-side {
                -webkit-transform: translate(0, 0);
                -ms-transform: translate(0, 0);
                -o-transform: translate(0, 0);
                transform: translate(0, 0);
            }
            .sidebar-open .content-wrapper, .sidebar-open .right-side, .sidebar-open .main-footer {
                -webkit-transform: translate(300px, 0);
                -ms-transform: translate(300px, 0);
                -o-transform: translate(300px, 0);
                transform: translate(300px, 0);
            }
        }
        @media (min-width: 768px) {
            .sidebar-mini.sidebar-collapse .main-sidebar {
                -webkit-transform: translate(-300px, 0);
                -ms-transform: translate(-300px, 0);
                -o-transform: translate(-300px, 0);
                transform: translate(-300px, 0);
                width: 300px;
                z-index: 850;
            }
            .sidebar-mini.sidebar-collapse .content-wrapper, .sidebar-mini.sidebar-collapse .right-side, .sidebar-mini.sidebar-collapse .main-footer {
                margin-left: 0px !important;
                z-index: 840;
            }
        }
    </style>

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
<body class="hold-transition skin-white sidebar-mini">
<div class="wrapper">

    <!-- Main Header -->
    <header class="main-header">

        <!-- Logo -->
        <a href="{{url('/')}}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>师</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>三人行</b></span>
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

                    <li class="dropdown tasks-menu add-menu">
                        <!-- Menu toggle button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-home"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header"><a href="{{url('/u/'.$data->user->encode_id)}}"><i class="fa fa-home text-orange"></i>
                                    {{$data->user->name}}的主页</a></li>
                            @if(!Auth::check())
                                <li class="header"><a href="{{url('/login')}}"><i class="fa fa-circle-o text-default"></i>注册</a></li>
                                <li class="header"><a href="{{url('/register')}}"><i class="fa fa-circle-o text-default"></i>注册</a></li>
                            @else
                                <li class="header"><a href="{{url('/home')}}"><i class="fa fa-circle-o text-default"></i>返回我的后台</a></li>
                            @endif
                            <li class="footer"><a href="#">See All Messages</a></li>
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
    <aside class="main-sidebar" style="">

        {{--<!-- sidebar: style can be found in sidebar.less -->--}}
        <section class="sidebar" style="padding-bottom:32px;">

            <div class="col-md-12" style="color:#eee;">
                <div class="row recursion-menu">
                    <span class="recursion-icon" style="color:orange;">
                        <i class="fa fa-bookmark"></i>
                    </span>
                    <span class="recursion-text @if(empty($content)) active @endif">
                        <a href="{{url('/course/'.encode($data->id))}}">
                            {{ $data->title or '' }}
                        </a>
                    </span>
                </div>
            </div>

            <div class="col-md-12" style="margin:8px 0;color:#666;">
                <div class="col-md-6 fold-button fold-down">
                    <span class="">
                        <i class="fa fa-plus-square"></i> &nbsp; 全部展开
                    </span>
                </div>
                <div class="col-md-6 fold-button fold-up">
                    <span class="">
                        <i class="fa fa-minus-square"></i> &nbsp; 全部折叠
                    </span>
                </div>
            </div>

            @foreach( $data->contents_recursion as $key => $recursion )
                <div class="col-md-12 recursion-row" data-level="{{$recursion->level or 0}}" data-id="{{$recursion->id or 0}}"
                     style="color:#eee;display:@if($recursion->level != 0) none @endif">
                    <div class="row recursion-menu" style="margin-left:{{ $recursion->level*24 }}px">
                        <span class="recursion-icon">
                            @if($recursion->type == 1)
                                @if($recursion->has_child == 1)
                                    <i class="fa fa-plus-square recursion-fold"></i>
                                @else
                                    <i class="fa fa-file-text"></i>
                                @endif
                            @else
                                <i class="fa fa-file-text"></i>
                            @endif
                        </span>
                        <span class="recursion-text @if(!empty($content)) @if($recursion->id == $content->id) active @endif @endif">
                            <a href="{{url('/course/'.encode($data->id).'?content='.encode($recursion->id))}}">
                                {{ $recursion->title or '' }}
                            </a>
                        </span>
                    </div>
                </div>
            @endforeach




            <!-- /.sidebar-menu -->
        </section>
        {{--<!-- /.sidebar -->--}}
    </aside>



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('header')
                <small>@yield('description')</small>
            </h1>
        </section>

        <!-- Main content -->
        <section class="content" style="margin-top:16px;">
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

<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/js/fileinput.min.js"></script>

<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>

<script src="{{asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>

<script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script src="https://cdn.bootcss.com/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>

<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>

<script>

</script>


<script src="{{asset('js/frontend/index.js')}}"></script>

@yield('js')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
