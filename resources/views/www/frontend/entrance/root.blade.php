@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title')
    {{ $head_title or '如未科技' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')如未科技@endsection
@section('wx_share_desc')发现身边的精彩@endsection
@section('wx_share_imgUrl'){{ url('/images/lookwit-black.png') }}@endsection


@section('sidebar')

    {{--@include(env('TEMPLATE_ROOT_FRONT').'component.sidebar.sidebar-root')--}}

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


            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ $menu_active_for_recommend or '' }}"><a href="/" data-toggle="tab-">推荐</a></li>
                    <li class="{{ $menu_active_for_focus or '' }}"><a href="/?item-type=focus" data-toggle="tab-">关注</a></li>
                    <li class="{{ $menu_active_for_community or '' }}"><a href="/?item-type=community" data-toggle="tab-">社区资讯</a></li>
                </ul>
                <div class="tab-content" style="width:100%; padding:10px 0;float:left;">
                    <div class="active tab-pane" id="all">
                        @if(!empty($item_list) && count($item_list))
                            @include(env('TEMPLATE_COMMON_FRONT').'component.item-list',['item_list'=>$item_list])
                        @endif
                    </div>
                    {{--<div class="tab-pane" id="timeline">--}}
                    {{--</div>--}}

                    {{--<div class="tab-pane" id="settings">--}}
                    {{--</div>--}}
                </div>
            </div>

            {{--{!! $item_list->links() !!}--}}

            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.left-tag')--}}

            <div class="container-box pull-left margin-bottom-16px">
                {{--@include(env('TEMPLATE_ROOT_FRONT').'component.item-list',['item_list'=>$item_list])--}}
            </div>

            <div class="container-box pull-left margin-bottom-16px">
                {{--@include(env('TEMPLATE_ROOT_FRONT').'component.user-list',['user_list'=>$user_list])--}}
            </div>

            {{--{!! $item_list->links() !!}--}}

        </div>
    </div>

    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-root')--}}
        @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')

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
    @include(env('TEMPLATE_COMMON_FRONT').'component.item-script')
@endsection
@section('script')
<script>
    $(function() {
//        $('article').readmore({
//            speed: 150,
//            moreLink: '<a href="#">展开更多</a>',
//            lessLink: '<a href="#">收起</a>'
//        });
    });
</script>
@endsection

