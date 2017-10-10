@extends('admin.layout.layout')

@section('title','幻灯片 - 页面编辑')
@section('header','幻灯片 - 页面编辑')
@section('description','幻灯片 - 页面编辑')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i> 首页</a></li>
    <li><a href="{{url('/admin/slide/list')}}"><i class="fa "></i> 幻灯片列表</a></li>
    <li><a href="#"><i class="fa "></i> Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin: 15px 0;">
                <h3 class="box-title">修改：({{$data->slide->title or ''}}) {{$data->name or ''}}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-page">
            <div class="box-body">
                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate_id or ''}}" readonly>
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>

                {{--名称--}}
                <div class="form-group">
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
                {{--内容--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="description" placeholder="描述" value="{{$data->description or ''}}"></div>
                    </div>
                </div>
                {{--内容--}}
                <div class="form-group">
                    <label class="control-label col-md-2">内容详情</label>
                    <div class="col-md-8 ">
                        <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain" style="width:100%;">{!! $data->content or '' !!}</script>
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
            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin: 15px 0;">
                    <div class="col-md-offset-2 col-md-8">
                        <button type="button" class="btn btn-primary" id="edit-page-submit"><i class="fa fa-check"></i> 提交</button>
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

    // 修改幻灯页头
    $("#edit-page-submit").on('click', function() {
        var options = {
            url: "/admin/slide/page/edit",
            type: "post",
            dataType: "json",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg("操作成功");
                    location.reload();
                }
            }
        };
        $("#form-edit-page").ajaxSubmit(options);
    });

});
</script>
@endsection
