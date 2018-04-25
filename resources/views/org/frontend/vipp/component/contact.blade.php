{{--联系我们--}}
<div class="row full slide-to-top contact-contain" id="contact" style="display:none;margin-top:48px;">
    <div class="col-md-14" style="margin-bottom:0px;">
        <div class="row full">
            <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                <h3 class="menu-title" style="">联系方式</h3>
            </div>
        </div>
    </div>
    <ul class="col-sm-12 col-xs-14 product-list" style="width:100%;height:auto;display:none;">
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


{{--图片 2栏--}}
<div class="row full collection-teaser slide-to-top" style="display: none;">
    <div class="col-md-14">
        <div class="row full">
            @if(false)
                @foreach($org->surveys as $v)
                    <div class="col-xs-7">
                        <div class="hero-story-container fade-onscroll" style="
                        @if(($loop->index)%2 == 0) background-image:url(/images/black-v.jpg)
                        @else background-image:url(/images/black-v.jpg)
                        @endif
                                ">
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