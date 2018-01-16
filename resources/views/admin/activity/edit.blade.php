@extends('admin.layout.layout')

@section('title')
    @if(empty($encode_id)) 添加活动 @else 编辑活动 @endif
@endsection

@section('header')
    @if(empty($encode_id)) 添加活动 @else 编辑活动 @endif
@endsection

@section('description')
    @if(empty($encode_id)) 添加活动 @else 编辑活动 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>Home</a></li>
    <li><a href="{{url('/admin/activity/list')}}"><i class="fa "></i>活动列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
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

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-activity">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate_id or ''}}" readonly>
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">名称</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="name" placeholder="后台管理名称" value="{{$data->name or ''}}"></div>
                    </div>
                </div>
                {{--标题--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标题</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="title" placeholder="标题" value="{{$data->title or ''}}"></div>
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="description" placeholder="描述" value="{{$data->description or ''}}"></div>
                    </div>
                </div>
                {{--目录--}}
                <div class="form-group">
                    <label class="control-label col-md-2">目录</label>
                    <div class="col-md-8 ">
                        <select class="form-control" onchange="select_menu()">
                            <option data-id="0">未分类</option>
                            @if(!empty($data->org->menus))
                                @foreach($data->org->menus as $v)
                                    <option data-id="{{$v->id}}" @if($data->menu_id == $v->id) selected="selected" @endif>{{$v->title}}</option>
                                @endforeach
                            @else
                                @foreach($org->menus as $v)
                                    <option data-id="{{$v->id}}">{{$v->title}}</option>
                                @endforeach
                            @endif
                        </select>
                        <input type="hidden" value="{{$data->menu_id or 0}}" name="menu_id" id="menu-selected">
                    </div>
                </div>
                {{--内容--}}
                <div class="form-group">
                    <label class="control-label col-md-2">活动详情</label>
                    <div class="col-md-8 ">
                        <div>
                        @include('UEditor::head')
                        <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain"> {!! $data->content or '' !!} </script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                            var ue = UE.getEditor('container');
                            ue.ready(function() {
                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                            });
                            </script>
                        </div>
                    </div>
                </div>
                {{--cover 封面图片--}}
                @if(!empty($data->cover_pic))
                    <div class="form-group">
                        <label class="control-label col-md-2">封面图片</label>
                        <div class="col-md-8 ">
                            <div class="edit-img"><img src="{{url('http://cdn.'.$_SERVER['HTTP_HOST'].'/'.$data->cover_pic.'?'.rand(0,999))}}" alt=""></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">更换封面图片</label>
                        <div class="col-md-8 ">
                            <div><input type="file" name="cover" placeholder="请上传封面图片"></div>
                        </div>
                    </div>
                @else
                    <div class="form-group">
                        <label class="control-label col-md-2">上传封面图片</label>
                        <div class="col-md-8 ">
                            <div><input type="file" name="cover" placeholder="请上传封面图片"></div>
                        </div>
                    </div>
                @endif
                {{--开始时间--}}
                <div class="form-group">
                    <label class="control-label col-md-2">开始时间</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control time-picker" name="start" placeholder="请输入开始时间" value="{{empty($data->start_time) ? '' : date("Y-m-d H:i",$data->start_time)}}">
                        </div>
                    </div>
                </div>
                {{--结束时间--}}
                <div class="form-group">
                    <label class="control-label col-md-2">结束时间</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control time-picker" name="end" placeholder="请输入结束时间" value="{{empty($data->end_time) ? '' : date("Y-m-d H:i",$data->end_time)}}">
                        </div>
                    </div>
                </div>

                {{--是否报名--}}
                <div class="form-group">
                    <label class="control-label col-md-2">报名功能</label>
                    <div class="col-md-8 ">
                        <div class="switch" data-size="small">
                            <input type="checkbox" name="apply-switch" @if(!empty($data->is_apply)) @if($data->is_apply == 1) checked @endif @endif />
                        </div>
                    </div>
                    <input type="hidden" value="{{$data->is_apply or 0}}" name="is_apply" id="apply-selected">
                </div>
                {{--报名开始时间--}}
                <div class="form-group apply-timer @if(!empty($data->is_apply)) @if($data->is_apply != 1) _none @endif @else _none @endif ">
                    <label class="control-label col-md-2">报名开始时间</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control time-picker" name="apply_start" placeholder="请输入报名开始时间" value="{{empty($data->apply_start_time) ? '' : date("Y-m-d H:i",$data->apply_start_time)}}">
                        </div>
                    </div>
                </div>
                {{--报名结束时间--}}
                <div class="form-group apply-timer @if(!empty($data->is_apply)) @if($data->is_apply != 1) _none @endif @else _none @endif ">
                    <label class="control-label col-md-2">报名结束时间</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control time-picker" name="apply_end" placeholder="请输入报名结束时间" value="{{empty($data->apply_end_time) ? '' : date("Y-m-d H:i",$data->apply_end_time)}}">
                        </div>
                    </div>
                </div>



                {{--是否签到--}}
                <div class="form-group">
                    <label class="control-label col-md-2">签到功能</label>
                    <div class="col-md-8 ">
                        <div class="switch" data-size="small">
                            <input type="checkbox" name="sign-switch" @if(!empty($data->is_sign)) @if($data->is_sign == 1) checked @endif @endif />
                        </div>
                    </div>
                    <input type="hidden" value="{{$data->is_sign or 0}}" name="is_sign" id="sign-selected">
                </div>

                {{--签到类型--}}
                <div class="form-group sign-module @if(!empty($data->is_sign)) @if($data->is_sign != 1) _none @endif @else _none @endif">
                    <label class="control-label col-md-2">签到类型</label>
                    <div class="col-md-8">
                        <select class="form-control" onchange="sign_type_change" name="sign_type" id="sign-type">
                            <option value="1">所有人均可以签到</option>
                            <option value="2">仅报名者可以签到</option>
                        </select>
                        <input type="hidden" value="">
                    </div>
                </div>

                {{--签到开始时间--}}
                <div class="form-group sign-module @if(!empty($data->is_sign)) @if($data->is_sign != 1) _none @endif @else _none @endif">
                    <label class="control-label col-md-2">签到开始时间</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control time-picker" name="sign_start" placeholder="请输入报名开始时间" value="{{empty($data->sign_start_time) ? '' : date("Y-m-d H:i",$data->sign_start_time)}}">
                        </div>
                    </div>
                </div>
                {{--签到结束时间--}}
                <div class="form-group sign-module @if(!empty($data->is_sign)) @if($data->is_sign != 1) _none @endif @else _none @endif">
                    <label class="control-label col-md-2">签到结束时间</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </div>
                            <input type="text" class="form-control time-picker" name="sign_end" placeholder="请输入报名结束时间" value="{{empty($data->sign_end_time) ? '' : date("Y-m-d H:i",$data->sign_end_time)}}">
                        </div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-activity-submit"><i class="fa fa-check"></i> 提交</button>
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
<script>
    $(function() {
        // 修改幻灯片信息
        $("#edit-activity-submit").on('click', function() {
            var options = {
                url: "/admin/activity/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/admin/activity/list";
                    }
                }
            };
            $("#form-edit-activity").ajaxSubmit(options);
        });


        // 修改幻灯片信息
        $('.time-picker').datetimepicker({
            format: 'YYYY-MM-DD HH:ss',
            showClear: true,
            showClose: true
        });

        $("[name='apply-switch']").bootstrapSwitch({
            size:"small",
            onColor:"success",
            onSwitchChange:function(event,state){
//                console.log(this); // DOM element
//                console.log(event); // jQuery event
//                console.log(state); // true | false

                var is_sign = $("input[name=is_sign]").val();
                if(state)
                {
                    $("#apply-selected").val(1);
                    $(".apply-timer").show();
                    if(is_sign == 1)
                    {
                        $("#sign-type").find("option[value=2]").show();
                    }
                }
                else
                {
                    $("#apply-selected").val(0);
                    $(".apply-timer").hide();
                    if(is_sign == 1)
                    {
                        $("#sign-type").val(1);
                        $("#sign-type").find("option[value=1]").attr("selected",true);
                        $("#sign-type").find("option[value=2]").hide();
                    }
                }
            }
        });

        $("[name='sign-switch']").bootstrapSwitch({
            size:"small",
            onColor:"success",
            onSwitchChange:function(event,state){
                if(state)
                {
                    $("#sign-selected").val(1);
                    $(".sign-module").show();
//                    $("#sign-type").find("option[value=2]").attr("selected",true);
                }
                else
                {
                    $("#sign-selected").val(0);
                    $(".sign-module").hide();
                }
            }
        });
    });

    function sign_type_change()
    {
        var is_apply = $("input[name=is_sign]").val();
    }
</script>
@endsection
