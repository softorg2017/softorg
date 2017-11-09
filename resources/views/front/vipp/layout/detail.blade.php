<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10">
<![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en-us" dir="ltr">

<head profile="http://www.w3.org/1999/xhtml/vocab">
    <title>@yield('title')</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="" type="" />
    <meta name="description" content="" />
    <link rel="canonical" href="https://www.softorg.cn" />
    <link rel="shortlink" href="https://www.softorg.cn" />
    <meta property="og:site_name" content="softorg.cn" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://www.softorg.cn" />
    <meta property="og:title" content="Official Softorg Online Website" />
    <meta property="og:updated_time" content="" />
    <meta property="article:published_time" content="" />
    <meta property="article:modified_time" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
    <meta name="google" content="notranslate" />
    <link rel="shortcut icon" href="/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="/favicon-192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16.png">
    <link rel="icon" sizes="any" mask href="/favicon-192.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/favicon-32.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon-32.png">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/sites/all/themes/vipp/assets/img/favicons/mstile-150x150.png">
    <meta name="msapplication-config" content="/sites/all/themes/vipp/assets/img/favicons/browserconfig.xml">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/themes/vipp/css/all.css') }}" media="all" />
    <script src="https://www.vipp.com/sites/default/files/js/js_SLyXq4zcOYrRlJ8NMZcdVCadUvi6vXyeJgA1IkziDwE.js.pagespeed.jm.KiaDCMyCJY.js"></script>
    <script src="https://www.vipp.com/sites/all,_themes,_vipp,_assets,_js,_plugins,_modernizr.custom.js,qoys8tt+default,_files,_js,_js_gPqjYq7fqdMzw8-29XWQIVoDSWTmZCGy9OqaHppNxuQ.js.pagespeed.jc.E10rRAYkAy.js"></script>

    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    @yield('css')
</head>

<body class="html front not-logged-in one-sidebar sidebar-first page-node page-node- page-node-1864 node-type-front-page i18n-en-us has-cookie front-page">
<script>
    var active_country = "US";
</script>
{{--隐藏的头部目录--}}
<div class="top-wrapper">
    <div class="top extra menu sticky">
        <div class="wrap">
            <div class="settings">
            </div>
            <div class="right">
                <a href="#" class="hidden-sm">E</a>
                <a href="#" class="hidden-sm">D</a>
                <a href="#" class="hidden-sm">C</a>
                <a href="#" class="hidden-sm">B</a>
                <a href="#" class="hidden-sm">A</a>
                <a href="#" class="hidden-sm">关于我们</a>
                <a href="#" class="btn-icon-close"><i class="icon-close"></i></a>
            </div>
        </div>
    </div>
</div>
{{--头部--}}
<div class="top-wrapper">
    <div class="top primary menu sticky">
        <div class="wrap">
            <a fade-onload href="/org/@yield('website-name')" title="Home" rel="home" id="logo">
                <img class="logo logo-black" src="http://cdn.softorg.cn:8088/{{$data->org->logo or ''}}" alt="{{$data->org->short or 'Home'}}"/>
                <img class="logo logo-white" src="http://cdn.softorg.cn:8088/{{$data->org->logo or ''}}" alt="{{$data->org->short or 'Home'}}"/>
            </a>
            <div class="right" fade-onload>
                <a class="hidden-sm text-item" href="/org/@yield('website-name')/product">产品</a>
                <a class="hidden-sm text-item" href="/org/@yield('website-name')/activity">活动</a>
                <a class="hidden-sm text-item" href="/org/@yield('website-name')/survey">问卷</a>
                <a class="hidden-sm text-item" href="/org/@yield('website-name')/article">文章</a>
                <a class="btn-menu-burger" href="#">
                    <img class="icon-menu icon-menu--white" src="https://www.vipp.com/sites/all/themes/vipp/assets/img/icon-menu-white@2x.svg" alt="目录">
                    <img class="icon-menu icon-menu--black" src="https://www.vipp.com/sites/all/themes/vipp/assets/img/icon-menu@2x.svg" alt="目录">
                    <i class="icon-close"></i>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="tray-menu--mask"></div>
<div class="tray-menu">
    {{--侧边栏--}}
    <ul class="main menu-level menu-current menu-in">
        <li>
            <div>
                <img class="logo" src="" alt="{{$org->short or 'Home'}}">
            </div>
            <div>
                <img class="logo" src="http://cdn.softorg.cn:8088/{{$data->org->logo or ''}}" alt="{{$data->org->short or 'Home'}}">
            </div>
        </li>
        <li>
            <ul class="first-nav">
                <li><a class="big-txt" href="/org/@yield('website-name')/product">产品</a></li>
                <li class="padder">&nbsp;</li>
                <li><a class="big-txt" href="/org/@yield('website-name')/activity">活动</a></li>
                <li class="padder">&nbsp;</li>
                <li><a class="big-txt" href="/org/@yield('website-name')/survey">问卷</a></li>
                <li class="padder">&nbsp;</li>
                <li><a class="big-txt" href="/org/@yield('website-name')/article">文章</a></li>
                <li class="padder">&nbsp;</li>
            </ul>
        </li>
        <li class="padder">&nbsp;</li>
        <li>
            <ul class="second-nav">
                <li><a href="#" class="">A</a></li>
                <li><a href="#" class="">B</a></li>
                <li><a href="#" class="">C</a></li>
                <li><a href="#" class="">D</a></li>
                <li><a href="#" class="">E</a></li>
                <li><a href="#" class="">关于我们</a></li>
            </ul>
        </li>
        <li class="padder">&nbsp;</li>
    </ul>
</div>
{{--main--}}
<div class="wrapper-main-content">
    <div class="container-fluid ">
        {{--首页--}}
        <div class="row full has-fold">
            <div class="col-xs-14">
                <div class="hero-product-container" style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-16-pedal-bin-4.jpg.pagespeed.ic.00ERKzT-Z_.webp)">
                    <div class="hero-product-container-xs" style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-16-pedal-bin-black-topview-0.jpg.pagespeed.ic.uIVjfVKkYq.webp)">
                    </div>
                    <div class="hero-product-description white" fade-onload>
                        <h4>{{$data->org->short or ''}}</h4>
                        <h1 class="hero-heading">@yield('data-title')</h1>
                        <a href="javascript:void(0);" class="btn-md"><span>@yield('detail-name')</span></a>
                    </div>
                </div>
            </div>
        </div>
        @yield('content')
    </div>
