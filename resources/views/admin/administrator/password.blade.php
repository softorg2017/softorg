@extends('admin.layout.layout')

@section('title', '修改密码')
@section('header', '修改密码')
@section('description', '修改密码')

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>首页</a></li>
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

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-password">
            <div class="box-body">

                {{csrf_field()}}

                {{--原密码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">原密码</label>
                    <div class="col-md-8 ">
                        <div><input type="password" class="form-control" name="password_pre" placeholder="原密码" value=""></div>
                    </div>
                </div>
                {{--新密码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">新密码</label>
                    <div class="col-md-8 ">
                        <div><input type="password" class="form-control" name="password_new" placeholder="新密码" value=""></div>
                    </div>
                </div>
                {{--确认密码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">确认密码</label>
                    <div class="col-md-8 ">
                        <div><input type="password" class="form-control" name="password_confirm" placeholder="确认密码" value=""></div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-password-submit"><i class="fa fa-check"></i> 提交</button>
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
        // 修改密码
        $("#edit-password-submit").on('click', function() {
            var options = {
                url: "/admin/administrator/password/reset",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/admin";
                    }
                }
            };
            $("#form-edit-password").ajaxSubmit(options);
        });
    });
</script>
@endsection
