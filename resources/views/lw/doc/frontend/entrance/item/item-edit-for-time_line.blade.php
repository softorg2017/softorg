@extends(env('LW_TEMPLATE_DOC_FRONT').'layout.layout')


@section('head_title')
    {{ $data->title or '' }} - 书目 - 如未轻博
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header') {{ $data->title or '' }} @endsection
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-item">
        <div class="main-body-left-container bg-white">

            @include(env('TEMPLATE_COMMON_FRONT').'component.item-edit-for-time_line')

        </div>
    </div>


    <div class="main-body-section main-body-right-section section-wrapper">
        <div class="main-body-right-container fixed-to-top">

            @include(env('LW_TEMPLATE_DOC_FRONT').'component.right-side.right-root')
            {{--@include(env('LW_TEMPLATE_DOC_FRONT').'component.right-user', ['data'=>$item->owner])--}}
            {{--@include(env('LW_TEMPLATE_DOC_FRONT').'component.right-user', ['data'=>$user])--}}

        </div>
    </div>

</div>


<div class="modal fade" id="edit-modal">
    <div class="col-md-8 col-md-offset-2" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;padding-top:32px;background:#fff;"></div>
</div>
@endsection




@section('custom-css')
    <link rel="stylesheet" href="{{ asset('/resource/component/css/select2-4.0.5.min.css') }}">
@endsection




@section('custom-js')
    <script src="{{ asset('/resource/component/js/select2-4.0.5.min.js') }}"></script>
@endsection
@section('script')
    @include(env('TEMPLATE_COMMON_FRONT').'component.item-edit-for-time_line-script')
@endsection
