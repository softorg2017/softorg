@extends('admin.layout.layout')

@section('title','编辑管理员信息')
@section('header','编辑管理员信息')
@section('description','编辑管理员信息')

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">管理员信息</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-administrator">
            <div class="box-body">
                {{csrf_field()}}

                {{--昵称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">昵称</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="nickname" placeholder="请输入昵称" value="{{$me->nickname}}"></div>
                    </div>
                </div>

                {{--真实姓名--}}
                <div class="form-group">
                    <label class="control-label col-md-2">真实姓名</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="true_name" placeholder="请输入真实姓名" value="{{$me->true_name}}"></div>
                    </div>
                </div>

                {{--portrait--}}
                <div class="form-group">
                    <label class="control-label col-md-2">头像</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($me->portrait_img))
                                    <img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$me->portrait_img.'?'.rand(0,99))}}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                            </div>
                            <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="portrait_img" />
                                </span>
                                <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                            </div>
                        </div>
                        <div id="titleImageError" style="color: #a94442"></div>

                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" onclick="" class="btn btn-success" id="edit-administrator-submit"><i class="fa fa-check"></i>提交</button>
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
        // 添加or修改产品信息
        $("#edit-administrator-submit").on('click', function() {
            var options = {
                url: "{{url('/admin/administrator/edit')}}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{url('/admin/administrator/index')}}";
                    }
                }
            };
            $("#form-edit-administrator").ajaxSubmit(options);
        });
    });
</script>
@endsection