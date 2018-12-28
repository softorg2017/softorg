{{--footer--}}
<footer class="footer-container" id="footer">
    <div class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-6">
                    <section class="widget about-widget clearfix">
                        <h4 class="title hide">关于我们</h4>
                        <a class="footer-logo" href="javascript:void(0);">
                            <img src="{{ url('/logo.png') }}" alt="Footer Logo" style="width:80px;">
                            {{--<img src="{{ config('company.info.logo') }}" alt="Footer Logo">--}}
                            {{ config('company.info.name') }}
                        </a>
                        <p>{{ config('company.info.description') }}</p>
                        <ul class="social-icons clearfix">
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-pinterest"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-youtube-play"></i></a></li>
                        </ul>
                    </section>
                </div>
                <div class="col-md-2 col-sm-6">
                    <section class="widget twitter-widget clearfix">
                        <h4 class="title"></h4>
                        <div id="twitter-feeds" class="clearfix"></div>
                    </section>
                </div>
                <div class="col-md-4 col-sm-6">
                    <section class="widget address-widget clearfix">
                        <h4 class="title">联系我们</h4>
                        <ul>
                            <li><i class="fa fa-copyright"></i> {{ config('company.info.name') }} </li>
                            <li><i class="fa fa-map-marker"></i> {{ config('company.info.address') }} </li>
                            <li><i class="fa fa-user"></i> {{ config('company.info.linkman') }} </li>
                            <li><i class="fa fa-phone"></i> <a href="tel:{{ config('company.info.mobile') }}">{{ config('company.info.mobile') }}</a> </li>
                            <li><i class="fa fa-envelope"></i> <a href="mailto:{{ config('company.info.email') }}">{{ config('company.info.email') }}</a> </li>
                            <li><i class="fa fa-clock-o"></i> 周一 - 周五: 9:00 - 18:00 </li>
                        </ul>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <div class="site-footer-bottom _none">
        <div class="container">
            {{--<p class="copyright pull-left wow slideInRight">Copyright © 2018.{{ config('company、.info.name') }} All rights reserved.</p>--}}
            <p class="copyright pull-left wow slideInRight">Copyright © 2018.寻觅e家 All rights reserved.</p>
            <nav class="footer-nav pull-right wow slideInLeft">
                <ul>
                    <li><a href="{{ url('/rent-out') }}">钢琴出租</a></li>
                    <li><a href="{{ url('/contact') }}">联系我们</a></li>
                </ul>
            </nav>
        </div>
    </div>
    <div class="site-footer-bottom">
        <div class="container">
            <div class="row mt10 mb10">
                <div class="col-md-12 text-center">
                    <div>
                        <small> Copyright&copy;2018. {{ config('company.info.english_name') }} 上海如哉网络有限公司.</small><br>
                    </div>
                    <div>
                        <small>
                            <strong>软件开发</strong> |
                            <strong>企业建站</strong> |
                            <strong>微信开发</strong> |
                            <strong>小程序开发</strong> |
                            <strong>全年无休上门服务</strong>
                        </small>
                    </div>
                    <div>
                        <a target="_blank" href="http://www.miitbeian.gov.cn">沪ICP备18045960号-1</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>