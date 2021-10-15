@extends('frontend.layout.layout')

@section('title','话题社')
@section('header','')
@section('description','')

@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{$encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-sm-12 col-md-9 container-body-left">

            {{--@foreach($datas as $num => $item)--}}
                {{--@include('frontend.component.topic')--}}
            {{--@endforeach--}}
            @include('frontend.component.topic')

            {{ $topics->links() }}

        </div>

        <div class="col-sm-12 col-md-3 hidden-xs hidden-sm container-body-right">

            <div class="box-body right-menu" style="background:#fff;">

                    <a href="{{url('/')}}">
                        <div class="box-body {{ $menu_all or '' }}">
                            <i class="fa fa-list text-orange"></i> <span>&nbsp; 全部</span>
                        </div>
                    </a>

                    <a href="{{url('/debates')}}">
                        <div class="box-body {{ $menu_debates or '' }}">
                            <i class="fa fa-list text-orange"></i> <span>&nbsp; 辩题</span>
                        </div>
                    </a>

                    <a href="{{url('/anonymous')}}">
                        <div class="box-body {{ $menu_anonymous or '' }}">
                            <i class="fa fa-list text-orange"></i> <span>&nbsp; 匿名话题</span>
                        </div>
                    </a>

            </div>

            <div class="box-body right-home" style="margin-top:16px;background:#fff;">

                @if(!Auth::check())
                    <a href="{{url('/login')}}">
                        <div class="box-body">
                            <i class="fa fa-circle-o text-blue"></i> <span>&nbsp; 登录</span>
                        </div>
                    </a>
                    <a href="{{url('/register')}}">
                        <div class="box-body {{ $menu_anonymous or '' }}">
                            <i class="fa fa-circle-o text-blue"></i> <span>&nbsp; 注册</span>
                        </div>
                    </a>
                @else
                    <a href="{{url('/home')}}">
                        <div class="box-body">
                            <i class="fa fa-home text-blue"></i> <span>&nbsp; 返回我的后台</span>
                        </div>
                    </a>
                @endif

            </div>

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
