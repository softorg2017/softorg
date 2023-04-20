@extends(env('LW_TEMPLATE_DOC_FRONT').'layout.layout')


@section('head_title')
    {{ $head_title or '如未轻博' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')朝鲜族组织平台@endsection
@section('wx_share_desc')朝鲜族社群组织活动分享平台@endsection
@section('wx_share_imgUrl'){{ url('/k-org.cn.png') }}@endsection


@section('sidebar')
    @include(env('LW_TEMPLATE_DOC_FRONT').'component.sidebar.sidebar-root')
@endsection


@section('header','')
@section('description','')
@section('content')
<div style="display:none;">
    <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
</div>

<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-root">

        <div class="container-box pull-left margin-bottom-16px">

            {{--@foreach($datas as $num => $item)--}}
                {{--@include('frontend.component.topic')--}}
            {{--@endforeach--}}
            {{--@include(env('LW_TEMPLATE_DOC_DEFAULT').'frontend.component.item-list-for-relation',['item_list'=>$item_list])--}}
            @include(env('LW_TEMPLATE_DOC_FRONT').'component.item-list',['item_list'=>$item_list])
            {{--@if(count($item_list) > 0)--}}
                {{--{!! $item_list->links() !!}--}}
            {{--@endif--}}

        </div>

    </div>


    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        <div class="fixed-to-top">
            @include(env('LW_TEMPLATE_DOC_FRONT').'component.right-side.right-root')
        </div>
        {{--@include(env('LW_TEMPLATE_DOC_FRONT').'component.right-me')--}}

    </div>

</div>
@endsection


@section('style')
<style>
    .box-footer a {color:#777;cursor:pointer;}
    .box-footer a:hover {color:orange;cursor:pointer;}
    .comment-container {border-top:2px solid #ddd;}
    .comment-choice-container {border-top:2px solid #ddd;}
    .comment-choice-container .form-group { margin-bottom:0;}
    .comment-entity-container {border-top:2px solid #ddd;}
    .comment-piece {border-bottom:1px solid #eee;}
    .comment-piece:first-child {}
</style>
@endsection

@section('js')
@endsection
