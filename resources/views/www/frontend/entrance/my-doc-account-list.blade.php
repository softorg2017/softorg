@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')

@section('head_title','我的轻博账号')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')@endsection
@section('wx_share_desc')@endsection
@section('wx_share_imgUrl')@endsection




@section('sidebar')
    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar.sidebar-root')
@endsection
@section('header','')
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-root">
        <div class="container-box pull-left margin-bottom-16px">

            @include(env('TEMPLATE_ROOT_FRONT').'component.user-list',['user_list'=>$user_list])
            {!! $user_list->links() !!}

        </div>
    </div>

    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-root')--}}
        @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')

    </div>

</div>
@endsection




@section('style')
@endsection

@section('script')
@endsection
