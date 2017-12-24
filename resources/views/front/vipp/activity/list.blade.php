@extends('front.'.config('common.view.front.list').'.layout.list')

{{--分享内容--}}
@section('share_module',3)
@section('share_title',$org->website_name)
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
                            <div class="item " style="
                            @if( (count($org->activities) % 2) == 1 )
                                @if($loop->first)
                                    background:url(/style/case{{ $org->style or '1' }}/bg-activity-r.jpeg);background-size:cover;
                                @else
                                    background:url(/style/case{{ $org->style or '1' }}/bg-activity-v.jpeg);background-size:contain;background-position:center center;
                                @endif
                            @else
                                background:url(/style/case{{ $org->style or '1' }}/bg-activity-v.jpeg);background-size:contain;background-position:center center;
                            @endif
                            ">

                                <div class="top-text left-8 font-">
                                    <h4 style="margin:0;color:#dddddd;">{{$v->title or ''}}</h4>
                                    <p class="description">{{$v->description or ''}}</p>
                                </div>

                                <div class="bottom-text left-8">
                                    <span class="price">活动</span>
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

