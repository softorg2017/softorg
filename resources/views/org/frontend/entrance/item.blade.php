@extends('org.frontend.layout.layout')


{{--html.head--}}
@section('head_title') {{$data->title or ''}} @endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
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



{{--header--}}
@section('component-header')
{{--    @include('frontend.component.header')--}}
@endsection


{{--footer--}}
@section('component-footer')
{{--    @include('frontend.component.footer')--}}
@endsection




{{--custom-content--}}
@section('custom-content')

    {{--banner--}}
{{--    @include('org.rontend.component.banner-for-root')--}}

    <div class="page-root">


        @include('org.frontend.module.item-detail', ['items'=>$data])


    </div>

@endsection




{{--style--}}
@section('custom-style')
<style>
</style>
@endsection




{{--style--}}
@section('custom-script')
<script>
</script>
@endsection