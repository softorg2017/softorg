@extends('outside.admin.layout.layout')

@section('title','目录排序')
@section('header','目录排序')
@section('description','目录排序')

@section('breadcrumb')
    <li><a href="{{url(config('outside.admin.prefix').'/admin')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li><a href="{{url(config('outside.admin.prefix').'/admin/menu/list')}}"><i class="fa "></i> 目录列表</a></li>
    <li><a href="#"><i class="fa "></i> Here</a></li>
@endsection

@section('style')
    <link rel="stylesheet" href="{{asset('css/admin/question.css')}}">
    <style>
        .option-remove{position:absolute;top:0;right:16px;width:32px;height:100%;}
    </style>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">目录排序</h3>
                <span>（拖动排序）</span>
                <input type="hidden" id="marking" data-key="1000">
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-sort-menu">
                <div class="box-body" id="sortable">
                    {{csrf_field()}}
                    <input type="hidden" name="admin" value="{{ encode(Auth::guard('org_admin')->id()) }}" readonly>

                    @foreach($data as $k => $v)
                    <div class="box-body sort-option" data-id="{{$v->encode_id or ''}}">
                        <input type="hidden" name="menu[{{$k}}][id]" value="{{$v->id or ''}}">
                        {{--标题--}}
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-2">
                                <h4><span class="title">{{$v->title or ''}}</span></h4>
                                <span class="description">{{$v->description or ''}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="sort-menu-submit"><i class="fa fa-check"></i> 保存排序</button>
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


    // 排序
    $("#sortable").sortable();

    // 修改排序
    $("#sort-menu-submit").on('click', function() {
        var options = {
            url: "{{url(config('outside.admin.prefix').'/admin/menu/sort')}}",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else
                {
                    layer.msg(data.msg);
//                    location.reload();
                }
            }
        };
        $("#form-sort-menu").ajaxSubmit(options);
    });


});
</script>
@endsection
