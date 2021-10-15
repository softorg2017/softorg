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

    <title>@yield('head_title')</title>
    <meta name="title" content="@yield('meta_title')" />
    <meta name="author" content="@yield('meta_author')" />
    <meta name="description" content="@yield('meta_description')" />
    <meta name="keywords" content="@yield('meta_keywords')" />
    <meta name="robots" content="all" />
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

    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/css/fileinput.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/bootstrap-fileinput-4.4.8.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lib/css/fileinput-only.css') }}">

    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.css') }}">

    {{--<link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">--}}
    <link rel="stylesheet" href="/AdminLTE/plugins/iCheck/all.css">

    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">--}}
    {{--<link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/bootstrap-datetimepicker-4.17.47.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lib/css/bootstrap-datepicker-1.9.0.min.css') }}">

    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/layer/3.0.3/skin/moon/style.min.css">--}}
    {{--<link rel="stylesheet" href="{{ asset('/lib/css/layer-style-3.0.3.min.css') }}">--}}
    {{--<link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/layer/3.1.1/theme/moon/style.min.css">--}}
    {{--<link rel="stylesheet" href="{{ asset('/lib/css/layer-style-3.1.1.min.css') }}">--}}


    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap-switch/3.3.4/css/bootstrap3/bootstrap-switch.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/bootstrap-switch-3.3.4.min.css') }}">

    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/Swiper/4.2.2/css/swiper.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/swiper-4.2.2.min.css') }}">

    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/fancybox/3.3.5/jquery.fancybox.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/jquery.fancybox-3.3.5.css') }}">

    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/lightcase/2.5.0/css/lightcase.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/lightcase-2.5.0.min.css') }}">

    {{--<link rel="stylesheet" href="https://cdn.bootcdn.net/ajax/libs/timelinejs/3.6.6/css/timeline.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/timeline-3.6.6.min.css') }}">


    <link type="text/css" rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('css/frontend/index.css') }}">


    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/common.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend.css') }}" media="all" />

    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/style.min.css') }}" media="all" />

    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/index.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/item.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/frontend/menu.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/backend/index.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/animate/wicked.css') }}" media="all" />
    <link type="text/css" rel="stylesheet" href="{{ asset('common/css/animate/hover.css') }}" media="all" />

    @yield('css')
    @yield('style')
    @yield('custom-css')
    @yield('custom-style')

    <style>
        /*.item-piece img { background:url("/common/images/bg/background-image.png");background-size:cover; }*/

        .header-logo {
            -webkit-transition: width .3s ease-in-out;
            -o-transition: width .3s ease-in-out;
            transition: width .3s ease-in-out;
            display: block;
            float: left;
            height: 50px;
            font-size: 20px;
            line-height: 50px;
            text-align: center;
            width: calc(100% - 584px);
            font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
            padding: 0 15px;
            font-weight: 300;
            color:#fff;
            overflow: hidden;
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
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">


    {{--main-header--}}
    @include(env('TEMPLATE_ADMIN').'frontend.layout.main-header')

    {{--main-sidebar--}}
    @include(env('TEMPLATE_ADMIN').'frontend.layout.main-sidebar')

    {{--main-content--}}
    @include(env('TEMPLATE_ADMIN').'frontend.layout.main-content')

    {{--main-footer--}}
    @include(env('TEMPLATE_ADMIN').'frontend.layout.main-footer')

    {{--control-sidebar--}}
    @include(env('TEMPLATE_ADMIN').'frontend.layout.control-sidebar')


</div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->

{{--<!-- jQuery 2.2.3 -->--}}
<script src="/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js"></script>
{{--<!-- Bootstrap 3.3.6 -->--}}
<script src="/AdminLTE/bootstrap/js/bootstrap.min.js"></script>
{{--<!-- AdminLTE App -->--}}
<script src="/AdminLTE/dist/js/app.min.js"></script>

{{--<script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>--}}
{{--<script src="{{ asset('/lib/js/icheck-1.0.2.min.js') }}"></script>--}}
<script src="/AdminLTE/plugins/iCheck/icheck.min.js"></script>

<script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('AdminLTE/plugins/datatables/dataTables.bootstrap.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
<script src="{{ asset('/lib/js/jquery-ui-1.12.1.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>--}}
<script src="{{ asset('/lib/js/jquery.cookie-1.4.1.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-modal/2.2.6/js/bootstrap-modal.min.js"></script>--}}
{{--<script src="{{ asset('/lib/js/bootstrap-modal-2.2.6.min.js') }}"></script>--}}

{{--<script src="https://cdn.bootcss.com/layer/3.0.3/layer.min.js"></script>--}}
<script src="{{ asset('/lib/js/layer-3.0.3.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-fileinput/4.4.3/js/fileinput.min.js"></script>--}}
<script src="{{ asset('/lib/js/fileinput-4.4.8.min.js') }}"></script>
<script src="{{ asset('/lib/js/fileinput-only.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/jquery.form/4.2.2/jquery.form.min.js"></script>--}}
<script src="{{ asset('/lib/js/jquery.form-4.2.2.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/moment.js/2.19.0/moment.min.js"></script>--}}
<script src="{{ asset('/lib/js/moment-2.19.0.min.js') }}"></script>
<script src="{{ asset('/lib/js/moment-2.19.0-locale-zh-cn.js') }}"></script>
<script src="{{ asset('/lib/js/moment-2.19.0-locale-ko.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/bootstrap-switch/3.3.4/js/bootstrap-switch.min.js"></script>--}}
<script src="{{ asset('/lib/js/bootstrap-switch-3.3.4.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/Swiper/4.2.2/js/swiper.min.js"></script>--}}
<script src="{{ asset('/lib/js/swiper-4.2.2.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/jquery.sticky/1.0.4/jquery.sticky.min.js"></script>--}}
<script src="{{ asset('/lib/js/jquery.sticky-1.0.4.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/fancybox/3.3.5/jquery.fancybox.js"></script>--}}
<script src="{{ asset('/lib/js/jquery.fancybox-3.3.5.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/lightcase/2.5.0/js/lightcase.min.js"></script>--}}
<script src="{{ asset('/lib/js/lightcase-2.5.0.min.js') }}"></script>

