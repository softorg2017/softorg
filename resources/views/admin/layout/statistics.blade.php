@extends('admin.layout.layout')

@section('title','页面流量统计')
@section('header','页面流量统计')
@section('description','统计')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/website/statistics')}}"><i class="fa "></i>主页流量统计</a></li>
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
                <h3 class="box-title">{{$info->title or ''}}</h3>
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
                        <div id="echart" style="width:100%;height:400px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
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
});
</script>

<script>
    $(function(){

        var myChart;
        var option;
        option = {
            title: {
                text: '流量统计'
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
                data:['总访问量']
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
                        @foreach($data as $v)
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
                        @foreach($data as $v)
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

        var myChart = echarts.init(document.getElementById('echart'));
        myChart.setOption(option);

    });
</script>

@endsection


