@extends('templates.themes.vipp.layout.layout')


{{--html.head--}}
@section('head_title'){{$data->title or ''}}@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title',$data->title)
@section('wx_share_desc'){{$data->description or '@'.$org->name}}@endsection
@section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.cdn').'/'.$org->logo}}@endsection

@section('wechat_share_website_name'){{$org->website_name or '0'}}@endsection
@section('wechat_share_page_id',encode($data->id))
@section('wechat_share_sort',3)
@section('wechat_share_module',0)



{{--banner--}}
@section('banner-heading',$org->name)
@section('banner-heading-top') Welcome @endsection
@section('banner-heading-bottom'){{$org->slogan or ''}}@endsection
@section('banner-box-left','目录')
@section('banner-box-right','联系我们')




@section('data-updated_at') {{date("Y-n-j H:i",$data->updated_at)}} @endsection
@section('data-visit') 阅读 {{$data->visit_num or ''}} &nbsp; @endsection
@section('data-title') {{$data->title or ''}} @endsection
@section('data-content') {!! $data->content or '' !!} @endsection



@section('custom-content')

    {{--banner--}}
    {{--@include('templates.themes.vipp.component.banner1')--}}

    {{--4栏--}}
    <div class="row full wrapper-content product-column product-four-column slide-to-top">
        <div class="col-md-14">
            <div class="row full">
                <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                    <h1>{{$data->title or ''}}</h1>
                    <div class="text">@yield('data-updated_at') <span style="float: right;">@yield('data-visit')</span></div>
                    <div class="text margin-top-32" style="margin-top:32px;">{!! $data->content or '' !!}</div>
                </div>
            </div>
        </div>
    </div>
@endsection
