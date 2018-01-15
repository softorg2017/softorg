@extends('admin.layout.layout')

@section('title','创建新幻灯片')
@section('header','创建新幻灯片')
@section('description','创建新幻灯片')
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

            <div class="box-header with-border" style="margin: 15px 0;">
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
                <input type="hidden" name="id" value="{{encode(0)}}" readonly>
                <input type="hidden" name="operate" value="add" readonly>

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
                        <div><input type="text" class="form-control" name="title" placeholder="请输入标题" value=""></div>
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="description" placeholder="描述" value=""></div>
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
                    <label class="control-label col-md-2">内容</label>
                    <div class="col-md-8 ">
                        <div>
                            @include('UEditor::head')
                            <!-- 加载编辑器的容器 -->
                            <script id="container" name="content" type="text/plain"></script>
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
                {{--封面图片--}}
                <div class="form-group">
                    <label class="control-label col-md-2">上传封面图片</label>
                    <div class="col-md-8 ">
                        <div><input type="file" name="cover" placeholder="请上传封面图片"></div>
                    </div>
                </div>
            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin: 15px 0;">
                    <div class="col-md-offset-2 col-md-8">
                        <button type="button" class="btn btn-primary" id="edit-slide-submit"><i class="fa fa-check"></i> 提交</button>
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

    // 添加幻灯片信息
    $("#edit-slide-submit").on('click', function() {
        var options = {
            url: "/admin/slide/edit",
            type: "post",
            dataType: "json",
            // target: "#div2",
            success: function (data) {
                if(!data.success) layer.msg(data.msg);
                else location.href = "/admin/slide/list";
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

});

function page_html(key)
{
    var html =
            '<div class="box-body page-container page-option">'+
                '<div class="form-group">'+
                    '<input type="hidden" name="page['+key+'][id]">'+
                        '<label class="control-label col-md-2">页标题</label>'+
                        '<div class="col-md-8">'+
                            '<div><input type="text" class="form-control" name="page['+key+'][title]" placeholder="请输入标题"></div>'+
                        '</div>'+
                '</div>'+
                '<div class="form-group">'+
                    '<label class="control-label col-md-2"></label>'+
                    '<div class="col-md-8">'+
//                        '<button type="button" class="btn btn-xs btn-primary edit-this-page">编辑内容</button>'+
                        '<button type="button" class="btn btn-xs btn-success create-next-page">添加</button>'+
                        '<button type="button" class="btn btn-xs btn-danger delete-this-page">删除</button>'+
                        '<button type="button" class="btn btn-xs moveup-this-page">上移</button>'+
                        '<button type="button" class="btn btn-xs movedown-this-page">下移</button>'+
                    '</div>'+
                '</div>'+
            '</div>';
    return html;
;

}

</script>
@endsection
