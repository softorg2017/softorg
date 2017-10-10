@extends('admin.layout.layout')

@section('title','编辑企业信息')
@section('header','编辑企业信息')
@section('description','编辑企业信息')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/company/product/list')}}"><i class="fa "></i>产品列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">编辑企业信息</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-company">
            <div class="box-body">
                {{csrf_field()}}

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业全称</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="name" placeholder="请输入全称" value="{{$company->name}}"></div>
                    </div>
                </div>
                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业简称</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="short" placeholder="请输入简称" value="{{$company->short or ''}}"></div>
                    </div>
                </div>
                {{--标语 slogan--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业标语 Slogan</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="slogan" placeholder="请输入标语 slogan" value="{{$company->slogan or ''}}"></div>
                    </div>
                </div>
                {{--描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业描述</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="description" placeholder="请输入描述" value="{{$company->description or ''}}"></div>
                    </div>
                </div>
                {{--企业电话--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业电话</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="telephone" placeholder="请输入电话" value="{{$company->telephone or ''}}"></div>
                    </div>
                </div>
                {{--企业Email--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业Email</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="email" placeholder="请输入邮箱" value="{{$company->email or ''}}"></div>
                    </div>
                </div>
                {{--企业QQ--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业QQ</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="qq" placeholder="请输入QQ" value="{{$company->qq or ''}}"></div>
                    </div>
                </div>
                {{--企业微信--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业微信号</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="wechat" placeholder="请输入微信号" value="{{$company->wechat or ''}}"></div>
                    </div>
                </div>
                {{--logo--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业logo</label>
                    <div class="col-md-8 ">
                        <div><input type="file" name="logo" placeholder="请上传logo" value="{{$company->logo or ''}}"></div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" onclick="" class="btn btn-primary" id="edit-company-submit"><i class="fa fa-check"></i>提交</button>
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
        $("#edit-company-submit").on('click', function() {
            var options = {
                url: "/admin/company/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/admin/company/index";
                    }
                }
            };
            $("#form-edit-company").ajaxSubmit(options);
        });
    });
</script>
@endsection