@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title','朝鲜族组织平台')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')如未科技@endsection
@section('wx_share_desc')平台介绍@endsection
@section('wx_share_imgUrl'){{ url('/images/lookwit-black.png') }}@endsection


@section('sidebar')

    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar-root')

@endsection


@section('header','')
@section('description','')
@section('content')
    <div style="display:none;">
        <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-body-left bg-white">

            <div class="item-piece item-option">
                <div class="box-body item-row item-content-row">
                    <div class="item-row">
                        <h4>平台介绍</h4>
                    </div>


                    @if(!empty($data->description))
                        <div class="item-row item-description-row text-muted margin-bottom-8px">
                            {{ $data->description or '' }}
                        </div>
                    @endif

                    <div class="item-row">
                        @if(!empty($data->content))
                            {!! $data->content or '' !!}
                        @else
                            <small>暂无简介</small>
                        @endif
                    </div>
                </div>
            </div>

        </div>


        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 hidden-xs hidden-sm container-body-right">

            @include(env('TEMPLATE_ROOT_FRONT').'component.right-root')
            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-me')--}}

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
//            $('article').readmore({
//                speed: 150,
//                moreLink: '<a href="#">展开更多</a>',
//                lessLink: '<a href="#">收起</a>'
//            });
        });
    </script>
@endsection
