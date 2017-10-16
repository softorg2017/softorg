@extends('front.'.config('common.view.front.template').'.layout.detail')

@section('title','幻灯片详情')
@section('header','幻灯片详情')
@section('description','幻灯片详情')

@section('index-url',url(config('common.website.front.prefix').'/'.$data->org->website_name))


@section('data-updated_at')
    {{$data->updated_at or ''}}
@endsection

@section('data—title')
    {{$data->title or ''}}
@endsection

@section('data-content')
    {!! $data->content or '' !!}
@endsection


@section('data-content-ext')

    @foreach($data->pages as $v)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="detail-left">
                    <h1 class="title">{{$v->title or ''}}</h1>
                    <div class="sub-tag clearfix">
                        <span class="sub-tag-time"><i class="iconfont icon-eye"></i>已被浏览 521431 次</span>
                        <p></p>
                    </div>
                    <div class="detail-left-cont">
                        {!! $v->content or '' !!}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection


