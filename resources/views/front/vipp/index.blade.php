<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10">
<![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en-us" dir="ltr">

<head profile="http://www.w3.org/1999/xhtml/vocab">
    <title>{{$org->name or '首页'}}</title>
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
    <link rel="shortcut icon" href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/favicon.ico">
    <link rel="icon" sizes="16x16 32x32 64x64" href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/favicon.ico">
    <link rel="icon" type="image/png" sizes="196x196" href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/xandroid-chrome-192x192.png.pagespeed.ic.l39NsN9ROb.webp">
    <link rel="icon" type="image/png" sizes="32x32" href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/xfavicon-32x32.png.pagespeed.ic.qzt0Ee10fj.webp">
    <link rel="icon" type="image/png" sizes="16x16" href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/xfavicon-16x16.png.pagespeed.ic.6120S2FYAg.webp">
    <link rel="icon" sizes="any" mask href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/safari-pinned-tab.svg">
    <link rel="apple-touch-icon" sizes="60x60" href="https://www.vipp.com/sites/all/themes/vipp/assets/img/favicons/xapple-touch-icon.png.pagespeed.ic.YJd6i7sD4P.webp">
    <link rel="apple-touch-icon" sizes="72x72" href="">
    <link rel="apple-touch-icon" sizes="76x76" href="">
    <link rel="apple-touch-icon" sizes="114x114" href="">
    <link rel="apple-touch-icon" sizes="120x120" href="">
    <link rel="apple-touch-icon" sizes="144x144" href="">
    <link rel="apple-touch-icon" sizes="152x152" href="">
    <link rel="apple-touch-icon" sizes="180x180" href="">
    <meta name="msapplication-TileColor" content="#FFFFFF">
    <meta name="msapplication-TileImage" content="/sites/all/themes/vipp/assets/img/favicons/mstile-150x150.png">
    <meta name="msapplication-config" content="/sites/all/themes/vipp/assets/img/favicons/browserconfig.xml">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/themes/vipp/css/all.css') }}" media="all" />
    <script src="https://www.vipp.com/sites/default/files/js/js_SLyXq4zcOYrRlJ8NMZcdVCadUvi6vXyeJgA1IkziDwE.js.pagespeed.jm.KiaDCMyCJY.js"></script>
    <script src="https://www.vipp.com/sites/all,_themes,_vipp,_assets,_js,_plugins,_modernizr.custom.js,qoys8tt+default,_files,_js,_js_gPqjYq7fqdMzw8-29XWQIVoDSWTmZCGy9OqaHppNxuQ.js.pagespeed.jc.E10rRAYkAy.js"></script>
    
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
                <a fade-onload href="/org/{{$org->website_name or '1'}}" title="Home" rel="home" id="logo">
                    <img class="logo logo-black" src="http://cdn.softorg.cn:8088/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}"/>
                    <img class="logo logo-white" src="http://cdn.softorg.cn:8088/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}"/>
                </a>
                <div class="right" fade-onload>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/product">产品</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/activity">活动</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/survey">问卷</a>
                    <a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/article">文章</a>
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
                    <img class="logo" src="http://cdn.softorg.cn:8088/{{$org->logo or ''}}" alt="{{$org->short or 'Home'}}">
                </div>
            </li>
            <li>
                <ul class="first-nav">
                    <li><a href="/org/{{$org->website_name or '1'}}/product" class="big-txt">产品</a></li>
                    <li class="padder">&nbsp;</li>
                    <li><a href="/org/{{$org->website_name or '1'}}/activity" class="big-txt">活动</a></li>
                    <li class="padder">&nbsp;</li>
                    <li><a href="/org/{{$org->website_name or '1'}}/survey" class="big-txt">问卷</a></li>
                    <li class="padder">&nbsp;</li>
                    <li><a href="/org/{{$org->website_name or '1'}}/article" class="big-txt">文章</a></li>
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
                            <h4>{{$org->slogan or ''}}</h4>
                            <h1 class="hero-heading">{{$org->name or 'name'}}</h1>
                            <a href="https://www.vipp.com/en-us/node/241" class="btn-md"><span>SHOP NOW</span></a>
                        </div>
                    </div>
                </div>
            </div>
            {{--4栏--}}
            <div class="row full wrapper-content product-column product-four-column slide-to-top">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3>产品展示</h3>
                            <a href="/org/{{$org->website_name or '1'}}/product" class="hidden-xs">更多产品</a>
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list">
                            @foreach($org->products as $v)
                            <li class="col-md-6 ">
                                <a href="{{url('/product?id=').encode($v->id)}}">
                                    <div class="item ">
                                        <div class="mo">
                                            <div class="super-img" nid style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-14-pedal-bin-1.jpg.pagespeed.ic.wFQ-DleBAd.webp)">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-14-pedal-bin-1.jpg.pagespeed.ic.wFQ-DleBAd.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <span>{{$v->title or ''}}</span>
                                            <span class="price">{{$v->description or ''}}</span>
                                        </div>
                                        <div class="container portrait">
                                            <div class="img-wrapper">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-14-pedal-bin-white-1_0.jpg.pagespeed.ic.SKuYRz75B2.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <p class="seriesnumber">产品</p>
                                            <div class="color-indicator">
                                                <div class="color" style="background: #FFFFFF; border-color: #a0a0a0 ;"></div>
                                                <div class="color" style="background: #000000; border-color: #000000 ;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <a href="/org/{{$org->website_name or '1'}}/product" class="view-more visible-xs">更多产品</a>
                    </div>
                </div>
            </div>
            {{--3栏--}}
            <div class="row full wrapper-content product-column product-four-column product-four-column--wide slide-to-top">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3>活动</h3>
                            <a href="/org/{{$org->website_name or '1'}}/activity" class="hidden-xs">更多活动</a>
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list">
                            @foreach($org->activities as $v)
                            <li class="col-md-6">
                                <a href="{{url('/activity?id=').encode($v->id)}}">
                                    <div class="item no-hover">
                                        <div class="mo">
                                            <div class="super-img" nid style="background-image: url('');">
                                                <img src="">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <span>{{$v->title or ''}}</span>
                                            <span class="price">{{$v->description or ''}}</span>
                                        </div>
                                        <div class="container landscape">
                                            <div class="img-wrapper">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-270-breadbox-white-1_0.jpg.pagespeed.ic.EeJ8X5SIxO.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <p class="seriesnumber">活动</p>
                                            <div class="color-indicator">
                                                <div class="color" style="background: #FFFFFF; border-color: #a0a0a0 ;"></div>
                                                <div class="color" style="background: #000000; border-color: #000000 ;"></div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <a href="/org/{{$org->website_name or '1'}}/activity" class="view-more visible-xs">更多活动</a>
                    </div>
                </div>
            </div>
            {{--4栏--}}
            <div class="row full wrapper-content product-column product-four-column slide-to-top">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3>问卷</h3>
                            <a href="/org/{{$org->website_name or '1'}}/survey" class="hidden-xs">更多</a>
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list">
                            @foreach($org->surveys as $v)
                            <li class="col-md-6 ">
                                <a href="{{url('/survey?id=').encode($v->id)}}">
                                    <div class="item ">
                                        <div class="mo">
                                            <div class="super-img" nid style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-526-pendant-detail_0.jpg.pagespeed.ic.Z1bcj6PfFZ.webp)">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-522-wall-lamp_0.jpg.pagespeed.ic.zcqIwLxVko.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <span>{{$v->title or ''}}</span>
                                            <span class="price">调研问卷</span>
                                        </div>
                                        <div class="container portrait">
                                            <div class="img-wrapper">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-522-wall-lamp-3_0.jpg.pagespeed.ic.sVk_M5nlgg.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <p class="seriesnumber">{{$v->description or ''}}</p>
                                            <div class="color-indicator">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <a href="/org/{{$org->website_name or '1'}}/survey" class="view-more visible-xs">更多</a>
                    </div>
                </div>
            </div>
            {{--图片 2栏--}}
            <div class="row full collection-teaser slide-to-top">
                <div class="col-md-14">
                    <div class="row full">
                        @foreach($org->surveys as $v)
                        <div class="col-xs-7">
                            <div class="hero-story-container fade-onscroll" style="background-image:url(
                                @if(($loop->index)%2 == 0)
                                https://www.vipp.com/sites/default/files/xvipp-9-soap-dispencer-frontpage.jpg.pagespeed.ic.vFd904nBnJ.webp
                                @else
                                https://www.vipp.com/sites/default/files/xvipp-421-side-table-frontpage.jpg.pagespeed.ic.EE_FzpGT5J.webp
                                @endif
                                )">
                                @if(($loop->index)%2 == 0)
                                <img src="https://www.vipp.com/sites/default/files/xvipp-9-soap-dispencer-frontpage.jpg.pagespeed.ic.vFd904nBnJ.webp" alt="">
                                @else
                                <img src="https://www.vipp.com/sites/default/files/xvipp-421-side-table-frontpage.jpg.pagespeed.ic.EE_FzpGT5J.webp" alt="">
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
                    </div>
                </div>
            </div>
            {{--3栏--}}
            <div class="row full wrapper-content product-column product-four-column slide-to-top">
                <div class="col-md-14">
                    <div class="row full">
                        <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                            <h3>文章</h3>
                            <a href="/org/{{$org->website_name or '1'}}/article" class="hidden-xs">更多文章</a>
                        </div>
                        <ul class="col-sm-12 col-xs-14 product-list">
                            @foreach($org->articles as $v)
                            <li class="col-md-6">
                                <a href="{{url('/article?id=').encode($v->id)}}">
                                    <div class="item ">
                                        <div class="mo">
                                            <div class="super-img" nid style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-473-rack-interior-0.jpg.pagespeed.ic.hBsfdHPEoP.webp)">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-473-rack-interior-0.jpg.pagespeed.ic.hBsfdHPEoP.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <span>{{$v->title or ''}}</span>
                                            <span class="price">文章</span>
                                        </div>
                                        <div class="container portrait">
                                            <div class="img-wrapper">
                                                <img src="https://www.vipp.com/sites/default/files/xvipp-475-rack-tall-1_0.jpg.pagespeed.ic.mhnDjOewJo.webp">
                                            </div>
                                        </div>
                                        <div class="line">
                                            <p class="seriesnumber">{{$v->description or ''}}</p>
                                            <div class="color-indicator">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <a href="/org/{{$org->website_name or '1'}}/article" class="view-more visible-xs">更多文章</a>
                    </div>
                </div>
            </div>
            {{--图片 3栏--}}
            <div class="row full slide-to-top">
                <div class="col-xs-14">
                    <div class="mod-stories-thumb no-margin stories-three-columns">
                        <ul class="row">
                            <li class="item-text-on-img fade-onscroll">
                                <a href="https://www.vipp.com/en-us/story/marie-moma-us">
                                    <div class="wrap-img wrap-img--landscape" style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-history-7.jpg.pagespeed.ic.YhMDElRtgK.webp)">
                                        <img src="https://www.vipp.com/sites/default/files/xvipp-history-7.jpg.pagespeed.ic.YhMDElRtgK.webp" alt="" />
                                    </div>
                                    <div class="wrap-img wrap-img--portrait" style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-history-40.jpg.pagespeed.ic.qnAAH-5-FC.webp)">
                                        <img src="https://www.vipp.com/sites/default/files/xvipp-history-40.jpg.pagespeed.ic.qnAAH-5-FC.webp" alt="" />
                                    </div>
                                    <div class="wrap-text">
                                        <h4>story</h4>
                                        <h3>From Marie to MoMA</h3>
                                    </div>
                                </a>
                            </li>
                            <li class="item-text-on-img fade-onscroll">
                                <a href="https://www.vipp.com/en-us/story/designers-pencil-house-us">
                                    <div class="wrap-img wrap-img--landscape" style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-kitchen-family-1_1.jpg.pagespeed.ic.rtSiDH6om_.webp)">
                                        <img src="https://www.vipp.com/sites/default/files/xvipp-kitchen-family-1_1.jpg.pagespeed.ic.rtSiDH6om_.webp" alt="" />
                                    </div>
                                    <div class="wrap-img wrap-img--portrait" style="background-image:url(https://www.vipp.com/sites/default/files/xvipp-kitchen-family-2_2.jpg.pagespeed.ic.puIu-935O2.webp)">
                                        <img src="https://www.vipp.com/sites/default/files/xvipp-kitchen-family-2_2.jpg.pagespeed.ic.puIu-935O2.webp" alt="" />
                                    </div>
                                    <div class="wrap-text">
                                        <h4>story</h4>
                                        <h3>The designer's pencil house</h3>
                                    </div>
                                </a>
                            </li>
                            <li class="item-text-on-img fade-onscroll">
                                <a href="https://www.vipp.com/en-us/story/aesop-paris-hq-us">
                                    <div class="wrap-img wrap-img--landscape" style="background-image:url(https://www.vipp.com/sites/default/files/xaesop-fr-headoffice-1-0.jpg.pagespeed.ic.Kc0P2vLWOZ.webp)">
                                        <img src="https://www.vipp.com/sites/default/files/xaesop-fr-headoffice-1-0.jpg.pagespeed.ic.Kc0P2vLWOZ.webp" alt="" />
                                    </div>
                                    <div class="wrap-img wrap-img--portrait" style="background-image:url(https://www.vipp.com/sites/default/files/xaesop-fr-headoffice-7-0.jpg.pagespeed.ic.yD423MXL9x.webp)">
                                        <img src="https://www.vipp.com/sites/default/files/xaesop-fr-headoffice-7-0.jpg.pagespeed.ic.yD423MXL9x.webp" alt="" />
                                    </div>
                                    <div class="wrap-text">
                                        <h4>story</h4>
                                        <h3>Aesop Paris office</h3>
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
</body>

</html>