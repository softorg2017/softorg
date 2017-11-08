@extends('admin.layout.layout')

@section('title','流量统计')
@section('header','流量统计')
@section('description','流量统计')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/survey/list')}}"><i class="fa "></i>流量统计</a></li>
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
                <h3 class="box-title">网站总流量统计</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-index" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
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
                <h3 class="box-title">主页流量统计</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-menu" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            </div>

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
        var option_index = {
            title: {
                text: '主页流量'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer: {
                    type: 'line',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data:['总访问量','主页访问量']
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : [
                        @foreach($all as $v)
                                @if (!$loop->last) '{{$v->date}}', @else '{{$v->date}}' @endif
                        @endforeach
                    ]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'总访问量',
                    type:'line',
                    data:[
                        @foreach($all as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->date}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->date}}'}
                        @endif
                        @endforeach
                    ]
                },
                {
                    name:'主页访问量',
                    type:'line',
                    data:[
                        @foreach($index as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->date}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->date}}'}
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var option_menu = {
            title: {
                text: '目录流量图'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer: {
                    type: 'line',
                    label: {
                        backgroundColor: '#6a7985'
                    }
                }
            },
            legend: {
                data:['产品目录','活动目录','问卷目录','文章目录']
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis : [
                {
                    type : 'category',
                    boundaryGap : false,
                    data : [
                        @foreach($all as $v)
                            @if (!$loop->last) '{{$v->date}}', @else '{{$v->date}}' @endif
                        @endforeach
                    ]
                }
            ],
            yAxis : [
                {
                    type : 'value'
                }
            ],
            series : [
                {
                    name:'产品目录',
                    type:'line',
                    data:[
                        @foreach($product as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->date}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->date}}'}
                        @endif
                        @endforeach
                    ]
                },
                {
                    name:'活动目录',
                    type:'line',
                    data:[
                        @foreach($activity as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->date}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->date}}'}
                        @endif
                        @endforeach
                    ]
                },
                {
                    name:'问卷目录',
                    type:'line',
                    data:[
                        @foreach($survey as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->date}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->date}}'}
                        @endif
                        @endforeach
                    ]
                },
                {
                    name:'文章目录',
                    type:'line',
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    data:[
                        @foreach($article as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->date}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->date}}'}
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        option1 = {
            title: {
                text: '流量统计'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data:['总流量', '主页流量', '目录流量']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            toolbox: {
                feature: {
                    saveAsImage: {}
                }
            },
            xAxis: {
                type: 'category',
                data: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun']
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    name:'总流量',
                    type:'line',
                    data:[
                        @foreach($all as $v)
                                @if (!$loop->last) '{{$v->count}}', @else '{{$v->count}}' @endif
                        @endforeach
                    ]
                },
                {
                    name:'主页流量',
                    type:'line',
                    data:[220, 282]
                },
                {
                    name:'目录流量',
                    type:'line',
                    data:[450, 432]
                }
            ]
        };
        option2 = {
            title: {
                text: '对数轴示例',
                left: 'center'
            },
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b} : {c}'
            },
            legend: {
                left: 'left',
                data: ['2的指数', '3的指数']
            },
            xAxis: {
                type: 'category',
                name: 'x',
                splitLine: {show: false},
                data: ['一', '二', '三', '四', '五', '六', '七', '八', '九']
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            yAxis: {
                type: 'log',
                name: 'y'
            },
            series: [
                {
                    name: '3的指数',
                    type: 'line',
                    data: [1, 9, 6]
                },
                {
                    name: '2的指数',
                    type: 'line',
                    data: [1, 2, 6]
                },
                {
                    name: '1/2的指数',
                    type: 'line',
                    data: [1/2, 512, 22]
                }
            ]
        };

        var myChart_index = echarts.init(document.getElementById('echart-index'));
        myChart_index.setOption(option_index);
        var myChart_menu = echarts.init(document.getElementById('echart-menu'));
        myChart_menu.setOption(option_menu);

    });
</script>

@endsection


