@extends(env('TEMPLATE_DOC_FRONT').'layout.layout')


@section('head_title')
    {{ $head_title or '如未轻博' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title'){{ $item->title or '如未轻博' }}@endsection
@section('wx_share_desc'){{ '@'.$item->owner->username }}@endsection
@section('wx_share_imgUrl'){{ url(env('DOMAIN_CDN').'/'.$item->owner->portrait_img) }}@endsection




@section('sidebar-toggle','_none')
@section('sidebar')

    {{--@include(env('TEMPLATE_DOC_FRONT').'component.sidebar-item')--}}

@endsection




@section('header') {{ $item->title or '' }} @endsection
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-item">
        <div class="main-body-left-container bg-white">


            @include(env('TEMPLATE_DOC_FRONT').'component.item', ['data'=>$user])

        </div>
    </div>


    <div class="main-body-section main-body-right-section section-wrapper">
        <div class="main-body-right-container fixed-to-top">

            {{--@include(env('TEMPLATE_DOC_FRONT').'component.right-side.right-root')--}}
            {{--@include(env('TEMPLATE_DOC_FRONT').'component.right-user', ['data'=>$item->owner])--}}
            {{--@include(env('TEMPLATE_DOC_FRONT').'component.right-user', ['data'=>$user])--}}

            @if($item->item_type == 11)
                @include(env('TEMPLATE_COMMON_FRONT').'component.right-side.side-menu', ['data'=>$user])
            @elseif($item->item_type == 18)
                @include(env('TEMPLATE_COMMON_FRONT').'component.right-side.side-time_line', ['data'=>$user])
            @else
                @include(env('TEMPLATE_DOC_FRONT').'component.right-side.right-root')
            @endif

        </div>
    </div>


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


@section('custom-css')
    @if($item->item_type == 18)
        <link rel="stylesheet" type="text/css" href="{{ asset('/resource/library/jiaoben/jiaoben912/css/default.css') }}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('/resource/library/jiaoben/jiaoben912/css/component.css') }}" />
    @endif
@endsection
@section('style')
<style>
    .box-footer a {color:#777;cursor:pointer;}
    .box-footer a:hover {color:orange;cursor:pointer;}
    .comment-choice-container {border-top:2px solid #ddd;}
    .comment-choice-container .form-group { margin-bottom:0;}
</style>
@endsection

@section('js')
<script>
    $(function() {
        fold();
        $(".comments-get-default").click();
    });
</script>
@endsection