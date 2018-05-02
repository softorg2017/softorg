{{--footer--}}
<div class="wrapper-footer-container" id="contact">
    <div class="col-md-14">
        <div class="row full block-in">
            <div class="row footer-title-row"><b>企业简介</b></div>
            <div class="row">
                {{$org->description or '暂无简介'}}
            </div>
        </div>
        <div class="row">&nbsp;</div>
    </div>
    <div class="col-md-14">
        <div class="row full block-in">

            <div class="row footer-title-row"><b>网站地图</b></div>
            <div class="row">
                @foreach($org->menus as $menu)
                    <a href="{{ url(config('common.org.front.prefix').'/menu/'.encode($menu->id)) }}">{{ $menu->title }}</a>
                    @if(!$loop->last)|@endif
                @endforeach
            </div>
            <div class="row">&nbsp;</div>

            <div class="row footer-title-row">
                <b>联系方式</b>
                <div class="footer-block-row">
                    @if(!empty($org->wechat_qrcode))
                    <div class="footer-block">
                        <div class="footer-block-top">
                            <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$org->wechat_qrcode }}"/>
                        </div>
                        <div class="footer-block-bottom">
                            微信二维码
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @if(!empty($org->address))
                <div class="row"><i class="fa fa-location-arrow"></i> 地址： {{$org->address or ''}}</div>
            @endif
            @if(!empty($org->mobile))
                <div class="row"><i class="fa fa-phone"></i> 电话： {{$org->mobile or ''}}</div>
            @endif
            @if(!empty($org->email))
                <div class="row"><i class="fa fa-envelope"></i> 邮箱： {{$org->email or ''}}</div>
            @endif
            @if(!empty($org->wechat_id))
                <div class="row"><i class="fa fa-weixin"></i> 微信： {{$org->wechat_id or ''}}</div>
            @endif
            @if(!empty($org->weibo_name))
                <div class="row"><i class="fa fa-weibo"></i> 微博：
                    @if(!empty($org->weibo_address))
                        <a target="_blank" href="{{$org->weibo_address or ''}}">{{$org->weibo_name or ''}}</a>
                    @else
                        {{$org->weibo_name or ''}}
                    @endif
                </div>
            @endif

            <div class="row">&nbsp;</div>
            <div class="row">技术支持 <a target="_blank" href="http://softorg.cn">©上海如哉网络科技有限公司</a></div>
            <div class="row"><a target="_blank" href="http://www.miitbeian.gov.cn">沪ICP备17052782号-1</a></div>
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