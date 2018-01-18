@extends('front.'.config('common.view.front.list').'.layout.list')

{{--分享内容--}}
@section('share_module',3)
@section('share_title',$org->name)
@section('share_desc','活动列表')
@section('share_img')http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}@endsection

@section('title','活动列表')
@section('header','活动列表')
@section('description','活动列表')

@section('website-name',$org->website_name)
@section('menu-name','活动列表')


@section('content')
{{--4栏--}}
<div class="row full wrapper-content product-column product-four-column slide-to-top
    @if( (count($org->products) % 2) == 1 ) product-four-column--wide @endif
">
    <div class="col-md-14">
        <div class="row full">
            <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                <h3>活动列表</h3>
            </div>
            <ul class="col-sm-12 col-xs-14 product-list">
                @foreach($org->activities as $v)
                    <li class="col-md-6 ">
                        <a href="{{url('/activity?id=').encode($v->id)}}">
                            <div class="item list-background">

                                <div class="item-contents z-index-9">
                                    <h4 class="list-title multi-ellipsis">{{$v->title or ''}}</h4>
                                    <p class="list-description description line-ellipsis">{{$v->description or ''}}</p>
                                </div>

                                <div class="bottom-text left-8" style="display:none;">
                                    <span class="price">活动</span>
                                </div>

                                <div class="item-cover">
                                    @if(!empty($v->cover_pic))
                                        <img src="{{url('http://cdn.'.$_SERVER['HTTP_HOST'].'/'.$v->cover_pic)}}" alt="">
                                    @else
                                        {{--<img src="{{url('http://cdn.'.$_SERVER['HTTP_HOST'].'/'.$org->logo)}}" alt="{{ $org->name }}">--}}
                                    @endif
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

