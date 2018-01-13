@extends('admin.layout.layout')

@section('title','选择网站样式')
@section('header','选择网站样式')
@section('description','选择网站样式')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">选择网站样式</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-style">
            <div class="box-body">
                {{csrf_field()}}

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">主题颜色</label>
                    <div class="col-md-8 ">
                        <div>
                        <select class="form-control" name="style" value="{{$org->style}}">
                            <option value="0" @if($org->style == 0) selected @endif>默认黑色</option>
                            {{--<option value="1" @if($org->style == 1) selected @endif>白色</option>--}}
                            <option value="2" @if($org->style == 2) selected @endif>灰黑</option>
                            <option value="3" @if($org->style == 3) selected @endif>灰白</option>
                            <option value="4" @if($org->style == 4) selected @endif>红色</option>
                            <option value="5" @if($org->style == 5) selected @endif>蓝色</option>
                            <option value="6" @if($org->style == 6) selected @endif>绿色</option>
                            <option value="7" @if($org->style == 7) selected @endif>黄色</option>
                            <option value="8" @if($org->style == 8) selected @endif>紫色</option>
                            <option value="9" @if($org->style == 9) selected @endif>橙色</option>
                        </select>
                        </div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" onclick="" class="btn btn-primary" id="edit-style-submit"><i class="fa fa-check"></i>提交</button>
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
        $("#edit-style-submit").on('click', function() {
            var options = {
                url: "/admin/website/style",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
//                        location.href = "/admin/softorg/index";
                    }
                }
            };
            $("#form-edit-style").ajaxSubmit(options);
        });
    });
</script>
@endsection