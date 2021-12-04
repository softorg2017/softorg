@extends(env('TEMPLATE_DOC_FRONT').'layout.layout')


@section('head_title')
    {{ $head_title or '如未轻博' }}
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')如未轻博@endsection
@section('wx_share_desc')如未轻博@endsection
@section('wx_share_imgUrl'){{ url('/k-org.cn.png') }}@endsection




@section('sidebar')
    @include(env('TEMPLATE_DOC_FRONT').'component.sidebar.sidebar-root')
@endsection


@section('header','')
@section('description','')
@section('content')<div class="container">

    <div class="col-xs-12 col-sm-12 col-md-9 main-body-left-section section-wrapper page-root">

        <div class="container-box pull-left margin-bottom-16px">


            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="{{ $sidebar_menu_for_root_active or '' }}"><a href="/" data-toggle="tab-">全部</a></li>
                    <li class="{{ $sidebar_menu_for_object_active or '' }}"><a href="/?type=object" data-toggle="tab-">物</a></li>
                    <li class="{{ $sidebar_menu_for_people_active or '' }}"><a href="/?type=people" data-toggle="tab-">人</a></li>
                </ul>
                <div class="tab-content" style="width:100%; padding:0;float:left;">
                    {{--<div class="active tab-pane" id="all">--}}
                        @include(env('TEMPLATE_DOC_FRONT').'component.item-list',['item_list'=>$item_list])
                    {{--</div>--}}
                    {{--<div class="tab-pane" id="timeline">--}}
                    {{--</div>--}}

                    {{--<div class="tab-pane" id="settings">--}}
                    {{--</div>--}}
                </div>
            </div>



            {{--@include(env('TEMPLATE_DOC_FRONT').'component.item-list',['item_list'=>$item_list])--}}
        </div>

        {!! $item_list->links() !!}

        <div></div>

    </div>


    <div class="col-xs-12 col-sm-12 col-md-3 main-body-right-section section-wrapper hidden-xs hidden-sm">

        @include(env('TEMPLATE_DOC_FRONT').'component.right-side.right-root')
        {{--@include(env('TEMPLATE_DOC_FRONT').'component.right-me')--}}

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
//        $('article').readmore({
//            speed: 150,
//            moreLink: '<a href="#">展开更多</a>',
//            lessLink: '<a href="#">收起</a>'
//        });
    });
</script>
@endsection
