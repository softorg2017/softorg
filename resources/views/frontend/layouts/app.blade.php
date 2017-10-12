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
    <!-- endbuild -->
    @yield('css')

</head>
<body>
<div class="hidden">
    <img src="{{asset('/frontend//images/share.jpg')}}" alt="">
</div>

@yield('content')

<script src="{{asset('/frontend/libs/jquery-2.1.4.min.js')}}"></script>
<script src="{{asset('/frontend/libs/jquery.fullPage.min.js')}}"></script>
@yield('js')

</body>
</html>