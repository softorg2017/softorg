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

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">目录页流量统计</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            {{--产品目录--}}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-menu-product" style="width:100%;height:240px;"></div>
                    </div>
                </div>
            </div>

            {{--活动目录--}}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-menu-activity" style="width:100%;height:240px;"></div>
                    </div>
                </div>
            </div>

            {{--问卷目录--}}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-menu-survey" style="width:100%;height:240px;"></div>
                    </div>
                </div>
            </div>

            {{--文章目录--}}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-menu-article" style="width:100%;height:240px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">PC端/移动端占比</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-type" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">打开APP占比</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-app" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">打开系统占比</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="survey-question-marking" data-key="1000">
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-system" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
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

        // 主页访问数
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
        var myChart_index = echarts.init(document.getElementById('echart-index'));
        myChart_index.setOption(option_index);



        // 产品目录访问数
        var option_menu_product = {
            title: {
                text: '产品目录流量图'
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
                data:['产品目录']
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
                        @foreach($product as $v)
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
                }
            ]
        };
        var myChart_menu_product = echarts.init(document.getElementById('echart-menu-product'));
        myChart_menu_product.setOption(option_menu_product);

        // 活动目录访问数
        var option_menu_activity = {
            title: {
                text: '活动目录流量图'
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
                data:['活动目录']
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
                        @foreach($activity as $v)
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
                }
            ]
        };
        var myChart_menu_activity = echarts.init(document.getElementById('echart-menu-activity'));
        myChart_menu_activity.setOption(option_menu_activity);

        // 问卷目录访问数
        var option_menu_survey = {
            title: {
                text: '问卷目录流量图'
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
                data:['问卷目录']
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
                        @foreach($survey as $v)
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
                }
            ]
        };
        var myChart_menu_survey = echarts.init(document.getElementById('echart-menu-survey'));
        myChart_menu_survey.setOption(option_menu_survey);

        // 文章目录访问数
        var option_menu_article = {
            title: {
                text: '文章目录流量图'
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
                data:['文章目录']
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
                        @foreach($article as $v)
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
        var myChart_menu_article = echarts.init(document.getElementById('echart-menu-article'));
        myChart_menu_article.setOption(option_menu_article);



        // 移动端占比
        var option_type = {
            title : {
                text: '移动端占比',
                subtext: '移动端占比',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data: [
                    @foreach($open_type as $v)
                            @if (!$loop->last) '{{$v->name}}', @else '{{$v->name}}' @endif
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
                        @foreach($open_type as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->name}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->name}}'}
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_type = echarts.init(document.getElementById('echart-type'));
        myChart_type.setOption(option_type);


        // APP占比
        var option_app = {
            title : {
                text: '打开App占比',
                subtext: '打开App占比',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data: [
                    @foreach($open_type as $v)
                            @if (!$loop->last) '{{$v->open_app}}', @else '{{$v->open_app}}' @endif
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
                        @foreach($open_app as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->open_app}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->open_app}}'}
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_app = echarts.init(document.getElementById('echart-app'));
        myChart_app.setOption(option_app);


        // 打开系统占比
        var option_system = {
            title : {
                text: '打开系统占比',
                subtext: '打开系统占比',
                x:'center'
            },
            tooltip : {
                trigger: 'item',
                formatter: "{a} <br/>{b} : {c} ({d}%)"
            },
            legend: {
                orient : 'vertical',
                x : 'left',
                data: [
                    @foreach($open_system as $v)
                            @if (!$loop->last) '{{$v->open_system}}', @else '{{$v->open_system}}' @endif
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
                        @foreach($open_system as $v)
                        @if (!$loop->last)
                            {value:{{$v->count}},name:'{{$v->open_system}}'},
                        @else
                            {value:{{$v->count}},name:'{{$v->open_system}}'}
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_system = echarts.init(document.getElementById('echart-system'));
        myChart_system.setOption(option_system);



    });
</script>

@endsection


