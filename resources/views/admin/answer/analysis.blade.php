@extends('admin.layout.layout')

@section('title','问卷分析')
@section('header','问卷分析')
@section('description','问卷分析')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/survey/list')}}"><i class="fa "></i>问卷分析</a></li>
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
                <h3 class="box-title">问卷数据分析</h3>
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
                        <div>{{$data->name or ''}}</div>
                    </div>
                </div>
                {{--标题--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标题</label>
                    <div class="col-md-8 ">
                        <div>{{$data->title or ''}}</div>
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div>{{$data->description or ''}}</div>
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

            </div>
            </form>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row" id="question-container">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">问卷选项数据分析</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-question">
                <div class="box-body">
                    {{csrf_field()}}
                    <input type="hidden" readonly name="operate" value="{{$operate or ''}}">
                    <input type="hidden" readonly name="survey_id" value="{{$encode_id or encode(0)}}">

                    @foreach($data->questions as $k => $v)
                        <div class="box-body question-container question-option" data-id="{{$v->encode_id or ''}}">
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
                                    <div class="col-md-8 col-md-offset-2">
                                        <input type="text" class="form-control" value="">
                                    </div>
                                </div>
                            @elseif($v->type == 2) {{--单行文本题--}}
                                <div class="form-group">
                                    <div class="col-md-8 col-md-offset-2">
                                        <textarea></textarea>
                                    </div>
                                </div>
                            @elseif($v->type == 3) {{--单选题--}}
                                @foreach($v->options as $o)
                                    <div class="form-group">
                                        <div class="col-md-8 col-md-offset-2">
                                            <input type="radio" name="radio-{{$v->id or ''}}"> {{$o->title or ''}}
                                        </div>
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
                                        <div class="col-md-8 col-md-offset-2"><input type="checkbox" name="checkbox-{{$v->id or ''}}" > {{$o->title or ''}}</div>
                                    </div>
                                @endforeach
                            @endif
                            {{--面具--}}
                            {{--<div class="control_mask"></div>--}}
                            @if($v->type == 3 || $v->type == 4 || $v->type == 5)
                            <div class="row with-border">
                                <div class="col-md-8 col-md-offset-2">
                                    <div id="echart-{{$v->id}}" style="width:100%;height:300px;"></div>
                                </div>
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </form>

        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection


@section('js')
<script src="https://cdn.bootcss.com/echarts/3.7.2/echarts.min.js"></script>
<script>
$(function() {

    $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });


});
</script>

<script>
    $(function(){

        var myChart;
        var option;
        @foreach($data->questions as $k => $v)
        @if($v->type == 3 || $v->type == 4 || $v->type == 5)
            option = {
                title : {
                    text: '{{$v->title}}',
                    subtext: '{{$v->description}}',
                    x:'center'
                },
                tooltip : {
                    trigger: 'item',
                    formatter: "{{$v->title}} <br/>{b} : {c} ({d}%)"
                },
                legend: {
                    orient : 'vertical',
                    x : 'left',
                    data: [
                            @foreach($v->options as $nv)
                                @if (!$loop->last) '{{$nv->title}}', @else '{{$nv->title}}' @endif
                            @endforeach
                    ]
                },
                toolbox: {
                    show : true,
                    feature : {
                        mark : {show: true},
                        dataView : {show: true, readOnly: false},
                        magicType : {
                            show: true,
                            type: ['pie', 'funnel'],
                            option: {
                                funnel: {
                                    x: '25%',
                                    width: '50%',
                                    funnelAlign: 'left',
                                    max: 1548
                                }
                            }
                        },
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                calculable : true,
                series : [
                    {
                        name:'访问来源',
                        type:'pie',
                        radius : '55%',
                        center: ['50%', '60%'],
                        data: [
                            @foreach($v->options as $vv)
                                @if (!$loop->last)
                                    {value:{{$vv->choices_count}},name:'{{$vv->title}}'},
                                @else
                                    {value:{{$vv->choices_count}},name:'{{$vv->title}}'}
                                @endif
                            @endforeach
                        ]
                    }
                ]
            };
            myChart = echarts.init(document.getElementById('echart-{{$v->id}}'));
            myChart.setOption(option);
            @endif
        @endforeach

    });
</script>

@endsection


