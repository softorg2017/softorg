@extends('front.'.config('common.view.front.list').'.layout.list')

{{--分享内容--}}
@section('share_title',$org->website_name)
@section('share_desc','问卷列表')
@section('share_img'){{asset('/favicon-192.png')}}@endsection

@section('title','问卷列表')
@section('header','问卷列表')
@section('description','问卷列表')

@section('website-name',$org->website_name)
@section('menu-name','问卷列表')


@section('content')
    {{--4栏--}}
    <div class="row full wrapper-content product-column product-four-column slide-to-top">
        <div class="col-md-14">
            <div class="row full">
                <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                    <h3>问卷列表</h3>
                </div>
                <ul class="col-sm-12 col-xs-14 product-list">
                    @foreach($org->surveys as $v)
                        <li class="col-md-6 ">
                            <a href="{{url('/survey?id=').encode($v->id)}}">
                                <div class="item " style="background-image:url(/images/black-v.jpg)">
                                    <div class="line">
                                        <p class="seriesnumber"><b>{{$v->title or ''}}</b></p>
                                    </div>
                                    <div class="line">
                                        <p class="seriesnumber">{{$v->description or ''}}</p>
                                    </div>
                                    <div class="line">
                                        <p class="seriesnumber">调研</p>
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

