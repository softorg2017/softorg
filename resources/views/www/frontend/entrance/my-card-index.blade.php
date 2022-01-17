@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title','我的名片')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection




@section('sidebar')
    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar.sidebar-user')
@endsection
@section('header','')
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-root">
        <div class="container-box pull-left margin-bottom-4px">

            @include(env('TEMPLATE_ROOT_FRONT').'component.left-side.left-card', ['data'=>$data])

            {{--<div class="box-body visible-xs visible-sm" style="margin-bottom:4px;background:#fff;">--}}
            {{--<i class="fa fa-user text-orange"></i>&nbsp; <b>{{ $data->name or '' }}</b>--}}
            {{--</div>--}}

            {{--<div class="box-body visible-xs visible-sm" style="margin-bottom:16px;background:#fff;">--}}
            {{--<div class="margin">访问：{{ $data->visit_num or 0 }}</div>--}}
            {{--<div class="margin">文章：{{ $data->article_count or 0 }}</div>--}}
            {{--<div class="margin">活动：{{ $data->activity_count or 0 }}</div>--}}
            {{--</div>--}}


            @if(!in_array(request('type'),['org','introduction']))
                {{--<div class="item-row margin-bottom-4px pull-right visible-xs">--}}
                {{--<strong>Ta的内容</strong>--}}
                {{--</div>--}}
                {{--@include(env('TEMPLATE_ROOT_FRONT').'component.item-list',['item_list'=>$item_list])--}}
                {{--{!! $item_list->links() !!}--}}
            @endif


            @if(request('type') == 'introduction')
                <div class="item-piece item-option">
                    <div class="box-body item-row item-content-row">
                        <div class="item-row">
                            <h4>我的简介</h4>
                        </div>
                        <div class="item-row">
                            @if(!empty($data->introduction->content))
                                {!! $data->introduction->content or '' !!}
                            @else
                                <small>暂无简介</small>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            {{--@if($data->user_type == 88 && request('type') == 'org')--}}
            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.user-list',['user_list'=>$data->pivot_org_list])--}}
            {{--@endif--}}

        </div>
    </div>

    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')

    </div>

</div>
@endsection
