<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10">
<![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="en-us" dir="ltr">

<head profile="http://www.w3.org/1999/xhtml/vocab">
    <title>@yield('head_title')</title>
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

    <link href="https://cdn.bootcss.com/Swiper/4.2.2/css/swiper.min.css" rel="stylesheet">

    <link type="text/css" rel="stylesheet" href="{{ asset('frontend/themes/vipp/css/all.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/common.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/index.css') }}" media="all" />

    @yield('custom-css')
    @yield('custom-style')

    
</head>

<body class="html front not-logged-in one-sidebar sidebar-first page-node page-node- page-node-1864 node-type-front-page i18n-en-us has-cookie front-page">
    <script>
    var active_country = "US";
    </script>

    {{--header--}}
    @include(config('common.org.view.frontend.online').'.component.header')

    {{--main--}}
    <div class="wrapper-main-content style-main style-{{ $org->style or '0' }}" style="padding-bottom:64px;">
        <div class="container-fluid ">

            {{--custom-content--}}
            @yield('custom-content')

        </div>
    </div>

    <div class="overlay"></div>
    <div class="overlay"></div>

    {{--footer--}}
    @include(config('common.org.view.frontend.online').'.component.footer')



    <script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdn.bootcss.com/Swiper/4.2.2/js/swiper.min.js"></script>

    <script src="{{ asset('/frontend/themes/vipp/js/jm.js') }}"></script>
    <script src="{{ asset('/frontend/themes/vipp/js/jc.js') }}"></script>
    <script src="{{ asset('frontend/themes/vipp/js/all.js') }}"></script>
    <script src="{{ asset('common/js/index.js') }}"></script>

    <script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
     <script>

        var wechat_config = {!! $wechat_config or '' !!};

        $(function(){

//        var link = window.location.href;
            var link = location.href.split('#')[0];

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
                        title: "@yield('wx_share_title')",
                        desc: "@yield('wx_share_desc')",
                        link: link,
                        dataUrl: '',
                        imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            wechat_share("@yield('wechat_share_website_name')", "@yield('wechat_share_page_id')", "@yield('wechat_share_sort')", "@yield('wechat_share_module')", 1);
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareTimeline({
                        title: "@yield('wx_share_title')",
                        desc: "@yield('wx_share_desc')",
                        link: link,
                        imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            wechat_share("@yield('wechat_share_website_name')", "@yield('wechat_share_page_id')", "@yield('wechat_share_sort')", "@yield('wechat_share_module')", 2);
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareQQ({
                        title: "@yield('wx_share_title')",
                        desc: "@yield('wx_share_desc')",
                        link: link,
                        imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            wechat_share("@yield('wechat_share_website_name')", "@yield('wechat_share_page_id')", "@yield('wechat_share_sort')", "@yield('wechat_share_module')", 3);
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareQZone({
                        title: "@yield('wx_share_title')",
                        desc: "@yield('wx_share_desc')",
                        link: link,
                        imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            wechat_share("@yield('wechat_share_website_name')", "@yield('wechat_share_page_id')", "@yield('wechat_share_sort')", "@yield('wechat_share_module')", 4);
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                    wx.onMenuShareWeibo({
                        title: "@yield('wx_share_title')",
                        desc: "@yield('wx_share_desc')",
                        link: link,
                        imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                        success: function () {
                            // 用户确认分享后执行的回调函数
                            wechat_share("@yield('wechat_share_website_name')", "@yield('wechat_share_page_id')", "@yield('wechat_share_sort')", "@yield('wechat_share_module')", 5);
                        },
                        cancel: function () {
                            // 用户取消分享后执行的回调函数
                        }
                    });
                })   ;
            }
        });
    </script>

    <script>
        var swiper = new Swiper('.swiper-container', {
            spaceBetween: 30,
            centeredSlides: true,
            autoplay: {
                delay: 1800,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });
    </script>

    @yield('custom-js')
    @yield('custom-script')

</body>

</html>