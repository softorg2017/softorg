@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title')
    @if(!empty($data->true_name))
        {{ $data->true_name or '' }}
    @else
        {{ $data->username or '' }}
    @endif
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title') @if(!empty($data->true_name)){{ $data->true_name or '如未科技' }}@else{{ $data->true_name or '如未科技' }}@endif @endsection
@section('wx_share_desc') @if(!empty($data->company)){{ $data->company or '' }}@endif / @if(!empty($data->position)){{ $data->position or '' }}@endif @endsection
@section('wx_share_imgUrl'){{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}@endsection




@section('sidebar')

    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar-user')

@endsection




@section('header','')
@section('description','')
@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 container-body-right pull-right _none">

            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-user', ['data'=>$data])--}}

            @include(env('TEMPLATE_ROOT_FRONT').'component.right-user-menu', ['data'=>$data])

        </div>


        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-body-left margin-bottom-8px">

            @include(env('TEMPLATE_ROOT_FRONT').'component.left-user', ['data'=>$data])

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

        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 hidden-xs- hidden-sm- container-body-right">

            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-root')--}}
            @if(Auth::check() && Auth::id() == $data->id)
            @else
                @include(env('TEMPLATE_ROOT_FRONT').'component.right-me')
            @endif

        </div>



    </div>

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
        $('article').readmore({
            speed: 150,
            moreLink: '<a href="#">更多</a>',
            lessLink: '<a href="#">收起</a>'
        });
    });
</script>
@endsection
