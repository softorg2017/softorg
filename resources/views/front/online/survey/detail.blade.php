@extends('front.'.config('common.view.front.template').'.layout.detail')

@section('title','问卷详情')
@section('header','问卷详情')
@section('description','问卷详情')

@section('index-url',url(config('common.website.front.prefix').'/'.$data->org->website_name))


@section('data-updated_at')
    {{$data->updated_at or ''}}
@endsection

@section('data—title')
    {{$data->title or ''}}
@endsection

@section('data-content')
    {!! $data->content or '' !!}
@endsection

@section('data-content-ext')
    <form method="POST" action="" id="form-question">
        {{ csrf_field() }}
        <input type="hidden" name="type" value="survey">
        <input type="hidden" name="id" value="{{encode($data->id)}}">

    @foreach($data->questions as $k => $v)
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="detail-left">
                    <div class="detail-left-cont">
                        <div class="row" data-id="{{$v->encode_id or ''}}">
                            {{--标题--}}
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <h4>
                                        <small></small><b>{{$v->title or ''}}</b>
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
                                <div class="col-md-10 col-md-offset-1">{{$v->description or ''}}</div>
                            </div>
                            @if($v->type == 1) {{--单行文本题--}}
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
                                    <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="text">
                                    <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="input">
                                    <input type="text" class="form-control" name="questions[{{encode($v->id)}}][value]">
                                </div>
                            </div>
                            @elseif($v->type == 2) {{--多行文本题--}}
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
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
                                    <div class="col-md-10 col-md-offset-1">
                                        <input type="radio" name="questions[{{encode($v->id)}}][value]" value="{{$o->id or ''}}"> {{$o->title or ''}}
                                    </div>
                                </div>
                            @endforeach
                            @elseif($v->type == 4) {{--下拉题--}}
                            <input type="hidden" name="questions[{{encode($v->id)}}][type]" value="radio">
                            <input type="hidden" name="questions[{{encode($v->id)}}][q_type]" value="option">
                            <div class="form-group">
                                <div class="col-md-10 col-md-offset-1">
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
                                    <div class="col-md-10 col-md-offset-1">
                                        <input type="checkbox" name="questions[{{encode($v->id)}}][value][{{$o->id or ''}}]" value="{{$o->id or ''}}"> {{$o->title or ''}}
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </form>

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="detail-left">
                <div class="detail-left-cont">
                    <div class="row" style="margin:16px 0;">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="button" class="btn btn-primary" id="answer-question-submit"><i class="fa fa-check"></i> 提交</button>
                            {{--<button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('css—ext')
    <link href="https://cdn.bootcss.com/iCheck/1.0.2/skins/all.css" rel="stylesheet">
@endsection



@section('js—ext')
    <script src="https://cdn.bootcss.com/iCheck/1.0.2/icheck.min.js"></script>
    <script>
        $(function () {

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });

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
