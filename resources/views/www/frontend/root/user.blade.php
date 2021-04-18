@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')

@section('header_title') {{ $data->username or '' }}的主页 @endsection
@section('header','')
@section('description','')

@section('header_title')  @endsection

@section('content')

    <div style="display:none;">
        <input type="hidden" id="" value="{{$encode or ''}}" readonly>
    </div>

    <div class="container">

        <div class="col-xs-12 col-sm-12 col-md-3 container-body-right pull-right hidden-xs hidden-sm" style="margin-bottom:16px;">

            <div class="box-body" style="background:#fff;">
                <i class="fa fa-user text-orange"></i>&nbsp; <b>{{ $data->name or '' }}</b>
            </div>

            <div class="box-body" style="margin-top:8px;background:#fff;">
                <div class="margin">话题数：{{ $data->topics_count or 0 }}</div>
                <div class="margin">访问量：{{ $data->visit_num or 0 }}</div>
            </div>

        </div>

        <div class="col-xs-12 col-sm-12 col-md-9 container-body-left">

            <div class="box-body visible-xs visible-sm" style="margin-bottom:4px;background:#fff;">
                <i class="fa fa-user text-orange"></i>&nbsp; <b>{{ $data->name or '' }}</b>
            </div>

            <div class="box-body visible-xs visible-sm" style="margin-bottom:16px;background:#fff;">
                <div class="margin">话题数：{{ $data->topics_count or 0 }}</div>
                <div class="margin">访问量：{{ $data->visit_num or 0 }}</div>
            </div>

            {{--@foreach($topics as $num => $item)--}}
                {{--@include('frontend.component.topic')--}}
            {{--@endforeach--}}
            @include('frontend.component.topic')

            {{ $topics->links() }}

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
            moreLink: '<a href="#">更多</a>',
            lessLink: '<a href="#">收起</a>'
        });
    });
</script>
@endsection
