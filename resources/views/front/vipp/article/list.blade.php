@extends('front.'.config('common.view.front.list').'.layout.list')

@section('title','文章列表')
@section('header','文章列表')
@section('description','文章列表')

@section('website-name',$org->website_name)
@section('menu-name','文章列表')

@section('content')
{{--4栏--}}
<div class="row full wrapper-content product-column product-four-column slide-to-top">
    <div class="col-md-14">
        <div class="row full">
            <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                <h3>文章列表</h3>
            </div>
            <ul class="col-sm-12 col-xs-14 product-list">
                @foreach($org->articles as $v)
                    <li class="col-md-6 ">
                        <a href="{{url('/article?id=').encode($v->id)}}">
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
                                    <p class="seriesnumber">文章</p>
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
        </div>
    </div>
</div>
@endsection

