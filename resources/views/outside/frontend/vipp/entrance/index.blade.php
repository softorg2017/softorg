@extends('templates.themes.vipp.layout.layout')


{{--html.head--}}
@section('head_title'){{$info->name or ''}}@endsection
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
    @include('templates.themes.vipp.component.root.root-footer')
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
    @include('templates.themes.vipp.component.banner')

    @include('templates.themes.vipp.module.index.module-template-1',['datas'=>$templates])
{{--    @include('templates.themes.vipp.module.index.module-template-1',['datas'=>$templates, 'style'=>'cta'])--}}




    {{--自定义栏位--}}
    {{--@if( count($modules) == 0 )--}}
        {{--@foreach($modules as $module)--}}

            {{--@include('templates.themes.vipp.module.index.module-'.$module->type.'-'.$module->style,['data'=>$module])--}}

        {{--@endforeach--}}
    {{--@endif--}}

@endsection
