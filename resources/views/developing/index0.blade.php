<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10">
<![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en-us" dir="ltr">

<head profile="http://www.w3.org/1999/xhtml/vocab">
    <title>{{$org->name or '首页'}}</title>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="shortcut icon" href="" type="" />
    <meta name="robots" content="all" />
    <meta name="author" content="@yield('meta_author')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
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
    <link rel="icon" type="image/png" sizes="196x196" href="/favicon-196.png">
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

    <link href="https://cdn.bootcss.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/themes/vipp/css/all.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/index.css') }}" media="all" />

    {{--<script src="https://www.vipp.com/sites/default/files/js/js_SLyXq4zcOYrRlJ8NMZcdVCadUvi6vXyeJgA1IkziDwE.js.pagespeed.jm.KiaDCMyCJY.js"></script>--}}
    {{--<script src="https://www.vipp.com/sites/all,_themes,_vipp,_assets,_js,_plugins,_modernizr.custom.js,qoys8tt+default,_files,_js,_js_gPqjYq7fqdMzw8-29XWQIVoDSWTmZCGy9OqaHppNxuQ.js.pagespeed.jc.E10rRAYkAy.js"></script>--}}

    <style>
        .wrapper-content ul.product-list li .list-bg {}
    </style>
    
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
                    {{--@if( count($org->menus) != 0 )--}}
                    {{--@foreach($org->menus as $menu)--}}
                        {{--<a class="big-txt" href="{{url('/menu?id='.encode($menu->id))}}">{{ $menu->title }}</a>--}}
                    {{--@endforeach--}}
                    {{--@endif--}}
                    <a href="#contact" class="hidden-sm">关于我们</a>
                    <a href="#" class="btn-icon-close"><i class="icon-close"></i></a>
                </div>
            </div>
        </div>
    </div>


    {{--头部--}}
    <div class="top-wrapper">
        <div class="top primary menu sticky">
            <div class="wrap">
                <a fade-onload href="/org/{{$org->website_name or '1'}}" title="Home" rel="home" id="logo">
                    <img class="logo logo-black" src="http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}"/>
                    <img class="logo logo-white" src="http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}"/>
                </a>
                <div class="right" fade-onload>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}">首页</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/product">产品</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/article">文章</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/activity">活动</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/survey">问卷</a>
                    <a class="btn-menu-burger" href="#">
                        <img class="icon-menu icon-menu--white" src="{{asset('/frontend/themes/vipp/assets/img/icon-menu-white@2x.svg')}}" alt="目录">
                        <img class="icon-menu icon-menu--black" src="{{asset('/frontend/themes/vipp/assets/img/icon-menu@2x.svg')}}" alt="目录">
                        <i class="icon-close"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="tray-menu--mask"></div>
    {{--侧边栏--}}
    <div class="tray-menu">
        <ul class="main menu-level menu-current menu-in">
            <li>
                <div>
                    <img class="logo" src="http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}">
                </div>
                <div style="display:none;">
                    <img class="logo" src="http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}">
                </div>
            </li>
            <li>
                <ul class="first-nav">
                    {{--@if( count($org->menus) != 0 )--}}
                    {{--@foreach($org->menus as $menu)--}}
                        {{--<li><a class="big-txt" href="{{url('/menu?id='.encode($menu->id))}}">--}}
                            {{--<i class="fa fa-dot-circle-o" style="font-size:8px;margin-right:8px;"></i> {{ $menu->title }}</a></li>--}}
                        {{--<li class="padder">&nbsp;</li>--}}
                    {{--@endforeach--}}
                    {{--@endif--}}
                </ul>
            </li>
            <li class="padder">&nbsp;</li>
            <li>
                <ul class="second-nav">
                    <li><a href="/org/{{$org->website_name or '1'}}/product">产品</a></li>
                    <li><a href="/org/{{$org->website_name or '1'}}/article">文章</a></li>
                    <li><a href="/org/{{$org->website_name or '1'}}/activity">活动</a></li>
                    <li><a href="/org/{{$org->website_name or '1'}}/survey">问卷</a></li>
                    <li><a href="#contact" class="">关于我们</a></li>
                </ul>
            </li>
            <li class="padder">&nbsp;</li>
        </ul>
    </div>


    {{--main--}}
    <div class="wrapper-main-content style-main style-{{ $org->style or '0' }}">

        <div class="container-fluid ">

            {{--首页--}}
            <div class="row full has-fold">
                <div class="col-xs-14">
                    <div class="hero-product-container">
                        <div class="hero-product-container-xs">
                        </div>
                        <div class="hero-product-description" fade-onload>
                            <div style="margin-bottom:16px;font-size:20px;"><p>Welcome</p></div>
                            <h1 class="hero-heading">{{$org->name or 'name'}}</h1>
                            <div style="margin-bottom:32px;"><p>{{$org->slogan or ''}}</p></div>
                            <a href="#product" class="btn-md btn-md-l"><span>Our Service</span></a>
                            <a href="#contact" class="btn-md btn-md-r"><span>Contact Us</span></a>
                        </div>
                    </div>
                </div>
            </div>


            {{--block--}}
            <div class="row full wrapper-null-container">
            </div>


            {{--block-in-2--}}
            <div class="row full wrapper-module-container">
                <div class="col-md-14">
                    <div class="row full block-in">

                        <div class="module-title-container">
                            <h3 class="menu-title">block-in-2</h3>
                        </div>

                        <div class="module-block-container">
                            <div class="row full block-2-column">
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--block-in-3--}}
            <div class="row full wrapper-module-container">
                <div class="col-md-14">
                    <div class="row full block-in">
                        <div class="module-title-container">
                            <h3 class="menu-title">block-in-3</h3>
                        </div>
                        <div class="module-block-container">
                            <div class="row full block-3-column">
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{--block-in-4--}}
            <div class="row full wrapper-module-container">
                <div class="col-md-14">
                    <div class="row full block-in">
                        <div class="block-title-container">
                            <h3 class="menu-title">block-in-4</h3>
                        </div>
                        <div class="module-block-container">
                            <div class="row full block-4-column">
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            {{--block-full-2---}}
            <div class="row full wrapper-module-container">
                <div class="col-md-14">
                    <div class="row full block-full">

                        <div class="module-title-container">
                            <h3 class="menu-title">block-full-2</h3>
                        </div>

                        <div class="module-block-container">
                            <div class="row full block-2-column">
                                <li class="item-block" style="background:url(/images/black-v.jpg)">
                                </li>
                                <li class="item-block">
                                </li>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--block-full-3--}}
            <div class="row full wrapper-module-container">
                <div class="col-md-14">
                    <div class="row full block-full">

                        <div class="module-title-container">
                            <h3 class="menu-title">block-full-3</h3>
                        </div>

                        <div class="module-block-container">
                            <div class="row full block-3-column">
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                    <div class="item-block-top"></div>
                                    <div class="item-block-bottom"></div>
                                </li>
                                <li class="item-block">
                                </li>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{--block-full-4--}}
            <div class="row full wrapper-module-container">
                <div class="col-md-14">
                    <div class="row full block-full">

                        <div class="block-title-container">
                            <h3 class="menu-title">block-full-4</h3>
                        </div>

                        <div class="module-block-container">
                            <div class="row full block-4-column">
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                    <div class="item-block-top"></div>
                                    <div class="item-block-bottom"></div>
                                </li>
                                <li class="item-block">
                                </li>
                                <li class="item-block">
                                </li>
                            </div>
                        </div>

                    </div>
                </div>
            </div>






            {{--联系我们--}}
            <div class="row full wrapper-content product-column product-four-column slide-to-top" style="display: none">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3>联系我们</h3>
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list">
                            <li class="col-md-6">
                                <div class="item " style="background-image:url(/images/black-v.jpg)">
                                    <div class="line">
                                        <p class="seriesnumber"><span><b>电话</b></span></p>
                                    </div>
                                    <div class="line">
                                        <p class="seriesnumber">{{$org->telephone or ''}}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <div class="item " style="background-image:url(/images/black-v.jpg)">
                                    <div class="line">
                                        <p class="seriesnumber"><span><b>邮箱</b></span></p>
                                    </div>
                                    <div class="line">
                                        <p class="seriesnumber">{{$org->email or ''}}</p>
                                    </div>
                                </div>
                            </li>
                            <li class="col-md-6">
                                <div class="item " style="background-image:url(/images/black-v.jpg)">
                                    <div class="line">
                                        <p class="seriesnumber"><span><b>微信</b></span></p>
                                    </div>
                                    <div class="line">
                                        <p class="seriesnumber">{{$org->wechat or ''}}</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



            {{--图片 2栏--}}
            <div class="row full collection-teaser slide-to-top">
                <div class="col-md-14">
                    <div class="row full">
                        @if(false)
                        @foreach($org->surveys as $v)
                            <div class="col-xs-7">
                                <div class="hero-story-container fade-onscroll" style="background-image:url(
                                @if(($loop->index)%2 == 0)
                                        /images/black-v.jpg
                                @else
                                        /images/black-v.jpg
                                @endif
                                )">
                                    @if(($loop->index)%2 == 0)
                                        <img src="/images/black-v.jpg" alt="">
                                    @else
                                        <img src="/images/black-v.jpg" alt="">
                                    @endif
                                    <div class="hero-story-description">
                                        <div class="hero-story-description__wrapper">
                                            <h4>{{$v->description or ''}}</h4>
                                            <h1>{{$v->title or ''}}</h1>
                                            <a href="/org/{{$org->website_name or '1'}}/survey" class="button white view-now">查看</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>

            {{--图片 3栏--}}
            <div class="row full slide-to-top" style="display:none;">
                <div class="col-xs-14">
                    <div class="mod-stories-thumb no-margin stories-three-columns">
                        <ul class="row">
                            <li class="item-text-on-img fade-onscroll">
                                <a href="">
                                    <div class="wrap-img wrap-img--landscape" style="background-image:url(/images/black-v.jpg)">
                                        <img src="/images/black-v.jpg" alt="" />
                                    </div>
                                    <div class="wrap-img wrap-img--portrait" style="background-image:url(/images/black-v.jpg)">
                                        <img src="/images/black-v.jpg" alt="" />
                                    </div>
                                    <div class="wrap-text">
                                        <h4>电话</h4>
                                        <h3>{{$org->mobile or ''}}</h3>
                                    </div>
                                </a>
                            </li>
                            <li class="item-text-on-img fade-onscroll">
                                <a href="">
                                    <div class="wrap-img wrap-img--landscape" style="background-image:url(/images/black-v.jpg)">
                                        <img src="/images/black-v.jpg" alt="" />
                                    </div>
                                    <div class="wrap-img wrap-img--portrait" style="background-image:url(/images/black-v.jpg)">
                                        <img src="/images/black-v.jpg" alt="" />
                                    </div>
                                    <div class="wrap-text">
                                        <h4>邮箱</h4>
                                        <h3>{{$org->email or ''}}</h3>
                                    </div>
                                </a>
                            </li>
                            <li class="item-text-on-img fade-onscroll">
                                <a href="">
                                    <div class="wrap-img wrap-img--landscape" style="background-image:url(/images/black-v.jpg)">
                                        <img src="/images/black-v.jpg" alt="" />
                                    </div>
                                    <div class="wrap-img wrap-img--portrait" style="background-image:url(/images/black-v.jpg)">
                                        <img src="/images/black-v.jpg" alt="" />
                                    </div>
                                    <div class="wrap-text">
                                        <h4>微信号</h4>
                                        <h3>{{$org->wechat or ''}}</h3>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>



        </div>

    </div>

    <div class="overlay"></div>
    <div class="overlay"></div>


    {{--footer--}}
    <div class="wrapper-footer-container">
        <div class="col-md-14">
            <div class="row full block-in">
                <div class="row">网站地图</div>
                <div class="row">2</div>
                <div class="row">3</div>
                <div class="row">技术支持©上海如哉网络科技有限公司</div>
                <div class="row">沪ICP备17052782号-1</div>
            </div>
        </div>
    </div>


    {{--footer--}}
    <div class="footer" style="display:none;">
        <div class="bt-scroll-top"><i class="icon-arrow-down"></i> </div>
        <div class="social-links" style="display: none">
            <a href="https://www.instagram.com/softorg/" target="_blank">
                <img src="{{asset('/frontend/themes/vipp/assets/img/instagram.webp')}}" alt="instagram"/>
            </a>
            <a href="https://www.facebook.com/softorgdotcom/" target="_blank">
                <img src="{{asset('/frontend/themes/vipp/assets/img/facebook.webp')}}" alt="facebook"/>
            </a>
            <a href="https://www.pinterest.com/softorgdotcom/" target="_blank">
                <img src="{{asset('/frontend/themes/vipp/assets/img/pinterest.webp')}}" alt="pinterest"/>
            </a>
            <a href="https://www.linkedin.com/company/softorg" target="_blank">
                <img src="{{asset('/frontend/themes/vipp/assets/img/linkedin.webp')}}" alt="linkedin"/>
            </a>
            <a href="https://www.youtube.com/user/softorgdesign" target="_blank">
                <img src="{{asset('/frontend/themes/vipp/assets/img/youtube.webp')}}" alt="youtube"/>
            </a>
            <a href="https://twitter.com/softorg" target="_blank">
                <img src="{{asset('/frontend/themes/vipp/assets/img/twitter.webp')}}" alt="twitter"/>
            </a>
        </div>
        <ul style="margin-bottom:16px;">
            <li><a href="/org/{{$org->website_name or '1'}}">首页</a></li>
            <li><a href="/org/{{$org->website_name or '1'}}/product">产品</a></li>
            <li><a href="/org/{{$org->website_name or '1'}}/activity">活动</a></li>
            <li><a href="/org/{{$org->website_name or '1'}}/survey">问卷</a></li>
            <li><a href="/org/{{$org->website_name or '1'}}/article">文章</a></li>
        </ul>
        <div style="margin-bottom:16px;">

            <div class="term" style="margin-top:4px;">COPYRIGHT©{{$org->name or 'name'}}</div>
            <div class="term" style="margin-top:4px;">技术支持©上海如哉网络科技有限公司</div>
            <div class="term" style="margin-top:4px;"><a href="http://www.miitbeian.gov.cn">沪ICP备17052782号-1</a></div>

            <div class="copyright" style="display: none">COPYRIGHT©上海如哉网络科技有限公司 技术支持 (2017-2018) 沪ICP备17052782号-1</div>
            <div class="term" style="display: none"><a href="#">Terms and conditions</a></div>

        </div>
    </div>


    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

    <script src="{{ asset('/frontend/themes/vipp/js/jm.js') }}"></script>
    <script src="{{ asset('/frontend/themes/vipp/js/jc.js') }}"></script>
    <script src="{{ asset('frontend/themes/vipp/js/all.js') }}"></script>


</body>

</html>