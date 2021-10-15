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
    {{--<link href="https://cdn.bootcss.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/font-awesome-4.5.0.min.css') }}">
    <!-- Ionicons -->
    {{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">--}}
    {{--<link href="https://cdn.bootcss.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/ionicons-2.0.1.min.css') }}">
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

    {{--<link href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/css/fileinput.min.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/bootstrap-fileinput-4.4.8.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lib/css/fileinput-only.css') }}">

    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">

    {{--<link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="/AdminLTE/plugins/iCheck/all.css">

    @yield('css')
    @yield('custom-css')
    @yield('custom-style')

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
<body class="hold-transition login-page">


    @yield('content')

    {{--main-footer--}}
    <footer class="main-footer" style="position:absolute;bottom:0;left:0;right:0;margin-left:0;">
        <!-- To the right -->
        <div class="pull-right hidden-xs _none">
            Anything you want
        </div>
        <!-- Default to the left -->
        {{--<strong>Copyright &copy; 上海如哉网络科技有限公司 2017-2020 <a href="#">Company</a>.</strong> All rights reserved. 沪ICP备17052782号-4--}}
        <small>如有疑问请联系管理员 电话：</small><strong>17721364771</strong></small>
        <br>
        {{--<small>联系电话：</small><strong>17721364771</strong>--}}
        {{--<br>--}}
        <small>版权所有&copy;上海如哉网络科技有限公司</small><span class="_none">(2017-2021)</span>
        <br class="visible-xs">
        <a target="_blank" href="https://beian.miit.gov.cn"><small>沪ICP备17052782号-4</small></a>
    </footer>

<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

{{--<!-- jQuery 2.2.3 -->--}}
<script src="/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
{{--<!-- Bootstrap 3.3.6 -->--}}
<script src="/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
{{--<!-- AdminLTE App -->--}}
<script src="/AdminLTE/dist/js/app.min.js"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>--}}
{{--<script src="{{ asset('/lib/js/bootstrap-modal-2.2.6.min.js') }}"></script>--}}

{{--<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>--}}
<script src="{{ asset('/lib/js/layer-3.0.3.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/js/fileinput.min.js"></script>--}}
<script src="{{ asset('/lib/js/fileinput-4.4.8.min.js') }}"></script>
<script src="{{ asset('/lib/js/fileinput-only.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>--}}
<script src="{{ asset('/lib/js/jquery.form-4.2.2.min.js') }}"></script>

<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>--}}
<script src="/AdminLTE/plugins/iCheck/icheck.min.js"></script>

@yield('js')
@yield('custom-js')
@yield('custom-script')

<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
