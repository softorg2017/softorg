@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')


@section('head_title','朝鲜族组织平台')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')朝鲜族组织平台@endsection
@section('wx_share_desc')发现身边的朝鲜族社群组织@endsection
@section('wx_share_imgUrl'){{ url('/k-org.cn.png') }}@endsection


@section('sidebar')

    @include(env('TEMPLATE_DEFAULT').'frontend.component.sidebar-root')

@endsection


@section('header','')
@section('description','')
@section('content')
<div style="display:none;">
    <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
</div>

<div class="container">

    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-body-left">

        {{--@foreach($datas as $num => $item)--}}
            {{--@include('frontend.component.topic')--}}
        {{--@endforeach--}}
        @include(env('TEMPLATE_DEFAULT').'frontend.component.user-list',['user_list'=>$user_list])
        {!! $user_list->links() !!}

    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 hidden-xs hidden-sm container-body-right">

        @include(env('TEMPLATE_DEFAULT').'frontend.component.right-root')
        @include(env('TEMPLATE_DEFAULT').'frontend.component.right-me')

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
<script>
    $(function() {
        $('article').readmore({
            speed: 150,
            moreLink: '<a href="#">展开更多</a>',
            lessLink: '<a href="#">收起</a>'
        });
    });
</script>
@endsection
