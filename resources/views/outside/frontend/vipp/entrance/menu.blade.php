@extends('templates.themes.vipp.layout.layout')


{{--html.head--}}
@section('head_title'){{$data->title or ''}}@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--微信分享--}}
@section('wx_share_title',$menu->title)
@section('wx_share_desc'){{$data->description or '@'.$org->name}}@endsection
@section('wx_share_imgUrl'){{config('common.host.'.env('APP_ENV').'.cdn').'/'.$org->logo}}@endsection

@section('wechat_share_website_name'){{$org->website_name or '0'}}@endsection
@section('wechat_share_page_id',encode($menu->id))
@section('wechat_share_sort',2)
@section('wechat_share_module',0)



{{--banner--}}
@section('banner-heading',$org->name)
@section('banner-heading-top') Welcome @endsection
@section('banner-heading-bottom'){{$org->slogan or ''}}@endsection
@section('banner-box-left','目录')
@section('banner-box-right','联系我们')



{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
    @include('templates.themes.vipp.component.banner1')

    {{--main-content--}}
    @include('templates.themes.vipp.module.menu.module-1-0',['data'=>$menu,'items'=>$items])



@endsection

