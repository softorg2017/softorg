@extends('front.'.config('common.view.front.detail').'.layout.detail')

@section('website-name',$data->org->website_name)

{{--分享内容--}}
@section('share_title')【问卷】{{$data->title or ''}}@endsection
@section('share_desc'){{$data->description or ''}}@endsection

@section('title')
    问卷 - {{$data->title or ''}}
@endsection
@section('header','问卷详情')
@section('description','问卷详情')

@section('detail-name','问卷详情')

@section('data-updated_at')
    {{date("Y-n-j H:i",strtotime($data->updated_at))}}
@endsection

@section('data-visit')
    阅读 {{$data->visit_num or ''}} &nbsp;
@endsection

@section('data-title')
    {{$data->title or ''}}
@endsection

@section('content')
    <div class="row full wrapper-content product-column product-four-column slide-to-top">

        <div class="col-md-14">
            <div class="row full">
                <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                    <h1>{{$data->title or ''}}</h1>
                    <div class="text">@yield('data-updated_at') <span style="float: right;">@yield('data-visit')</span></div>
                    <div class="text">{!! $data->content or '' !!}</div>
                </div>
            </div>
        </div>


        <form method="POST" action="" id="form-question">
            {{ csrf_field() }}
            <input type="hidden" name="type" value="survey">
            <input type="hidden" name="id" value="{{encode($data->id)}}">

            @foreach($data->questions as $k => $v)
                <div class="row full">
                    <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3" style="border-bottom:1px solid #ddd; margin-top:8px">
                        <div class="row" data-id="{{$v->encode_id or ''}}">
                            {{--标题--}}
                            <div class="form-group">
                                <div class="row">
                                    <h4>
                                        <small>{{$loop->index + 1}}.</small><b>{{$v->title or ''}}</b>
                                        <small>
                                            @if($v->type == 1) (单行文本题)
                                            @elseif($v->type == 2) (多行文本题)
                                            @elseif($v->type == 3) (单选题)
                                            @elseif($v->type == 4) (下拉题)
                                            @elseif($v->type == 5) (多选题)
                                            @elseif($v->type == 6) (量标题)
                                            @endif
                                        </small>
                                    </h4>
                                </div>
                            </div>
                            {{--描述--}}
                            <div class="form-group">
                                <div class="row">{{$v->description or ''}}</div>
                            </div>
                            @if($v->type == 1) {{--单行文本题--}}
                            <div class="form-group">
                                <div class="row">
                                    <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="text">
                                    <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="input">
                                    <input type="text" class="form-control" name="questions[{{encode($v->id)}}][value]">
                                </div>
                            </div>
                            @elseif($v->type == 2) {{--多行文本题--}}
                            <div class="form-group">
                                <div class="row">
                                    <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="text">
                                    <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="textarea">
                                    <textarea name="questions[{{encode($v->id)}}][value]"></textarea>
                                </div>
                            </div>
                            @elseif($v->type == 3) {{--单选题--}}
                            <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="radio">
                            <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="radio">
                            @foreach($v->options as $o)
                                <div class="form-group">
                                    <div class="">
                                        <input type="radio" name="questions[{{encode($v->id)}}][value]" value="{{$o->id or ''}}"> {{$o->title or ''}}
                                    </div>
                                </div>
                            @endforeach
                            @elseif($v->type == 4) {{--下拉题--}}
                            <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="radio">
                            <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="option">
                            <div class="form-group">
                                <div class="row">
                                    <select  name="questions[{{encode($v->id)}}][value]">
                                        @foreach($v->options as $o)
                                            <option value="{{$o->id or ''}}">{{$o->title or ''}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @elseif($v->type == 5) {{--多选题--}}
                            <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="checkbox">
                            <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="checkbox">
                            @foreach($v->options as $o)
                                <div class="form-group">
                                    <div class="row">
                                        <input type="checkbox" name="questions[{{encode($v->id)}}][value][{{$o->id or ''}}]" value="{{$o->id or ''}}"> {{$o->title or ''}}
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </form>

        <div class="row full">
            <div class="col-xs-12 col-xs-offset-1 col-md-8 col-md-offset-3">
                <div class="row">
                        <button type="button" class="btn btn-primary" id="answer-question-submit"><i class="fa fa-check"></i> 提交</button>
                        {{--<button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>--}}
                </div>
            </div>
        </div>

    </div>
@endsection




@section('data-content-ext')
@endsection



@section('css')
    <link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">
@endsection



@section('js')
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <script>
        $(function () {

//            $('input').iCheck({
//                checkboxClass: 'icheckbox_square-blue',
//                radioClass: 'iradio_square-blue',
//                increaseArea: '20%' // optional
//            });

            // 回答问题
            $("#answer-question-submit").on('click', function() {
                var form = $("#form-question");
//                $.post('/survey/answer', form.serialize(), function(data){
//                }, 'json');

                var options = {
                    url: "/answer",
                    type: "post",
                    dataType: "json",
                    // target: "#div2",
                    success: function (data) {
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            form.find("input:text").val("");
                            form.find("textarea").val("");
                            form.find("input:radio").removeAttr('checked');
                            form.find("input:checkbox").removeAttr('checked');
                            layer.msg("提交成功");
                        }
                    }
                };
                form.ajaxSubmit(options);

            });
        })
    </script>
@endsection
