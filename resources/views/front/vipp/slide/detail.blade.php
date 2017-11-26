@extends('front.'.config('common.view.front.detail').'.layout.detail')

@section('website-name',$data->org->website_name)

@section('title')
    幻灯片 - {{$data->title or ''}}
@endsection
@section('header','幻灯片详情')
@section('description','幻灯片详情')

@section('detail-name','幻灯片详情')

@section('data-updated_at')
    {{date("Y-n-j H:i",strtotime($data->updated_at))}}
@endsection

@section('data-visit')
    阅读 {{$data->visit_num or ''}} &nbsp;
@endsection

@section('data-title')
    {{$data->title or ''}}
@endsection

@section('content')
    <div class="row full wrapper-content product-column product-four-column slide-to-top">

        <div class="col-md-14">
            <div class="row full">
                <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                    <h1>{{$data->title or ''}}</h1>
                    <div class="text">@yield('data-updated_at') <span style="float: right;">@yield('data-visit')</span></div>
                    <div class="text">{!! $data->content or '' !!}</div>
                </div>
            </div>
        </div>

        @foreach($data->pages as $v)
            <div class="col-md-14">
                <div class="row full">
                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3" style="border-bottom:1px solid #ddd;">
                        <h2>{{$loop->index + 1}}.{{$v->title or ''}}</h2>
                        <div class="text">{!! $v->content or '' !!}</div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection

