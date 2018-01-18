@extends('front.'.config('common.view.front.list').'.layout.list')

{{--分享内容--}}
@section('share_module',0)
@section('share_title',$data->org->name)
@section('share_desc',$data->title)
@section('share_img')http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$data->org->logo or ''}}@endsection

@section('title',$data->title)
@section('header',$data->title)
@section('description',$data->title)

@section('website-name',$data->org->website_name)
@section('menu-name',$data->title)


@section('content')
{{--4栏--}}
<div class="row full wrapper-content product-column product-four-column slide-to-top
    @if( (count($data->items) % 2) == 1 ) product-four-column--wide @endif
">
    <div class="col-md-14">
        <div class="row full">
            <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                <h3>{{ $data->title }}</h3>
            </div>
            <ul class="col-sm-12 col-xs-14 product-list">
                @foreach($data->items as $v)
                    <li class="col-md-6 ">
                        <a href="{{url('/'.strtolower(substr($v->itemable_type, 11)).'?id=').encode($v->itemable->id)}}">
                            <div class="item list-background">

                                <div class="item-contents z-index-9">
                                    <h4 class="list-title multi-ellipsis">{{$v->itemable->title or ''}}</h4>
                                    @if(!empty($v->itemable->description))
                                    <p class="list-description description line-ellipsis">{{$v->itemable->description or ''}}</p>
                                    @endif
                                </div>

                                <div class="bottom-text left-8" style="display:none;">
                                    <span class="price font-5">
                                        @if($v->sort == 1) 产品
                                        @elseif($v->sort == 2) 文章
                                        @elseif($v->sort == 3) 活动/会议
                                        @elseif($v->sort == 4) 调研问卷
                                        @elseif($v->sort == 5) 幻灯片
                                        @else others
                                        @endif
                                    </span>
                                </div>

                                <div class="item-cover">
                                    @if(!empty($v->itemable->cover_pic))
                                        <img src="{{url('http://cdn.'.$_SERVER['HTTP_HOST'].'/'.$v->itemable->cover_pic)}}" alt="">
                                    @else
                                        {{--<img src="{{url('http://cdn.softorg.cn/'.$org->logo)}}" alt="{{ $org->name }}">--}}
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

