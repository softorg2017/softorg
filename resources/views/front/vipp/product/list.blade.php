@extends('front.'.config('common.view.front.list').'.layout.list')

{{--分享内容--}}
@section('share_module',1)
@section('share_title',$org->name)
@section('share_desc','产品列表')
@section('share_img')http://cdn.{{$_SERVER['HTTP_HOST']}}/{{$org->logo or ''}}@endsection

@section('title','产品列表')
@section('header','产品列表')
@section('description','产品列表')

@section('website-name',$org->website_name)
@section('menu-name','产品列表')


@section('content')
{{--4栏--}}
<div class="row full wrapper-content product-column product-four-column slide-to-top
    @if( (count($org->products) % 2) == 1 ) product-four-column--wide @endif
">
    <div class="col-md-14">
        <div class="row full">
            <div class="col-sm-12 col-sm-offset-1 col-xs-14 product-column-title">
                <h3>产品列表</h3>
            </div>
            <ul class="col-sm-12 col-xs-14 product-list">
                @foreach($org->products as $v)
                    <li class="col-md-6 ">
                        <a href="{{url('/product?id=').encode($v->id)}}">
                            <div class="item " style="
                            @if( (count($org->products) % 2) == 1 )
                                @if($loop->first)
                                    background:url(/style/case{{ $org->style or '0' }}/bg-r-business.jpg);background-size:contain;
                                @else
                                    background:url(/style/case{{ $org->style or '0' }}/bg-v-business.jpg);background-size:contain;
                                @endif
                            @else
                                background:url(/style/case{{ $org->style or '0' }}/bg-v-business.jpg);background-size:contain;
                            @endif
                            ">

                                <div class="top-text left-8">
                                    <h4 class="list-title multi-ellipsis">{{$v->title or ''}}</h4>
                                    <p class="list-description description line-ellipsis">{{$v->description or ''}}</p>
                                </div>

                                <div class="bottom-text left-8" style="display:none;">
                                    <span class="price">产品</span>
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

