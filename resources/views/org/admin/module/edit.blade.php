@extends('admin.layout.layout')

@section('title')
    @if($operate == 'create') 添加模块 @else 编辑模块 @endif
@endsection

@section('header')
    @if($operate == 'create') 添加模块 @else 编辑模块 @endif
@endsection

@section('description')
    @if($operate == 'create') 添加模块 @else 编辑模块 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url(config('common.org.admin.prefix').'/admin')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li><a href="{{url(config('common.org.admin.prefix').'/admin/module/list')}}"><i class="fa "></i> 模块列表</a></li>
    <li><a href="#"><i class="fa "></i> Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info" id="edit-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-module">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate or 'create'}}" readonly>
                <input type="hidden" name="encode_id" value="{{$encode_id or encode(0)}}" readonly>

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
                        <div><input type="text" class="form-control" name="contents" placeholder="内容" value="{{$data->content or ''}}"></div>
                    </div>
                </div>

                {{--类型--}}
                <div class="form-group form-type">
                    <label class="control-label col-md-2">类型</label>
                    <div class="col-md-8">
                        <div class="btn-group">
                            @if($operate == 'create' || ($operate == 'edit' && $data->type == 1))
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type" value="1"
                                           @if($operate == 'create' || ($operate == 'edit' && $data->type == 1)) checked="checked" @endif
                                        > 单目录
                                    </label>
                                </div>
                            </button>
                            @endif
                            @if($operate == 'create' || ($operate == 'edit' && $data->type == 2))
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="type" value="2"
                                           @if($operate == 'edit' && $data->type == 2) checked="checked" @endif
                                        > 多目录
                                    </label>
                                </div>
                            </button>
                            @endif
                            @if($operate == 'create' || ($operate == 'edit' && $data->type == 3))
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="3"
                                                   @if($operate == 'edit' && $data->type == 3) checked="checked" @endif
                                            > 图片链接
                                        </label>
                                    </div>
                                </button>
                            @endif
                            @if($operate == 'create' || ($operate == 'edit' && $data->type == 4))
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="4"
                                                   @if($operate == 'edit' && $data->type == 4) checked="checked" @endif
                                            > 图片轮播
                                        </label>
                                    </div>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>


                {{--列数--}}
                <div class="form-group form-type column-show">
                    <label class="control-label col-md-2">列数</label>
                    <div class="col-md-8">
                        <div class="btn-group">
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="column" value="2"
                                           @if(!empty($data->column) && $data->column == 2) checked="checked" @endif
                                        > 两列
                                    </label>
                                </div>
                            </button>
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="column" value="3"
                                           @if(empty($data->column)) checked="checked"
                                           @else
                                               @if($data->column == 3) checked="checked" @endif
                                           @endif
                                        > 三列
                                    </label>
                                </div>
                            </button>
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="column" value="4"
                                           @if(!empty($data->column) && $data->column == 4) checked="checked" @endif
                                        > 四列
                                    </label>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                {{--单目录--}}
                <div class="form-group menu-single-show _none">
                    <label class="control-label col-md-2">选择目录</label>
                    <div class="col-md-8 ">
                        <select name="menu_id" style="width:100%;">
                            <option value="0" @if(empty($data->menu_id)) selected="selected" @endif > 未选择 </option>
                            @foreach( $menus as $key => $menu )
                                <option value="{{ $menu->id or '' }}"
                                    @if(!empty($data->menu_id) && $data->menu_id == $menu->id) selected="selected" @endif
                                > {{ $menu->title or '' }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--多目录--}}
                <div class="form-group menu-multiple-show _none">
                    <label class="control-label col-md-2">添加目录</label>
                    <div class="col-md-8 ">
                        <select name="menus[]" id="menus" style="width:100%;" multiple="multiple">
                            @foreach( $menus as $key => $menu )
                                <option value="{{ $menu->id or '' }}"> {{ $menu->title or '' }} </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{--cover 封面图片--}}
                @if(!empty($data->cover_pic))
                    <div class="form-group cover-show">
                        <label class="control-label col-md-2">封面图片</label>
                        <div class="col-md-8 ">
                            <div class="edit-img"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$data->cover_pic)}}" alt=""></div>
                        </div>
                    </div>
                    <div class="form-group cover-show">
                        <label class="control-label col-md-2">更换封面图片</label>
                        <div class="col-md-8 ">
                            <div><input type="file" name="cover" placeholder="请上传封面图片"></div>
                        </div>
                    </div>
                @else
                    <div class="form-group cover-show">
                        <label class="control-label col-md-2">上传封面图片</label>
                        <div class="col-md-8 ">
                            <div><input type="file" name="cover" placeholder="请上传封面图片"></div>
                        </div>
                    </div>
                @endif

                {{--链接地址--}}
                <div class="form-group img-single-show _none">
                    <label class="control-label col-md-2">链接地址</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="link" placeholder="链接地址" value="{{$data->link or ''}}"></div>
                    </div>
                </div>

                @if(!empty($data->img_multiple))
                    @foreach(json_decode($data->img_multiple) as $num => $img)
                    {{--链接地址--}}
                    <div class="form-group img-multiple-show _none" style="padding: 16px 0;">
                        <label class="control-label col-md-2">轮播图片</label>
                        <div class="col-md-9">
                            <div class="edit-img"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$img->cover_pic)}}" alt=""></div>
                        </div>
                        <label class="control-label col-md-2"></label>
                        <div class="col-md-8">
                            <div>{{$img->link or ''}}</div>
                        </div>
                        <div class="col-md-8 col-md-offset-2">
                            <button type="button" class="btn btn-xs btn-danger delete-img-multiple-option"><i class="fa fa-"></i> 删除</button>
                        </div>
                    </div>
                    @endforeach
                @endif
                {{--轮播图片--}}
                <div class="form-group img-multiple-option img-multiple-show _none">
                    <label class="control-label col-md-2">添加轮播图片</label>
                    <div class="col-md-8">
                        <div><input type="text" class="form-control" name="covers[1000][link]" placeholder="链接地址" value="{{$data->link or ''}}"></div>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <div><input type="file" name="covers[1000][img]" placeholder="上传图片"></div>
                    </div>
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-xs btn-danger remove-img-multiple-option"><i class="fa fa-"></i> 删除</button>
                    </div>
                </div>

                {{--添加轮播图片--}}
                <div class="form-group img-multiple-show img-multiple-add _none">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="add-img-multiple-option"><i class="fa fa-plus"></i> 添加一个轮播图片</button>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-module-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="_none" id="clone-container">
    <div class="form-group img-multiple-option img-multiple-show">
        <label class="control-label col-md-2">添加轮播图片</label>
        <div class="col-md-8">
            <div><input type="text" class="form-control covers-link" name="" placeholder="链接地址" value="{{$data->link or ''}}"></div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div><input type="file" class="covers-img" name="" placeholder="上传图片" value="{{$data->link or ''}}"></div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <button type="button" class="btn btn-xs btn-danger remove-img-multiple-option"><i class="fa fa-"></i> 删除</button>
        </div>
    </div>
