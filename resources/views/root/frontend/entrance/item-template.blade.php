@extends('root.frontend.layout.layout')


{{--html.head--}}
@section('head_title') 模板展示 - 上海如哉网络科技有限公司 @endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection



{{--header--}}
@section('component-header')
    @include('root.frontend.component.header')
@endsection




{{--custom-content--}}
@section('custom-content')

    {{--iframe--}}
    <iframe id="iframe" src="{{$item->link_url}}" frameborder="0" width="100%" height="auto"
            style="position:absolute; top:64px; bottom:0; left:0; right:0;"></iframe>

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