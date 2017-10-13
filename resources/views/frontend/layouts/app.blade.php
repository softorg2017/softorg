<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>标题</title>
    <meta http-equiv="X-UA-Compatible" content="IE=10,Chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="author" content="">
    <meta name="Keywords" Content="">
    <meta name="Description" Content="">
    <meta name="keyword" content="">
    {{--<link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">--}}

    <!-- build:css -->
    <link rel="stylesheet" href="{{asset('/frontend/css/lean_1.0.0.min.css')}}">
    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <!-- endbuild -->
    @yield('css')
    <!--[if lt IE 9]>
    <script src="http://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.js"></script>
    <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        footer {
            background-color: #2f2e2e;
            color: #999;
            padding: 30px 0;
            line-height: 1.6;
        }
    </style>

</head>
<body>
<div class="hidden">
    <img src="{{asset('/frontend//images/share.jpg')}}" alt="">
</div>

@yield('content')

<script src="{{asset('/frontend/libs/jquery-2.1.4.min.js')}}"></script>
<script src="https://cdn.bootcss.com/modernizr/2010.07.06dev/modernizr.min.js"></script>
<script src="https://cdn.bootcss.com/waypoints/4.0.1/jquery.waypoints.min.js"></script>

@yield('js')

</body>
</html>