</div>
<div class="overlay"></div>
<div class="overlay"></div>
{{--footer--}}
<div class="footer">
    <div class="bt-scroll-top"><i class="icon-arrow-down"></i> </div>
    <div class="social-links">
        <a href="https://www.instagram.com/vipp/" target="_blank">
            <img src="https://www.vipp.com/sites/all/themes/vipp/assets/img/xicon-social-04,402x.png.pagespeed.ic.R7xJIzYmlQ.webp" alt="instagram"/>
        </a>
        <a href="https://www.facebook.com/vippdotcom/" target="_blank">
            <img src="https://www.vipp.com/sites/all/themes/vipp/assets/img/xicon-social-01,402x.png.pagespeed.ic.Q_m8ogUuva.webp" alt="facebook"/>
        </a>
        <a href="https://www.pinterest.com/vippdotcom/" target="_blank">
            <img src="https://www.vipp.com/sites/all/themes/vipp/assets/img/xicon-social-03,402x.png.pagespeed.ic.rvBLV3p0t6.webp" alt="pinterest"/>
        </a>
        <a href="https://www.linkedin.com/company/vipp" target="_blank">
            <img src="https://www.vipp.com/sites/all/themes/vipp/assets/img/xicon-social-06,402x.png.pagespeed.ic.V75jyaK8lS.webp" alt="linkedin"/>
        </a>
        <a href="https://www.youtube.com/user/vippdesign" target="_blank">
            <img src="https://www.vipp.com/sites/all/themes/vipp/assets/img/xicon-social-05,402x.png.pagespeed.ic.sxUgfdJLti.webp" alt="youtube"/>
        </a>
        <a href="https://twitter.com/vipp" target="_blank">
            <img src="https://www.vipp.com/sites/all/themes/vipp/assets/img/xicon-social-02,402x.png.pagespeed.ic.rUGHLlzbZU.webp" alt="twitter"/>
        </a>
    </div>
    <ul>
        <li><a href="#">FA</a></li>
        <li><a href="#">FB</a></li>
        <li><a href="#">FC</a></li>
    </ul>
    <div class="copyright">COPYRIGHT© Softorg 2017</div>
    <div class="term"><a href="#">Terms and conditions</a></div>
</div>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ asset('frontend/themes/vipp/js/all.js') }}"></script>
<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>
<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>
@yield('js')
</body>

</html>