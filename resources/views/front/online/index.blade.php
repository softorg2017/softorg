@extends('front.'.config('common.view.front.template').'.layout.app')

@section('title')
    {{$org->name or ''}}
@endsection
@section('header')
    {{$org->name or ''}}
@endsection
@section('description')
    {{$org->name or ''}}
@endsection

@section('index-url',url(config('common.website.front.prefix').'/'.$org->website_name))

@section('content')
    @include('front.'.config('common.view.front.template').'.layout.header')

    <div id="fullpage">
        <div id="index" class="section index mask loaded">
            <div class="index-container">
                <h1>{{$org->name or ''}}</h1>
                <p>
                    @foreach(preg_split('/(?<!^)(?!$)/u', $org->slogan) as $v)
                        <span>{{$v}}</span>
                    @endforeach
                </p>
            </div>

            <a id="index_next" href="javascript:void(0);" class="index-next">
                下一页
            </a>
        </div>

        <div id="introduction" class="section introduction ">
            <div class="introduction-container js-load">
                <div class="introduction-left">{{$org->name or ''}}</div>
                <div class="introduction-right">
                    <span class="introduction-right-top"></span>
                    <span class="introduction-top-text ">{{$org->slogan or ''}}</span>
                    <span class="introduction-right-bottom"></span>
                    <span class="introduction-bottom-text ">{{$org->slogan or ''}}</span>
                    <div class="introduction-content">
                        {{$org->description or ''}}
                    </div>
                </div>
            </div>
            <div id="introduction_logo_container" class="introduction-logo-container">
                <p>合作伙伴</p>
                <a href="javascript:void(0);" id="introduction_close_btn" class="introduction-close-btn"></a>
                <div class="introduction-logos">
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_01.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_02.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_03.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_04.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_05.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_06.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_07.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_08.png')}}" alt="">
                    </span>
                </div>
            </div>
        </div>

        <div id="business" class="section business ">
            <div class="business-container clearfix js-load">
                @foreach($org->products as $v)
                    <a href="{{url('/product?id=').encode($v->id)}}">
                    <div class="col-4">
                        <div class="business-icon">
                            <img src="{{asset('/frontend/images/img_02.png')}}" alt="">
                            <img src="{{asset('/frontend/images/img_03.png')}}" alt="" style="display: none;">
                            <img src="{{asset('/frontend/images/img_04.png')}}" alt="" style="display: none;">
                        </div>
                        <div class="business-title">{{$v->title or ''}}</div>
                        <p class="business-desc">
                            {{$v->description or ''}}
                        </p>
                    </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div id="activity" class="section advantage " style="background-color: #fff">
            <div class="advantage-container">
                @foreach($org->activities as $v)
                    <a href="{{url('/activity?id=').encode($v->id)}}">
                    <div class="col-4">
                        <div class="title">{{$v->title or ''}}</div>
                        <div class="content">
                            {{$v->description or ''}}
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div id="survey" class="section case ">
            <div class="case-container js-load">
                @foreach($org->surveys as $v)
                    <a href="{{url('/survey?id=').encode($v->id)}}">
                    <div class="col-4">
                        <div class="case-img">
                            <img src="{{asset('/frontend/images/img_05.png')}}" alt="">
                            <img src="{{asset('/frontend/images/img_06.png')}}" alt="" style="display: none;">
                            <img src="{{asset('/frontend/images/img_07.png')}}" alt="" style="display: none;">
                        </div>
                        <div class="case-desc">
                            <span class="sp">{{$v->title or ''}}</span>
                            {{$v->description or ''}}
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div id="article" class="section case ">
            <div class="case-container js-load">
                @foreach($org->articles as $v)
                    <a href="{{url('/article?id=').encode($v->id)}}">
                    <div class="col-4">
                        <div class="case-img">
                            <img src="{{asset('/frontend/images/img_05.png')}}" alt="">
                            <img src="{{asset('/frontend/images/img_06.png')}}" alt="" style="display: none;">
                            <img src="{{asset('/frontend/images/img_07.png')}}" alt="" style="display: none;">
                        </div>
                        <div class="case-desc">
                            <span class="sp">{{$v->title or ''}}</span>
                            {{$v->description or ''}}
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
        </div>

        <div id="about" class="section about ">
            <div class="about-container js-load">
                <div class="about-desc">
                    {{$org->description or ''}}
                </div>
                <div class="about-contact">
                    {{--email--}}
                    <div class="col-4">
                        <div class="about-contact-img">
                            <img src="{{asset('/frontend/images/img_email.svg')}}" alt="">
                        </div>
                        <div class="about-contact-text">
                            <a href="mailto:{{$org->email or ''}}">
                                {{$org->email or ''}}
                            </a>
                        </div>
                    </div>
                    {{--wechat--}}
                    <div class="col-4">
                        <div class="about-contact-img">
                            <img src="{{asset('/frontend/images/img_weixin.svg')}}" alt="">
                        </div>
                        <div class="about-contact-text">
                            {{$org->wechat or ''}}
                        </div>
                        <div class="about-contact-qrcode">
                            <img src="{{asset('/frontend/images/lean_qrcode.jpg')}}" alt="">
                        </div>
                    </div>
                    {{--telephone--}}
                    <div class="col-4">
                        <div class="about-contact-img">
                            <img src="{{asset('/frontend/images/img_phone.svg')}}" alt="">
                        </div>
                        <div class="about-contact-text">
                            {{$org->telephone or ''}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer" class="section footer ">
            <div class="footer-logo js-load"></div>
            <p>
                @foreach(preg_split('/(?<!^)(?!$)/u', $org->slogan) as $v)
                    <span>{{$v}}</span>
                @endforeach
            </p>
            <div class="copyright">
                &copy; 莲花树科技有限公司技术支持. All Rights Reserved. 沪ICP备123456xy号
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('/frontend/libs/jquery.fullPage.min.js')}}"></script>
    <script src="{{asset('/frontend/js/index.js')}}"></script>
@endsection