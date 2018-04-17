@extends('admin.layout.layout')

@section('title')
    @if(empty($encode_id)) 添加目录 @else 编辑目录 @endif
@endsection

@section('header')
    @if(empty($encode_id)) 添加目录 @else 编辑目录 @endif
@endsection

@section('description')
    @if(empty($encode_id)) 添加目录 @else 编辑目录 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url(config('common.org.admin.prefix').'/admin')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li><a href="{{url(config('common.org.admin.prefix').'/admin/menu/list')}}"><i class="fa "></i> 目录列表</a></li>
    <li><a href="#"><i class="fa "></i> Here</a></li>
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

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-menu">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate_id or ''}}" readonly>
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>

                {{--名称--}}
                <div class="form-group" style="display:none;">
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
                <div class="form-group" style="display:none;">
                    <label class="control-label col-md-2">内容</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="content" placeholder="内容" value="{{$data->content or ''}}"></div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-menu-submit"><i class="fa fa-check"></i> 提交</button>
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
        // 添加or编辑
        $("#edit-menu-submit").on('click', function() {
            var options = {
                url: "{{url(config('common.org.admin.prefix').'/admin/menu/edit')}}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{url(config('common.org.admin.prefix').'/admin/menu/list')}}";
                    }
                }
            };
            $("#form-edit-menu").ajaxSubmit(options);
        });
    });
</script>
@endsection
