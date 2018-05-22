@extends('root.case.layout.layout')


{{--html.heat--}}
@section('head_title')模板案例-上海如哉网络科技有限公司@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title',"模板案例")
@section('wx_share_desc')上海如哉网络科技有限公司@endsection
@section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.root').'/favicon.png'}}@endsection

{{--@section('wechat_share_website_name'){{$org->website_name or '0'}}@endsection--}}
{{--@section('wechat_share_sort',1)--}}
{{--@section('wechat_share_module',0)--}}
{{--@section('wechat_share_page_id',encode(0))--}}



{{--banner--}}
{{--@section('banner-heading',$org->name)--}}
{{--@section('banner-heading-top') Welcome @endsection--}}
{{--@section('banner-heading-bottom'){{$org->slogan or ''}}@endsection--}}
{{--@section('banner-box-left','Our Service')--}}
{{--@section('banner-box-right','Contact Us')--}}



{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
    @include('root.case.component.banner')

    {{--<iframe id="iframe" src="http://demo.sc.chinaz.com//Files/DownLoad/moban/201805/moban2919" frameborder="0" width="100%" height="100%"> </iframe>--}}
    <iframe id="iframe" src="http://demo.sc.chinaz.com//Files/DownLoad/moban/201805/moban2899" frameborder="0" width="100%" height="869px"> </iframe>


@endsection

