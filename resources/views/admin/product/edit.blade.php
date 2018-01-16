@extends('admin.layout.layout')

@section('title')
    @if(empty($encode_id)) 创建新产品 @else 编辑产品 @endif
@endsection

@section('header')
    @if(empty($encode_id)) 创建新产品 @else 编辑产品 @endif
@endsection

@section('description')
    @if(empty($encode_id)) 创建新产品 @else 编辑产品 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{url('/admin/product/list')}}"><i class="fa "></i> 产品列表</a></li>
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

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-product">
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
                    <label class="control-label col-md-2">产品详情</label>
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
                        <button type="button" class="btn btn-primary" id="edit-product-submit"><i class="fa fa-check"></i> 提交</button>
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
    var ue = UE.getEditor('container');
    ue.ready(function() {
        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
    });
    $(function() {
        // 添加or修改产品信息
        $("#edit-product-submit").on('click', function() {
            var options = {
                url: "/admin/product/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/admin/product/list";
                    }
                }
            };
            $("#form-edit-product").ajaxSubmit(options);
        });

        $(".xx").on("click", function() {
            var html = ue.getContent();
            $(".yy").html(html);
        });


    });

</script>
<script type="text/javascript">


</script>
@endsection