</div>
@endsection


@section('style')
    <link href="https://cdn.bootcss.com/select2/4.0.5/css/select2.min.css" rel="stylesheet">
@endsection


@section('js')
<script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>
<script>
    $(function() {

        module_type_change();

        var n = 1000;


        // 选择类型
        $("input[name=type]").on('change', function() {
            module_type_change();
        });


        // 添加图片轮播项
        $("#edit-container").on('click', '#add-img-multiple-option', function() {
            var option = $("#clone-container").find(".img-multiple-option").clone();
            n = n + 1;
            option.find(".covers-link").attr("name","covers["+n+"][link]");
            option.find(".covers-img").attr("name","covers["+n+"][img]");
            $(".img-multiple-add").before(option);
        });

        // 删除图片轮播项
        $("#edit-container").on('click', '.remove-img-multiple-option', function() {
            var option = $(this).parents(".img-multiple-option").remove();
        });


//        $('#menus').select2({
//            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
//            minimumInputLength: 0,
//            theme: 'classic'
//        });

        $("#menus").select2({
            tags: true //这个参数的效果应该是，自定义内容选项卡
        });

        $("#menus").on("select2:select", function (evt) {
            var element = evt.params.data.element;
            var $element = $(element);

            $element.detach();
            if ($(this).find(":selected").length > 0) {
                $(this).find(":selected").eq(-1).after($element);
            } else {
                $(this).prepend($element);
            }
            $(this).trigger("change");
        }).on("select2:unselect", function (evt) {
            if ($(this).find(":selected").length) {
                var element = evt.params.data.element;
                var $element = $(element);
                $element.detach();
                $(this).find(":selected").eq(-1).after($element);
            }
        });




        // 添加or编辑
        $("#edit-module-submit").on('click', function() {
            var options = {
                url: "{{url(config('common.org.admin.prefix').'/admin/module/edit')}}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{url(config('common.org.admin.prefix').'/admin/module/list')}}";
                    }
                }
            };
            $("#form-edit-module").ajaxSubmit(options);
        });


    });

    function module_type_change()
    {
        var type = $("input[name=type]:checked").val();
        if(type == 1) {
            $(".column-show").show();
            $(".cover-show").show();
            $(".menu-single-show").show(); // show
            $(".menu-multiple-show").hide();
            $(".img-single-show").hide();
            $(".img-multiple-show").hide();
        } else if(type == 2) {
            $(".column-show").show();
            $(".cover-show").show();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").show(); // show
            $(".img-single-show").hide();
            $(".img-multiple-show").hide();
        } else if(type == 3) {
            $(".column-show").hide();
            $(".cover-show").show();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").show(); // show
            $(".img-multiple-show").hide();
        } else if(type == 4) {
            $(".column-show").hide();
            $(".cover-show").hide();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").hide();
            $(".img-multiple-show").show(); // show
        } else {
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").hide();
            $(".img-multiple-show").hide();
        }
    }
</script>
@endsection
