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
                    <a class="hidden-sm" href="/org/{{$org->website_name or '1'}}">首页</a>
                    <a class="hidden-sm" href="/org/{{$org->website_name or '1'}}/product">产品</a>
                    <a class="hidden-sm" href="/org/{{$org->website_name or '1'}}/article">文章</a>
                    <a class="hidden-sm" href="/org/{{$org->website_name or '1'}}/activity">活动</a>
                    <a class="hidden-sm" href="/org/{{$org->website_name or '1'}}/survey">问卷</a>
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
                <a fade-onload href="/org/{{$org->website_name or '1'}}" title="Home" rel="home" id="logo">
                    <img class="logo logo-black" src="http://cdn.softorg.cn/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}"/>
                    <img class="logo logo-white" src="http://cdn.softorg.cn/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}"/>
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
                    <img class="logo" src="http://cdn.softorg.cn/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}">
                </div>
                <div style="display:none;">
                    <img class="logo" src="http://cdn.softorg.cn/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}">
                </div>
            </li>
            <li>
                <ul class="first-nav">
                    <li><a class="big-txt" href="/org/{{$org->website_name or '1'}}/product">产品</a></li>
                    <li class="padder">&nbsp;</li>
                    <li><a class="big-txt" href="/org/{{$org->website_name or '1'}}/article">文章</a></li>
                    <li class="padder">&nbsp;</li>
                    <li><a class="big-txt" href="/org/{{$org->website_name or '1'}}/activity">活动</a></li>
                    <li class="padder">&nbsp;</li>
                    <li><a class="big-txt" href="/org/{{$org->website_name or '1'}}/survey">问卷</a></li>
                    <li class="padder">&nbsp;</li>
                </ul>
            </li>
            <li class="padder">&nbsp;</li>
            <li style="display: none">
                <ul class="second-nav">
                    <li><a href="/org/{{$org->website_name or '1'}}/product">产品</a></li>
                    <li><a href="/org/{{$org->website_name or '1'}}/article">文章</a></li>
                    <li><a href="/org/{{$org->website_name or '1'}}/activity">活动</a></li>
                    <li><a href="/org/{{$org->website_name or '1'}}/survey">问卷</a></li>
                    <li><a href="#" class="">关于我们</a></li>
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
                    <div class="hero-product-container" style="background:#000;">
                        <div class="hero-product-container-xs" style="background:#000;">
                        </div>
                        <div class="hero-product-description white" fade-onload>
                            <div style="margin-bottom:16px;font-size:20px;"><p>Welcome</p></div>
                            <h1 class="hero-heading">{{$org->name or 'name'}}</h1>
                            <div style="margin-bottom:32px;"><p>{{$org->slogan or ''}}</p></div>
                            <a href="#product" class="btn-md"><span style="color:#D5B069;">Our Service</span></a>
                            <a href="#contact" class="btn-md" style="background-color:#D5B069;"><span>Contact Us</span></a>
                        </div>
                    </div>
                </div>
            </div>


            {{--企业简介--}}
            <div class="row full wrapper-content product-column product-four-column slide-to-top" style="margin-top:48px;">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3 class="menu-title" style="margin-bottom:16px;">简 介</h3>
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list" style="height:auto;">
                            <img src="/style/about.jpg" alt="" style="width:100%;height:100%;">
                        </ul>
                        <ul class="col-sm-12 col-xs-14 product-list" style="height:auto;border-top:0 solid #111;border-bottom:1px solid #111;">
                            <div class="row full" style="width:100%;height:auto;float:left;">
                                <div class=" " style="position: relative;width:100%;height:auto;">
                                    <div class="line" style="display:none;">
                                        <p class="">{{$org->description or ''}}</p>
                                        <div>{{$org->description or ''}}</div>
                                    </div>
                                    <div class="">
                                        <h4 class="font-0" style="text-indent:2em;margin:8px 16px 16px;line-height:20px;">{{$org->description or '暂无简介'}}</h4>
                                    </div>
                                </div>
                            </div>
                        </ul>
                    </div>
                </div>
            </div>



            {{--自定义目录栏位--}}
            {{--3栏/4栏--}}
            @if( count($org->menus) != 0 )
            @foreach($org->menus as $menu)
            @if( count($menu->items) != 0 )
            <div class="row full wrapper-content product-column product-four-column slide-to-top
                @if( (count($menu->items) % 2) == 1 )
                    product-four-column--wide
                @endif
            " style="margin-top:48px;">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title" style="">
                            <h3 class="menu-title" style="width:100%;text-align:center;">{{ $menu->title }}</h3>
                            @if(false)
                            @if( count($menu->items) == 0 )
                                <span class="hidden-xs">暂无</span>
                            @else
                                <a href="/menu?id={{ decode($menu->id) }}" class="hidden-xs">更多</a>
                            @endif
                            @endif
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list">
                            @foreach($menu->items as $v)
                            <li class="col-md-6 ">
                                <a href="{{url('/'.$v->item_type.'?id=').encode($v->id)}}">
                                    <div class="item list-background" style="
                                    @if( (count($menu->items) % 2) == 1 )
                                    @if($loop->first)
                                            background:url(/style/case{{ $org->style or '0' }}/bg-r.jpg);background-size:contain;
                                    @else
                                            background:url(/style/case{{ $org->style or '0' }}/bg-v.jpg);background-size:contain;
                                    @endif
                                    @else
                                            background:url(/style/case{{ $org->style or '0' }}/bg-v.jpg);background-size:contain;
                                    @endif
                                    ">

                                        <div class="top-text left-8">
                                            <h4 class="list-title multi-ellipsis">{{$v->title or ''}}</h4>
                                            <p class="list-description description line-ellipsis">{{$v->description or ''}}</p>
                                        </div>

                                        <div class="bottom-text left-8" style="display:none;">
                                            <span class="price font-5">调研问卷</span>
                                        </div>

                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        @if( count($menu->items) == 0 )
                            <span class="view-more visible-xs">暂无</span>
                        @else
                            <a href="/menu?id={{ encode($menu->id) }}" class="view-more visible-xs- btn-md btn-more">更多</a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @endforeach
            @endif



            {{--联系我们--}}
            <div class="row full slide-to-top" id="contact" style="margin-top:48px;">
                <div class="col-md-14" style="margin-bottom:16px;">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3 class="menu-title" style="">联系我们</h3>
                        </div>
                    </div>
                </div>
                <ul class="col-sm-12 col-xs-14 product-list" style="width:100%;height:auto;">
                    <img src="/style/contact.jpeg" alt="" style="width:100%;height:100%;">
                </ul>
                <div class="col-xs-14" style="border-top:1px solid #111;border-bottom:1px solid #111;">
                    <div class="mod-stories-thumb no-margin stories-three-columns" style="height:100%;">
                        <ul class="row full" style="position:relative;height:100%;">
                            <li class="row full" style="position:relative;height:160px;">
                                <div class="wrap-text" style="display: none">
                                    <h4>电话</h4>
                                    <h4><b>{{$org->telephone or ''}}</b></h4>
                                </div>

                                <div class="top-text text-center">
                                    <h1><i class="fa fa-phone"></i></h1>
                                </div>
                                <div class="middle-text text-center">
                                    <h4><b>{{$org->telephone or ''}}</b></h4>
                                </div>
                            </li>
                            <li class="row full" style="position:relative;height:160px;">
                                <div class="wrap-text" style="display: none">
                                    <h4>邮箱</h4>
                                    <h4><b>{{$org->email or ''}}</b></h4>
                                </div>

                                <div class="top-text text-center">
                                    <h1><i class="fa fa-envelope"></i></h1>
                                </div>
                                <div class="middle-text text-center">
                                    <h4><b>{{$org->email or ''}}</b></h4>
                                </div>
                            </li>
                            <li class="row full" style="position:relative;height:160px;">
                                <div class="wrap-text" style="display: none">
                                    <h4>地址</h4>
                                    <h4><b>{{$org->address or ''}}</b></h4>
                                </div>

                                <div class="top-text text-center">
                                    <h1><i class="fa fa-location-arrow"></i></h1>
                                </div>
                                <div class="middle-text text-center">
                                    <h4><b>{{$org->address or ''}}</b></h4>
                                </div>
                            </li>
                            @if(!empty($org->qq))
                            <li class="row full" style="position:relative;height:160px;">
                                <div class="wrap-text" style="display: none">
                                    <h4>QQ</h4>
                                    <h4><b>{{$org->qq or ''}}</b></h4>
                                </div>

                                <div class="top-text text-center">
                                    <h1><i class="fa fa-qq"></i></h1>
                                </div>
                                <div class="middle-text text-center">
                                    <h4><b>{{$org->qq or ''}}</b></h4>
                                    {{--<a href="tencent://message/?uin=2567752424&Site=QQ交谈&Menu=yes" target="blank"><img border="0" src="http://wpa.qq.com/pa?p=1:2567752424:7" alt="QQ" width="71" height="24" /></a>--}}
                                </div>
                            </li>
                            @endif
                            @if(!empty($org->wechat))
                            <li class="row full" style="position:relative;height:160px;">
                                <div class="wrap-text" style="display: none">
                                    <h4>微信号</h4>
                                    <h4><b>{{$org->wechat or ''}}</b></h4>
                                </div>

                                <div class="top-text text-center">
                                    <h1><i class="fa fa-weixin"></i></h1>
                                </div>
                                <div class="middle-text text-center">
                                    <h4><b>{{$org->wechat or ''}}</b></h4>
                                    {{--<img class="" src="http://cdn.softorg.cn/{{$org->wechat_qrcode or ''}}" alt="{{$org->wechat or 'Home'}}"/>--}}
                                </div>
                            </li>
                            @endif
                            @if(!empty($org->weibo))
                            <li class="row full" style="position:relative;height:160px;">
                                <div class="wrap-text" style="display: none">
                                    <h4>微博</h4>
                                    <h4><b>{{$org->weibo or ''}}</b></h4>
                                </div>

                                <div class="top-text text-center">
                                    <h1><i class="fa fa-weibo"></i></h1>
                                </div>
                                <div class="middle-text text-center">
                                    <h4><b>{{$org->weibo or ''}}</b></h4>
                                </div>
                            </li>
                            @endif
                        </ul>
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
            <div class="row full collection-teaser slide-to-top" style="display: none;">
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
            <div class="row full slide-to-top" style="display: none;">
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
    <div class="footer">
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
            <div class="term" style="margin-top:4px;">沪ICP备17052782号-1</div>

            <div class="copyright" style="display: none">COPYRIGHT©上海如哉网络科技有限公司 技术支持 (2017-2018) 沪ICP备17052782号-1</div>
            <div class="term" style="display: none"><a href="#">Terms and conditions</a></div>

        </div>
    </div>
    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

    <script src="{{ asset('/frontend/themes/vipp/js/jm.js') }}"></script>
    <script src="{{ asset('/frontend/themes/vipp/js/jc.js') }}"></script>
    <script src="{{ asset('frontend/themes/vipp/js/all.js') }}"></script>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
     <script>

        var wechat_config = {!! $wechat_config or '' !!};
        //    console.log(wechat_config);

        $(function(){

//        var link = window.location.href;
            var link = location.href.split('#')[0];
//        console.log(link);

            if(typeof wx != "undefined") wxFn();

            function wxFn() {

                wx.config({
                    debug: false,
                    appId: wechat_config.app_id, // 必填，公众号的唯一标识
                    timestamp: wechat_config.timestamp, // 必填，生成签名的时间戳
                    nonceStr: wechat_config.nonce_str, // 必填，生成签名的随机串
                    signature: wechat_config.signature, // 必填，签名，见附录1
                    jsApiList: [
                        'checkJsApi',
                        'onMenuShareTimeline',
                        'onMenuShareAppMessage',
                        'onMenuShareQQ',
                        'onMenuShareQZone',
                        'onMenuShareWeibo'
                    ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
                }) ;

                wx.ready(function(){
                    wx.onMenuShareAppMessage({
                        title: "{{$org->name or ''}}",
                        desc: "{{$org->slogan or ''}}",
                        link: link,
                        dataUrl: '',
                        imgUrl: "http://cdn.softorg.cn/{{$org->logo or ''}}",
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            $.get(
                                "/share",
                                {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'website': "{{$org->website_name or '0'}}",
                                    'sort': 1,
                                    'module': 0,
                                    'share': 1
                                },
                                function(data) {
//                                    if(!data.success) layer.msg(data.msg);
                                }, 'json');
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareTimeline({
                        title: "{{$org->name or ''}}",
                        desc: "{{$org->slogan or ''}}",
                        link: link,
                        imgUrl: "http://cdn.softorg.cn/{{$org->logo or ''}}",
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            $.get(
                                "/share",
                                {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'website': "{{$org->website_name or '0'}}",
                                    'sort': 1,
                                    'module': 0,
                                    'share': 2
                                },
                                function(data) {
//                                    if(!data.success) layer.msg(data.msg);
                                }, 'json');
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareQQ({
                        title: "{{$org->name or ''}}",
                        desc: "{{$org->slogan or ''}}",
                        link: link,
                        imgUrl: "http://cdn.softorg.cn/{{$org->logo or ''}}",
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            $.get(
                                "/share",
                                {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'website': "{{$org->website_name or '0'}}",
                                    'sort': 1,
                                    'module': 0,
                                    'share': 3
                                },
                                function(data) {
//                                    if(!data.success) layer.msg(data.msg);
                                }, 'json');
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareQZone({
                        title: "{{$org->name or ''}}",
                        desc: "{{$org->slogan or ''}}",
                        link: link,
                        imgUrl: "http://cdn.softorg.cn/{{$org->logo or ''}}",
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            $.get(
                                "/share",
                                {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'website': "{{$org->website_name or '0'}}",
                                    'sort': 1,
                                    'module': 0,
                                    'share': 4
                                },
                                function(data) {
//                                    if(!data.success) layer.msg(data.msg);
                                }, 'json');
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareWeibo({
                        title: "{{$org->name or ''}}",
                        desc: "{{$org->slogan or ''}}",
                        link: link,
                        imgUrl: "http://cdn.softorg.cn/{{$org->logo or ''}}",
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            $.get(
                                "/share",
                                {
                                    '_token': $('meta[name="_token"]').attr('content'),
                                    'website': "{{$org->website_name or '0'}}",
                                    'sort': 1,
                                    'module': 0,
                                    'share': 5
                                },
                                function(data) {
//                                    if(!data.success) layer.msg(data.msg);
                                }, 'json');
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                })   ;
            }
        });
    </script>

</body>

</html>