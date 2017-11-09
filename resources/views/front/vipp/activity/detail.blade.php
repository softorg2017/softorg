@extends('front.'.config('common.view.front.detail').'.layout.detail')

@section('website-name',$data->org->website_name)

@section('title')
    活动 - {{$data->title or ''}}
@endsection
@section('header','活动详情')
@section('description','活动详情')

@section('detail-name','活动详情')

@section('data-activit-time')
    <b>{{date("Y/n/j H:i",$data->start_time)}}</b> - <b>{{date("Y/n/j H:i",$data->end_time)}}</b>
@endsection

@section('data-updated_at')
    {{date("Y-n-j H:i",strtotime($data->updated_at))}}
@endsection

@section('data-visit')
    阅读 {{$data->visit_num or ''}} &nbsp;
@endsection

@section('data-title')
    {{$data->title or ''}}
@endsection

@section('data-content')
    {!! $data->content or '' !!}
@endsection



@section('content')
    {{--4栏--}}
    <div class="row full wrapper-content product-column product-four-column slide-to-top">
        <div class="col-md-14">
            <div class="row full">
                <div class="col-xs-12 col-xs-offset-1 col-md-10">
                    <h1>{{$data->title or ''}}</h1>
                    <div class="text">@yield('data-updated_at') <span style="float: right;">@yield('data-visit')</span></div>
                    <h2>@yield('data-activit-time')</h2>
                    <div class="text">{!! $data->content or '' !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
