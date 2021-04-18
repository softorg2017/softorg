{{--header--}}
<header id="site-header" class="header-container" style="">

    {{--选择语言--}}
    <div id="site-header-top" class="_none">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="clearfix">
                        <button class="btn btn-warning btn-lg header-btn visible-sm pull-right">List your Property for Free</button>
                        <p class="timing-in-header">Open Hours: Monday to Saturday - 8am to 6pm</p>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="clearfix">
                        <button class="btn btn-warning btn-lg header-btn hidden-sm">List your Property for Free</button>
                        <div class="language-in-header">
                            <i class="fa fa-globe"></i>
                            <label for="language-dropdown"> Language:</label>
                            <select name="currency" id="language-dropdown">
                                <option value="ENG">ENG</option>
                                <option value="AR">AR</option>
                                <option value="UR">UR</option>
                                <option value="NEO">NEO</option>
                                <option value="AKA">AKA</option>
                            </select>
                        </div>
                        <div class="currency-in-header">
                            <i class="fa fa-flag"></i>
                            <label for="currency-dropdown"> Currency: </label>
                            <select name="currency" id="currency-dropdown">
                                <option value="USD">USD</option>
                                <option value="EUR">EUR</option>
                                <option value="AOA">AOA</option>
                                <option value="XCD">XCD</option>
                                <option value="PKR">PKR</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{--header--}}
    <div class="full-screen">

        <div class="header-site pull-left" id="site-logo">

            <div class="logo-site pull-left">
                <a href="{{ url('/') }}"><img src="{{ url(config('company.info.logo')) }}" alt="Logo"></a>
                <a href="{{ url('/') }}"><b>{{ config('company.info.name') }}</b></a>
            </div>

        </div>


        <a href="javascript:void(0);" rel="nofollow" class="header-burger-menu visible-xs visible-sm"><i>Menu</i></a>

        <div class="header-site pull-right">

            <nav class="nav-site pull-left hidden-xs hidden-sm" id="nav-site">

                <a href="javascript:void(0);" rel="nofollow" class="header-burger-menu visible-xs visible-sm"><i>Menu</i></a>

                <ul class="nav-bar">

                    <li><a href="{{ url('/') }}">首页</a></li>
                    <li><a href="{{ url('/product/list') }}">产品服务</a></li>
                    <li><a href="{{ url('/template/list') }}">模板展示</a></li>
                    <li><a href="{{ url('/coverage/list') }}">资讯动态</a></li>
                    <li><a href="{{ url('/contact') }}">联系我们</a></li>

                    {{--<li class="nav_nohover hlzb"  drop-down='downlist4'>--}}
                        {{--<a href="{{ url('/item/list') }}">下拉框</a>--}}
                        {{--<div class="downlist downlist4 _none" style="">--}}
                            {{--<div class="d_menu">--}}
                                {{--@foreach($header_items as $v)--}}
                                {{--<a href="{{ url('/item/'.$v->id) }}">{{ $v->title or '' }}</a>--}}
                                {{--@endforeach--}}
                            {{--</div>--}}
                        {{--</div>--}}
                    {{--</li>--}}

                    <li class="header-box header-taobao taobao-box" role="button">
                        <a href="https://shop62683376.taobao.com">
                            <i class="icon"><img src="/common/images/icons/icon_taobao_1.png" alt=""></i> <b>淘宝店铺</b>
                        </a>
                    </li>

                    <li class="header-box header-wechat wechat-box" role="button">
                        <a href="javascript:void(0);" rel="nofollow">
                            <i class="fa fa-weixin"></i> <b>微信公众号</b>
                        </a>
                        <span class="image-box">
                            <img src="{{ config('company.info.wechat_qrcode') }}" alt="Wechat QRCode">
                        </span>
                    </li>

                    <li class="mobile-box">
                        <div class="mobile-icon-inn">
                            <i class="fa fa-mobile"></i>
                        </div>
                        <div class="mobile-main-inn">
                            <a href="tel:{{ config('company.info.telephone') }}">
                                <b>{{ config('company.info.telephone') }}</b>
                            </a>
                            {{--<span class="text-row"><b>24Hours</b></span><br>--}}
                            {{--<span class="number-row">--}}
                            {{--<a href="tel:{{ config('company.info.telephone') }}"><b>{{ config('company.info.telephone') }}</b></a>--}}
                            {{--</span>--}}
                        </div>
                    </li>

                </ul>
            </nav>
            <div class="extra-text visible-xs- visible-sm- _none">
                <h5 class="mb20"></h5>
                <ul class="social-buttons header-social _none">
                    <li><a target="_blank" href="http://www.wechat.com">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-wechat.png') }}" alt="WeChat Logo">
                        </a></li>
                    <li><a target="_blank" href="http://www.linkedin.com/company/keron-international-relocation-movers/">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-linkedin.png') }}" alt="Linkedin Logo">
                        </a></li>
                    <li><a target="_blank" href="https://moveaide.com/movers/keron-international-relocation-shanghai-china-mover-reviews">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-moveaide.png') }}" alt="MoveAide Logo">
                        </a></li>
                    <li><a target="_blank" href="http://www.smartshanghai.com/venue/15561/keron_international_relocation_and_movers_zhongshan_bei_lu">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-smart.png') }}" alt="Instagram Logo">
                        </a></li>
                    <li><a target="_blank" href="http://www.thatsmags.com/shanghai">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-thats.png') }}" alt="Instagram Logo">
                        </a></li>
                    <li><a target="_blank" href="https://www.baidu.com/">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-baidu.png') }}" alt="Instagram Logo">
                        </a></li>
                    <li><a target="_blank" href="https://plus.google.com/">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-google.png') }}" alt="Google Plus Logo">
                        </a></li>
                    <li style="display: none;"><a target="_blank" href="https://www.facebook.com/">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-facebook.png') }}" alt="Facebook Logo">
                        </a></li>
                    <li style="display: none;"><a target="_blank" href="https://twitter.com/">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-twitter.png') }}" alt="Twitter Logo">
                        </a></li>
                    <li style="display: none;"><a target="_blank" href="https://instagram.com/">
                            <img src="{{ asset('/common/images/logo-icon/icon-logo-instagram.png') }}" alt="Instagram Logo">
                        </a></li>
                </ul>
                <p><small>&copy; Copyright©2018. KERON All Rights Reserved.</small></p>
            </div>

        </div>

    </div>

</header>