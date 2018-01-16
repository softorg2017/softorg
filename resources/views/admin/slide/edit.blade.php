@extends('admin.layout.layout')

@section('title','编辑幻灯片')
@section('header','编辑幻灯片')
@section('description','编辑幻灯片')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{url('/admin/slide/list')}}"><i class="fa "></i>幻灯片列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">基本信息</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-slide">
            <div class="box-body">
                {{csrf_field()}}
                <input type="hidden" name="id" value="{{$encode_id or encode(0)}}" readonly>
                <input type="hidden" name="operate" value="edit" readonly>

                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">幻灯片名称</label>
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
                {{--描述--}}
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
                    <label class="control-label col-md-2">内容详情</label>
                    <div class="col-md-8 ">
                        <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain">{!! $data->content or '' !!}</script>
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

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-slide-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-warning">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">幻灯页管理</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
                <input type="hidden" id="slide-page-marking" data-key="1000">
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-page">
            <div class="box-body">
                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate or ''}}" readonly>
                <input type="hidden" name="slide_id" value="{{$encode_id or encode(0)}}" readonly>
                <div class="box-header with-border page-container">
                    {{--操作--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">操作</label>
                        <div class="col-md-8">
                            <button type="button" class="btn btn-sm btn-success create-new-page">添加新页</button>
                            <button type="button" class="btn btn-sm btn-danger delete-all-page">删除全部</button>
                        </div>
                    </div>
                </div>

                <div id="sortable">
                @foreach($data->pages as $v)
                <div class="box-body page-container page-option" data-id="{{$v->encode_id or ''}}">
                    {{--信息--}}
                    <div class="form-group">
                        <input type="hidden" name="page[{{$v->order}}][id]" value="{{$v->id or ''}}">
                        <label class="col-md-8 col-md-offset-2">幻灯页 ({{$loop->index+1}})</label>
                    </div>
                    {{--标题--}}
                    <div class="form-group">
                        <div class="row">
                            <label class="control-label col-md-2">名称</label>
                            <div class="col-md-8"><input type="text" readonly class="form-control" name="" value="{{$v->name or ''}}"></div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-2">标题</label>
                            <div class="col-md-8"><input type="text" readonly class="form-control" name="" value="{{$v->title or ''}}"></div>
                        </div>
                        <div class="row">
                            <label class="control-label col-md-2">描述</label>
                            <div class="col-md-8"><input type="text" readonly class="form-control" name="" value="{{$v->description or ''}}"></div>
                        </div>
                    </div>
                    {{--操作--}}
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-2">
                            <a href="/admin/slide/page/edit/{{$v->encode_id or ''}}" target="_blank">
                                <button type="button" class="btn btn-sm btn-primary edit-this-page">编辑该页</button>
                            </a>
                            @if(false)
                            <button type="button" class="btn btn-xs btn-success create-next-page">添加</button>
                            <button type="button" class="btn btn-xs btn-danger delete-this-page">删除</button>
                            <button type="button" class="btn btn-xs moveup-this-page">上移</button>
                            <button type="button" class="btn btn-xs movedown-this-page">下移</button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-page-submit"><i class="fa fa-check"></i> 保存</button>
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
    $("#edit-slide-submit").on('click', function() {
        var options = {
            url: "/admin/slide/edit",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else layer.msg(data.msg);
            }
        };
        $("#form-edit-slide").ajaxSubmit(options);

//        var form = $("#form-edit-slide");
//        var url = '/admin/slide/edit';
//        $.post(url, form.serialize(), function(data){
//            if(data.success){
//                layer.msg(1);
//            } else {
//                layer.msg(2);
//            }
//        }, 'json');
    });

    // 修改幻灯页头
    $("#edit-page-submit").on('click', function() {
        var options = {
            url: "/admin/slide/page/order",
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

    $(".create-new-page").on('click', function () {
        var key = parseInt($("#slide-page-marking").attr("data-key"));
        $("#slide-page-marking").attr("data-key",key+1);
        var html = page_html(key);
        $('.page-container:last').after(html);
        $('.page-option').show();
        $('.input-focus').focus();
    });
    $(".delete-all-page").on('click', function () {
        $(".page-option").remove();
    });

    $("#form-edit-page").on('click', '.create-next-page', function () {
        var key = parseInt($("#slide-page-marking").attr("data-key"));
        $("#slide-page-marking").attr("data-key",key+1);
        var html = page_html(key);
        $(this).parents(".page-option").after(html);
        $('.page-option').show();
    });
    $("#form-edit-page").on('click', ".delete-this-page", function () {
        $(this).parents(".page-option").remove();
    });
    $("#form-edit-page").on('click', ".moveup-this-page", function () {
        var that = $(this).parents(".page-option");
        if(!that.prev().is(".page-option")) layer.msg("已经是第一个元素了");
        else that.prev().before(that);
    });
    $("#form-edit-page").on('click', ".movedown-this-page", function () {
        var that = $(this).parents(".page-option");
        if(!that.next().is(".page-option")) layer.msg("已经是最后一个元素了");
        else that.next().after(that);
    });

    // 排序
    $("#sortable").sortable();

});



function page_html(key)
{
    var html =
            '<div class="box-body page-container page-option">'+
                '<div class="form-group">'+
                    '<input type="hidden" name="page['+key+'][id]">'+
                        '<label class="control-label col-md-2">添加幻灯页</label>'+
                        '<div class="col-md-8">'+
                            '<div><input type="text" class="form-control input-focus" name="page['+key+'][name]" placeholder="请输入名称"></div>'+
                            '<div><input type="text" class="form-control" name="page['+key+'][title]" placeholder="请输入标题"></div>'+
                            '<div><input type="text" class="form-control" name="page['+key+'][description]" placeholder="请输入说明"></div>'+
                        '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<div class="col-md-8 col-md-offset-2">'+
//                        '<button type="button" class="btn btn-sm btn-primary edit-this-page">编辑内容</button>'+
//                        '<button type="button" class="btn btn-sm btn-success create-next-page">添加</button>'+
                        '<button type="button" class="btn btn-sm btn-danger delete-this-page">取消添加</button>'+
//                        '<button type="button" class="btn btn-sm moveup-this-page">上移</button>'+
//                        '<button type="button" class="btn btn-sm movedown-this-page">下移</button>'+
                    '</div>'+
                '</div>'+
            '</div>';
    return html;
;

}

</script>
@endsection
