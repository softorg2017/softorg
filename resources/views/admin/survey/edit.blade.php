@extends('admin.layout.layout')

@section('title','编辑问卷')
@section('header','编辑问卷')
@section('description','编辑问卷')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/survey/list')}}"><i class="fa "></i>问卷列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('css/admin/question.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-survey">
            <div class="box-body">
                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate_id or ''}}" readonly>
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">名称</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="name" placeholder="请输入名称" value="{{$data->name or ''}}"></div>
                    </div>
                </div>
                {{--标题--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标题</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="title" placeholder="请输入标题" value="{{$data->title or ''}}"></div>
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="description" placeholder="描述" value="{{$data->description or ''}}"></div>
                    </div>
                </div>
                {{--内容--}}
                <div class="form-group" style="display: none;">
                    <label class="control-label col-md-2">内容详情</label>
                    <div class="col-md-8 ">
                        {{--<div>--}}
                            {{--@include('UEditor::head')--}}
                            {{--<!-- 加载编辑器的容器 -->--}}
                            {{--<script id="container" name="content" type="text/plain" style="width:100%;">{!! $data->content or '' !!}</script>--}}
                            {{--<!-- 实例化编辑器 -->--}}
                            {{--<script type="text/javascript">--}}
                                {{--var ue = UE.getEditor('container');--}}
                                {{--ue.ready(function() {--}}
                                    {{--ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.--}}
                                {{--});--}}
                            {{--</script>--}}
                        {{--</div>--}}
                        <div><input type="text" class="form-control" name="content" placeholder="描述" value="{{$data->content or ''}}"></div>
                    </div>
                </div>
                {{--封面图片--}}
                <div class="form-group">
                    <label class="control-label col-md-2">封面图片</label>
                    <div class="col-md-8 ">
                        <div><input type="file" name="cover" placeholder="请上传封面图片" value="{{$data->cover or ''}}"></div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-survey-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row" id="question-container">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">问题管理</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-question">
                <div class="box-body" id="sortable">
                    {{csrf_field()}}
                    <input type="hidden" readonly name="operate" value="{{$operate or ''}}">
                    <input type="hidden" readonly name="survey_id" value="{{$encode_id or encode(0)}}">
                    <div class="box-header with-border question-container">
                        {{--操作--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">操作</label>
                            <div class="col-md-8">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-success">添加</button>
                                    <button type="button" class="btn btn-sm btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="javascript:void(0);" class="create-new-text">单行文本题</a></li>
                                        <li><a href="javascript:void(0);" class="create-new-textarea">多行文本题</a></li>
                                        <li><a href="javascript:void(0);" class="create-new-radio">单选题</a></li>
                                        <li><a href="javascript:void(0);" class="create-new-select">下拉题</a></li>
                                        <li><a href="javascript:void(0);" class="create-new-checkbox">多选题</a></li>
                                    </ul>
                                </div>
                                <button type="button" class="btn btn-sm btn-danger delete-all-question">删除全部</button>
                            </div>
                        </div>
                    </div>

                    @foreach($data->questions as $k => $v)
                        <div class="box-body question-container question-option" data-id="{{$v->encode_id or ''}}">
                            <input type="hidden" name="question[{{$k}}][id]" value="{{$v->id or ''}}">
                            {{--标题--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
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
                                <div class="col-md-8 col-md-offset-2">{{$v->description or ''}}</div>
                            </div>
                            @if($v->type == 1) {{--单行文本题--}}
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-2"><input type="text" class="form-control"></div>
                                </div>
                            @elseif($v->type == 2) {{--单行文本题--}}
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-2"><textarea></textarea></div>
                                </div>
                            @elseif($v->type == 3) {{--单选题--}}
                                @foreach($v->options as $o)
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-2"><input type="radio" name="radio"> {{$o->title or ''}}</div>
                                    </div>
                                @endforeach
                            @elseif($v->type == 4) {{--下拉题--}}
                                <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                <select name="" id="">
                                @foreach($v->options as $o)
                                    <option value="">{{$o->title or ''}}</option>
                                @endforeach
                                </select>
                                </div>
                                </div>
                            @elseif($v->type == 5) {{--多选题--}}
                                @foreach($v->options as $o)
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-2"><input type="checkbox" name="checkbox"> {{$o->title or ''}}</div>
                                    </div>
                                @endforeach
                            @endif
                            {{--操作--}}
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-2">
                                    <button type="button" class="btn btn-sm btn-primary edit-this-question" data-toggle="modal" data-target="#edit-modal">编辑问题</button>
                                    @if(false)
                                        <button type="button" class="btn btn-sm btn-danger delete-this-question">删除</button>
                                    @endif
                                </div>
                            </div>
                            {{--面具--}}
                            {{--<div class="control_mask"></div>--}}
                        </div>
                    @endforeach
                </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="sort-question-submit"><i class="fa fa-check"></i> 保存排序</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="modal fade" id="edit-modal">

</div>

<div class="clone-container" style="display: none">

    {{--单行/多行文本题--}}
    <div id="text-cloner">
        <div class="box-body question-container question-option">

            <form action="" method="post" class="form-horizontal form-bordered form-edit-question">
                {{csrf_field()}}
                <input type="hidden" readonly name="operate" value="create">
                <input type="hidden" readonly name="container" value="survey">
                <input type="hidden" readonly name="survey_id" value="{{$encode_id or encode(0)}}">
                <input type="hidden" readonly name="type" value="1" class="question-type">

                <div class="form-group">
                    <label class="col-md-8 col-md-offset-2 question-title">单行文本题</label>
                    </div>

                <div class="form-group">
                    <label class="control-label col-md-2">题目</label>
                    <div class="col-md-8">
                        <div><input type="text" class="form-control" name="title" placeholder="请输入题目"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">备注</label>
                    <div class="col-md-8">
                        <div><input type="text" class="form-control" name="description" placeholder="请输入备注"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-sm btn-primary create-this-question">保存</button>
                        <button type="button" class="btn btn-sm cansel-this-question">取消</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    {{--单选/多选/下拉--}}
    <div id="choice-cloner">
        <div class="box-body question-container question-option">

            <form action="" method="post" class="form-horizontal form-bordered form-edit-question" data-key="2">
                {{csrf_field()}}
                <input type="hidden" readonly name="operate" value="create">
                <input type="hidden" readonly name="container" value="survey">
                <input type="hidden" readonly name="survey_id" value="{{$encode_id or encode(0)}}">
                <input type="hidden" readonly name="type" value="3" class="question-type">

                <div class="form-group">
                    <label class="col-md-8 col-md-offset-2 question-title">单选题</label>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">题目</label>
                    <div class="col-md-8">
                        <div><input type="text" class="form-control" name="title" placeholder="请输入题目"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">备注</label>
                    <div class="col-md-8">
                        <div><input type="text" class="form-control" name="description" placeholder="请输入备注"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-8 col-md-offset-2">选项</label>
                </div>

                <div class="form-group option-container">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="hidden" name="option[0][id]" value="0">
                        <div><input type="text" class="form-control" name="option[0][title]" placeholder="请输入选项" value="选项"></div>
                    </div>
                </div>

                <div class="form-group option-container">
                    <div class="col-md-8 col-md-offset-2">
                        <input type="hidden" name="option[1][id]" value="0">
                        <div><input type="text" class="form-control" name="option[1][title]" placeholder="请输入选项" value="选项"></div>
                    </div>
                </div>

                <div class="form-group add-option-container">
                    <div class="col-md-8 col-md-offset-2">
                        <div><input type="text" readonly class="form-control create-new-option" placeholder="" value="新增选项"></div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-sm btn-primary create-this-question">保存</button>
                        <button type="button" class="btn btn-sm cansel-this-question">取消</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div id="option-cloner">
        <div class="form-group option-container">
            <div class="col-md-8 col-md-offset-2">
                <input type="hidden" class="form-control option-id" name="option[0][id]" value="0">
                <div><input type="text" class="form-control option-title" name="option[0][title]" placeholder="请输入选项" value="选项"></div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('js')
<script>
$(function() {

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    
    // 添加or修改调研问卷信息
    $("#edit-survey-submit").on('click', function() {
        var options = {
            url: "/admin/survey/edit",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg(data.msg);
//                    location.href = "/admin/survey/list";
                }
            }
        };
        $("#form-edit-survey").ajaxSubmit(options);
    });

    // 新建一个单行文本题
    $("#form-edit-question").on('click', '.create-new-text', function () {

        var html = $("#text-cloner .question-option").clone();
        html.find(".question-type").val(1);
        html.find(".question-title").html("单行文本题");
        $('#question-container .question-container:last').after(html);
        html.find('input[name=title]').focus();
        $('#question-container .question-option').show();
    });
    // 新建一个多行文本题
    $("#form-edit-question").on('click', '.create-new-textarea', function () {

        var html = $("#text-cloner .question-option").clone();
        html.find(".question-type").val(2);
        html.find(".question-title").html("多行文本题");
        $('#question-container .question-container:last').after(html);
        html.find('input[name=title]').focus();
    });

    // 新建一个单选题
    $("#form-edit-question").on('click', '.create-new-radio', function () {

        var html = $("#choice-cloner .question-option").clone();
        html.find(".question-type").val(3);
        html.find(".question-title").html("单选题");
        $('#question-container .question-container:last').after(html);
        html.find('input[name=title]').focus();
    });
    // 新建一个下拉题
    $("#form-edit-question").on('click', '.create-new-select', function () {

        var html = $("#choice-cloner .question-option").clone();
        html.find(".question-type").val(4);
        html.find(".question-title").html("下拉题");
        $('#question-container .question-container:last').after(html);
        html.find('input[name=title]').focus();
    });
    // 新建一个多选题
    $("#form-edit-question").on('click', '.create-new-checkbox', function () {

        var html = $("#choice-cloner .question-option").clone();
        html.find(".question-type").val(5);
        html.find(".question-title").html("多选题");
        $('#question-container .question-container:last').after(html);
        html.find('input[name=title]').focus();
    });

    // 添加一个选项
    $("#form-edit-question").on('click', '.create-new-option', function () {

        var form = $(this).parents("form");
        var key = parseInt(form.attr("data-key"));
        form.attr("data-key",key+1);

        var html = $("#option-cloner .option-container").clone();
        html.find('.option-id').attr("name","option["+key+"][id]");
        html.find('.option-title').attr("name","option["+key+"][title]");
        form.find(".option-container:last").after(html);
    });

    // 添加or修改一个问题
    $("#form-edit-question").on('click', '.create-this-question', function () {

        var options = {
            url: "/admin/question/edit",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg(data.msg);
                    location.href = location.href;
                }
            }
        };
        var form = $(this).parents('form');
        form.ajaxSubmit(options);
    });


    // 添加or修改一个问题
    $("#form-edit-question").on('click', '.edit-this-question', function () {
//        $('#edit-modal').modal();

    });

    // 排序
    $("#sortable").sortable();

    // 修改排序
    $("#sort-question-submit").on('click', function() {
        var options = {
            url: "/admin/survey/sort",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg(data.msg);
//                    location.href = "/admin/survey/list";
                }
            }
        };
        $("#form-edit-question").ajaxSubmit(options);
    });


});
</script>
@endsection
