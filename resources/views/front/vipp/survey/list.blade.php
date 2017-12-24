@extends('front.'.config('common.view.front.list').'.layout.list')

{{--分享内容--}}
@section('share_module',4)
@section('share_title',$org->name)
@section('share_desc','问卷列表')
@section('share_img')http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}@endsection

@section('title','问卷列表')
@section('header','问卷列表')
@section('description','问卷列表')

@section('website-name',$org->website_name)
@section('menu-name','问卷列表')


@section('content')
{{--4栏--}}
<div class="row full wrapper-content product-column product-four-column slide-to-top
    @if( (count($org->products) % 2) == 1 ) product-four-column--wide @endif
">
    <div class="col-md-14">
        <div class="row full">
            <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                <h3>问卷列表</h3>
            </div>
            <ul class="col-sm-12 col-xs-14 product-list">
                @foreach($org->surveys as $v)
                    <li class="col-md-6 ">
                        <a href="{{url('/survey?id=').encode($v->id)}}">
                            <div class="item " style="
                            @if( (count($org->surveys) % 2) == 1 )
                                @if($loop->first)
                                    background:url(/style/case{{ $org->style or '1' }}/bg-survey-r.jpeg);background-size:100% 100%;
                                @else
                                    background:url(/style/case{{ $org->style or '1' }}/bg-survey-v.jpeg);background-size:100% 100%;background-position:center center;
                                @endif
                            @else
                                background:url(/style/case{{ $org->style or '1' }}/bg-survey-v.jpeg);background-size:100% 100%;background-position:center center;
                            @endif
                            ">

                                <div class="top-text left-8 font-">
                                    <h4 style="margin:0;color:#dddddd;">{{$v->title or ''}}</h4>
                                    <p class="description">{{$v->description or ''}}</p>
                                </div>

                                <div class="bottom-text left-8">
                                    <span class="price">问卷</span>
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

