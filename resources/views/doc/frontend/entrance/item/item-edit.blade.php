@extends(env('TEMPLATE_DOC_FRONT').'layout.layout')


@section('head_title')
    {{ $head_title or '如未轻博' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




@section('header') {{ $item->title or '' }} @endsection
@section('description','')
@section('content')
<div class="container">

    {{--左侧--}}
    <div class="main-body-section main-body-left-section section-wrapper page-item">
        <div class="main-body-left-container bg-white">

            @include(env('TEMPLATE_COMMON_FRONT').'component.item-edit')

        </div>
    </div>


    {{--右侧--}}
    <div class="main-body-section main-body-right-section section-wrapper">
        <div class="main-body-right-container fixed-to-top">

            @include(env('TEMPLATE_DOC_FRONT').'component.right-side.right-root')
            {{--@include(env('TEMPLATE_DOC_FRONT').'component.right-user', ['data'=>$item->owner])--}}
            {{--@include(env('TEMPLATE_DOC_FRONT').'component.right-user', ['data'=>$user])--}}

        </div>
    </div>


    {{--右侧--}}
    <div class="main-body-section main-body-right-section section-wrapper pull-right" style="clear:right;">

        {{--@if(!empty($user->ad))--}}
        {{--<div class="item-row margin-top-4px margin-bottom-2px pull-right">--}}
        {{--<strong>Ta的贴片广告</strong>--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-ad-paste', ['item'=>$user->ad])--}}

        {{--@if(count($user->pivot_sponsor_list))--}}
        {{--<div class="item-row margin-top-16px margin-bottom-2px pull-right">--}}
        {{--<strong>Ta的赞助商</strong>--}}
        {{--</div>--}}
        {{--@endif--}}
        {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-sponsor', ['sponsor_list'=>$user->pivot_sponsor_list])--}}

    </div>

</div>
@endsection




@section('script')
    @include(env('TEMPLATE_COMMON_FRONT').'component.item-edit-script')
@endsection