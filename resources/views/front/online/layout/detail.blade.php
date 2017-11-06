@extends('front.'.config('common.view.front.template').'.layout.app')

@section('css')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/frontend/css/list_1.0.0.css')}}">
    <style>
        img {max-width: 100%;}
    </style>
    @yield('css—ext')
@endsection

@section('content')
    @include('front.'.config('common.view.front.template').'.layout.header')
    <div class="list-banner mask"></div>

    <section id="portfolio" class="list-warp-cont">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="detail-left">
                        <h1 class="title">@yield('data—title')</h1>
                        <h4 class="title" style="color:#36a;">@yield('data-header-ext')</h4>
                        <div class="sub-tag clearfix">
                            <span class="sub-tag-time"><i class="iconfont icon-eye"></i>@yield('visit')</span>
                            <p>@yield('data-updated_at')</p>
                        </div>
                        <div class="detail-left-cont">
                            @yield('data-content')
                        </div>
                    </div>
                </div>
                <div class="col-md-3" style="display: none;">
                    <div class="detail-right">
                        <div class="detail-right-box">
                            <p class="detail-right-title">项目环境</p>
                            <p>开发难度：</p>
                            <p>人员配置：3人，5个工作日</p>
                            <p class="datail-right-num">内部单号：P17053136-Q</p>
                            <a href="javascript:;" class="btn-zx">咨询项目顾问</a>
                            <div class="right-intro">
                                <h4 class="right-intro-title">项目简介</h4>
                                <p>
                                    业内知名设计总监，资深用户体验专家、中国十佳UI设计师、UI中国特聘顾问、dribbble邀请会员、南京艺术学院专家团成员。2000年始从事UI设计，10余年间，服务过众多海内外客户，包括印尼初创企业MIGO、国内传统企业托尔防雷、金融类翘楚华博金服、百度海外、启橙少儿英语、UI中国、搜狗、小米旗下紫米电商、日本女性创意百货龙头企业寇吉特（COGIT）、南京设计廊等。</p>
                            </div>
                        </div>
                        <div class="detail-share">
                            <div class="bdsharebuttonbox bdshare-button-style0-16" data-bd-bind="1507911388560">
                                <a href="#" class="share-icon tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                                <a href="#" class="share-icon qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                                <a href="#" class="share-icon tqq" data-cmd="tqq" title="分享到QQ"></a>
                                <a href="#" class="share-icon weixin" data-cmd="weixin" title="分享到微信"></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            @yield('data-content-ext')
        </div>
    </section>

    @include('front.'.config('common.view.front.template').'.layout.footer')
@endsection

@section('js')

    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script>
        $(function () {

            $('body').addClass('fp-viewing-0 gary-bg');
            var portfolio = $('#portfolio');
            var portfolit_offsetTop = portfolio.offset().top - $('#nav').height();

            $(document).on('scroll', function () {
                var win_scrollTop = $(window).scrollTop();
                var size = win_scrollTop - portfolit_offsetTop;
                if (size > 0) {
                    $('#nav').addClass('black');
                    $('#nav_current').addClass('changed').children('a').html("@");
                } else {
                    $('#nav').removeClass('black');
                    $('#nav_current').removeClass('changed').children('a').html("");
                }

            });
        })
    </script>
    <script>
        window._bd_share_config = {
            "common": {
                "bdSnsKey": {},
                "bdText": "",
                "bdMini": "2",
                "bdPic": "",
                "bdStyle": "0",
                "bdSize": "16"
            },
            "share": {},
            "image": {
                "viewList": ["qzone", "tsina", "tqq", "renren", "weixin"],
                "viewText": "分享到：",
                "viewSize": "16"
            },
            "selectShare": {
                "bdContainerClass": null,
                "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]
            }
        };
        with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
    </script>

    @yield('js—ext')
@endsection
