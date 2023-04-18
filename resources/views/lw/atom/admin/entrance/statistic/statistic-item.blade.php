@extends(env('TEMPLATE_ADMIN').'admin.layout.layout')


@section('head_title','【内容统计】 - 管理员后台系统 - 如未科技')


@section('header','')
@section('description','【内容统计】 - 管理员后台系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    {{--<li><a href="{{ url('/admin/statistic') }}"><i class="fa fa-bar-chart"></i>流量统计</a></li>--}}
    <li><a href="{{ url('/admin/item/item-all-list') }}"><i class="fa fa-list"></i>内容列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
{{--网站总流量统计--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">
                     <a target="_blank" href="/item/{{ $item->id }}">{{ $item->title }}</a>
                </h3>
            </div>

            {{--访问统计--}}
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div id="echart-item" style="width:100%;height:320px;"></div>
                    </div>
                </div>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>


{{--总访问比例--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">访问比例</h3>
            </div>

            <div class="box-body">
                <div class="row">

                    <div class="col-md-4">
                        <div id="echart-device-type" style="width:100%;height:320px;"></div>
                    </div>

                    <div class="col-md-4">
                        <div id="echart-system" style="width:100%;height:320px;"></div>
                    </div>

                    <div class="col-md-4">
                        <div id="echart-app" style="width:100%;height:320px;"></div>
                    </div>

                </div>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>


{{--分享流量统计--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">分享统计</h3>
            </div>

            {{--分享统计--}}
            <div class="box-body">
                <div class="row">

                    <div class="col-md-9">
                        <div id="echart-shared-item" style="width:100%;height:320px;"></div>
                    </div>

                    <div class="col-md-3">
                        <div id="echart-shared-item-scale" style="width:100%;height:320px;"></div>
                    </div>

                </div>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>


{{--分享渠道比例--}}
<div class="row _none">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">分享占比</h3>
            </div>

            <div class="box-body">
                <div class="row">

                    <div class="col-md-8 col-md-offset-2">
                        <div id="echart-shared-item-scale-" style="width:100%;height:320px;"></div>
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


@section('custom-js')
    <script src="{{ asset('/lib/js/echarts-3.7.2.min.js') }}"></script>
@endsection
@section('custom-script')
<script>
    $(function(){

        // 访问统计
        var $item_res = new Array();
        $.each({!! $data !!},function(key,v){
            $item_res[(v.day - 1)] = { value:v.count, name:v.day };
        });
        var option_item = {
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
                data:['流量统计']
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
                    axisLabel : { interval:0 },
                    data : [
                        1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31
                        {{--@foreach($all as $v)--}}
                            {{--@if (!$loop->last) '{{$v->date}}', @else '{{$v->date}}' @endif--}}
                        {{--@endforeach--}}
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
                    name:'当月访问量',
                    type:'line',
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    itemStyle : { normal: { label : { show: true } } },
                    data: $item_res
                    {{--data:[--}}
                        {{--@foreach($all as $v)--}}
                        {{--@if (!$loop->last)--}}
                            {{--{ value:'{{ $v->count }}', name:'{{ $v->day }}' },--}}
                        {{--@else--}}
                            {{--{ value:'{{ $v->count }}', name:'{{ $v->day }}' }--}}
                        {{--@endif--}}
                        {{--@endforeach--}}
                    {{--]--}}
                }
            ]
        };
        var myChart_item = echarts.init(document.getElementById('echart-item'));
        myChart_item.setOption(option_item);




        // 移动端占比
        var option_device_type = {
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
                    @foreach($open_device_type as $v)
                        @if (!$loop->last) '{{ $v->name }}', @else '{{ $v->name }}' @endif
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
                        @foreach($open_device_type as $v)
                        @if (!$loop->last)
                            { value:'{{ $v->count }}', name:'{{ $v->name }}' },
                        @else
                            { value:'{{ $v->count }}', name:'{{ $v->name }}' }
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_type = echarts.init(document.getElementById('echart-device-type'));
        myChart_type.setOption(option_device_type);

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
                            @if (!$loop->last) '{{ $v->open_system }}', @else '{{ $v->open_system }}' @endif
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
                        { value:'{{ $v->count }}', name:'{{ $v->open_system }}' },
                            @else
                        { value:'{{ $v->count }}', name:'{{ $v->open_system }}' }
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_system = echarts.init(document.getElementById('echart-system'));
        myChart_system.setOption(option_system);

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
                    @foreach($open_device_type as $v)
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
                            { value:'{{ $v->count }}', name:'{{ $v->open_app }} '},
                        @else
                            { value:'{{ $v->count }}', name:'{{ $v->open_app }} '}
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_app = echarts.init(document.getElementById('echart-app'));
        myChart_app.setOption(option_app);




        // 总分享统计
        var $shared_item_res = new Array();
        $.each({!! $shared_data !!},function(key,v){
            $shared_item_res[(v.day - 1)] = { value:v.count, name:v.day };
        });
        var option_shared_item = {
            title: {
                text: '分享统计'
            },
            tooltip : {
                trigger: 'axis',
                axisPointer: {
                    type: 'line',
                    label: {
                        backgroundColor: '#36a'
                    }
                }
            },
            legend: {
                data:['分享统计']
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
                    axisLabel : { interval:0 },
                    data : [
                        1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31
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
                    name:'分享统计',
                    type:'line',
                    label: {
                        normal: {
                            show: true,
                            position: 'top'
                        }
                    },
                    itemStyle: {
                        normal: {
                            lineStyle: {
                                color: '#36a'
                            }
                        }
                    },
                    data: $shared_item_res
                }
            ]
        };
        var myChart_shared_item = echarts.init(document.getElementById('echart-shared-item'));
        myChart_shared_item.setOption(option_shared_item);


        // 分享占比
        var option_shared_item_scale = {
            title : {
                text: '分享占比',
                subtext: '分享占比',
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
                    @foreach($shared_data_scale as $v)
                            @if (!$loop->last) '{{ $v->name }}', @else '{{ $v->name }}' @endif
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
                    name:'分享渠道',
                    type:'pie',
                    radius : '55%',
                    center: ['50%', '60%'],
                    data: [
                        @foreach($shared_data_scale as $v)
                        @if (!$loop->last)
                            { value:'{{ $v->count }}', name:'{{ $v->name }}' },
                        @else
                            { value:'{{ $v->count }}', name:'{{ $v->name }}' }
                        @endif
                        @endforeach
                    ]
                }
            ]
        };
        var myChart_shared_item_scale = echarts.init(document.getElementById('echart-shared-item-scale'));
        myChart_shared_item_scale.setOption(option_shared_item_scale);

    });
</script>

@endsection


