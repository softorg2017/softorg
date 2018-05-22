@extends('templates.themes.vipp.layout.layout')


{{--html.head--}}
@section('head_title'){{$template->title or '模板展示'}}-上海如哉网络科技有限公司@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


{{--微信分享--}}
@section('wx_share_title'){{$info->name or ''}}@endsection
@section('wx_share_desc'){{$info->slogan or ''}}@endsection
@section('wx_share_imgUrl'){{ url($info->favicon) }}@endsection

@section('wechat_share_website_name'){{$info->website or '0'}}@endsection
@section('wechat_share_sort',1)
@section('wechat_share_module',0)
@section('wechat_share_page_id',encode(0))


{{--info--}}
@section('root-link'){{ url('/') }}@endsection
@section('info-logo-url'){{ url($info->logo) }}@endsection
@section('info-short-name'){{$info->short or 'Home'}}@endsection


{{--header--}}
@section('component-header')
    @include('templates.themes.vipp.component.root.root-header')
@endsection


{{--footer--}}
@section('component-footer')
    {{--@include('templates.themes.vipp.component.root.root-footer')--}}
@endsection


{{--banner--}}
@section('banner-heading'){{$info->name or ''}}@endsection
@section('banner-heading-top') Welcome @endsection
@section('banner-heading-bottom'){{$info->slogan or ''}}@endsection
@section('banner-box-left','Our Service')
@section('banner-box-right','联系我们')


{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
    @include('templates.themes.vipp.component.banner-0')

    <iframe id="iframe" src="{{$template->link_url}}" frameborder="0" width="100%" height="869px"
            style="position: absolute; top: 80px; bottom: 50px; left: 0; right: 0;"></iframe>

@endsection