{{--<script src="https://cdn.bootcss.com/Readmore.js/2.2.0/readmore.min.js"></script>--}}
<script src="{{ asset('/lib/js/readmore-2.2.0.min.js') }}"></script>


{{--<script src="https://cdn.bootcdn.net/ajax/libs/timelinejs/3.6.6/js/timeline-min.min.js"></script>--}}
{{--<script src="https://cdn.bootcdn.net/ajax/libs/timelinejs/3.6.6/js/timeline.min.js"></script>--}}
<script src="{{ asset('/lib/js/timeline-min-3.6.6.min.js') }}"></script>
<script src="{{ asset('/lib/js/timeline-3.6.6.min.js') }}"></script>


{{--<script src="https://cdn.bootcss.com/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>--}}
{{--<script src="https://cdn.bootcdn.net/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>--}}
{{--<script src="https://cdn.bootcdn.net/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.zh-CN.min.js"></script>--}}
<script src="{{ asset('/lib/js/bootstrap-datetimepicker-4.17.47.min.js') }}"></script>
{{--<script src="{{ asset('/lib/js/bootstrap-datepicker-1.9.0.zh-CN.min.js') }}"></script>--}}
<script src="{{ asset('/lib/js/bootstrap-datepicker-1.9.0.min.js') }}"></script>


<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
{{--<script src="http://res.wx.qq.com/open/js/jweixin-1.4.0.js"></script>--}}
{{--<script src="http://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>--}}
<script>

    var wechat_config = {!! $wechat_config or '' !!};
    console.log(wechat_config.cache);
    var timestamp = Date.parse(new Date());
    var time = Date.parse(new Date());
    console.log(timestamp / 1000 - wechat_config.timestamp);
    console.log(new Date(wechat_config.timestamp * 1000).toLocaleString());

    $(function()
    {
//        var link = window.location.href;
        var link = location.href.split('#')[0];
        console.log(link);

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
//                    'updateAppMessageShareData',
//                    'updateTimelineShareData',
                    'onMenuShareAppMessage',
                    'onMenuShareTimeline',
                    'onMenuShareQQ',
                    'onMenuShareQZone',
                    'onMenuShareWeibo'
                ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
            });

            wx.checkJsApi({
                jsApiList: [
                    'checkJsApi',
//                    'updateAppMessageShareData',
//                    'updateTimelineShareData',
                    'onMenuShareAppMessage',
                    'onMenuShareTimeline',
                    'onMenuShareQQ',
                    'onMenuShareQZone',
                    'onMenuShareWeibo'
                ], // 需要检测的JS接口列表，所有JS接口列表见附录2,
                success: function(res) {
                    // 以键值对的形式返回，可用的api值true，不可用为false
                    // 如：{"checkResult":{"chooseImage":true},"errMsg":"checkJsApi:ok"}
                }
            });


            {{--wx.ready(function () {   //需在用户可能点击分享按钮前就先调用--}}

                {{--wx.updateAppMessageShareData({--}}
                    {{--title: "@yield('wx_share_title')", // 分享标题--}}
                    {{--desc: "@yield('wx_share_desc')", // 分享描述--}}
                    {{--link: link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致--}}
                    {{--imgUrl: $.trim("@yield('wx_share_imgUrl')"), // 分享图标--}}
                    {{--success: function () {--}}
                        {{--// 用户点击了分享后执行的回调函数--}}
                        {{--console.log("updateAppMessageShareData");--}}
                        {{--$.post(--}}
                            {{--"/record/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'record_module': 1,--}}
                                {{--'page_type': "{{ $page["type"] or '0' }}",--}}
                                {{--'page_module': "{{ $page["module"] or '0' }}",--}}
                                {{--'page_num': "{{ $page["num"] or '1' }}",--}}
                                {{--'item_id': "{{ $page["item_id"] or '0' }}",--}}
                                {{--'user_id': "{{ $page["user_id"] or '0' }}"--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--},--}}
                        {{--'json');--}}
                    {{--}--}}
                {{--});--}}
                {{--wx.updateTimelineShareData({--}}
                    {{--title: "@yield('wx_share_title')",--}}
                    {{--desc: "@yield('wx_share_desc')",--}}
                    {{--link: link,--}}
                    {{--imgUrl: $.trim("@yield('wx_share_imgUrl')"),--}}
                    {{--success: function () {--}}
                        {{--// 用户点击了分享后执行的回调函数--}}
                        {{--console.log("updateTimelineShareData");--}}
                        {{--$.post(--}}
                            {{--"/record/share",--}}
                            {{--{--}}
                                {{--'_token': $('meta[name="_token"]').attr('content'),--}}
                                {{--'record_module': 2,--}}
                                {{--'page_type': "{{ $page["type"] or '0' }}",--}}
                                {{--'page_module': "{{ $page["module"] or '0' }}",--}}
                                {{--'page_num': "{{ $page["num"] or '1' }}",--}}
                                {{--'item_id': "{{ $page["item_id"] or '0' }}",--}}
                                {{--'user_id': "{{ $page["user_id"] or '0' }}"--}}
                            {{--},--}}
                            {{--function(data) {--}}
                                {{--if(!data.success) layer.msg(data.msg);--}}
                            {{--},--}}
                        {{--'json');--}}
                    {{--}--}}
                {{--});--}}

            {{--});--}}

//            wx.ready(function () {   //需在用户可能点击分享按钮前就先调用
//            });

            wx.ready(function() {

                wx.onMenuShareAppMessage({
                    title: "@yield('wx_share_title')",
                    desc: "@yield('wx_share_desc')",
                    link: link,
                    imgUrl: $.trim("@yield('wx_share_imgUrl')"),
                    success: function () {
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 1,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
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
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 2,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
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
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 1,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
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
                        $.post(
                            "/record/share",
                            {
                                '_token': $('meta[name="_token"]').attr('content'),
                                'record_module': 2,
                                'page_type': "{{ $page["type"] or '0' }}",
                                'page_module': "{{ $page["module"] or '0' }}",
                                'page_num': "{{ $page["num"] or '1' }}",
                                'item_id': "{{ $page["item_id"] or '0' }}",
                                'user_id': "{{ $page["user_id"] or '0' }}"
                            },
                            function(data) {
                                if(!data.success) layer.msg(data.msg);
                            },
                            'json');
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
                        // 用户点击了分享后执行的回调函数
                    },
                    cancel: function () {
                        // 用户取消分享后执行的回调函数
                    }
                });

            });
        }
    });
</script>


<script src="{{asset('js/frontend/index.js')}}"></script>
<script>
    $(function() {
//        $('article').readmore({
//            speed: 150,
//            moreLink: '<a href="#">展开更多</a>',
//            lessLink: '<a href="#">收起</a>'
//        });

        $('.lightcase-image').lightcase({
            maxWidth: 9999,
            maxHeight: 9999
        });

        var viewportSize = $(window).height();
        var lazy_load = function(){
            var scrollTop = $(window).scrollTop();
            $("img").each(function(){
                var _this = $(this);
                var x = viewportSize + scrollTop + _this.position().top;
                if(x>0){
                    _this.attr("src",_this.attr("data-src"));
                }
            })
        };
//        setInterval(lazy_load,1000);

    });
</script>

@yield('js')
@yield('script')
@yield('custom-js')
@yield('custom-script')



</body>
</html>
