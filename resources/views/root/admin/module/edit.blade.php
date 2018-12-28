@extends('root.admin.layout.layout')

@section('head_title')
    @if($operate == 'create') 添加模块 @else 编辑模块 @endif
@endsection

@section('header')
    @if($operate == 'create') 添加模块 @else 编辑模块 @endif
@endsection

@section('description')
    @if($operate == 'create') 添加模块 @else 编辑模块 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li><a href="{{url('/admin/module/list')}}"><i class="fa "></i> 模块列表</a></li>
    <li><a href="#"><i class="fa "></i> Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container" id="edit-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">@if($operate == 'create') 添加模块 @else 编辑模块 @endif</h3>
                <div class="box-tools pull-right">
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
                                            > 链接图片
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
                                            > 多链接图片
                                        </label>
                                    </div>
                                </button>
                            @endif
                            @if($operate == 'create' || ($operate == 'edit' && $data->type == 5))
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="type" value="5"
                                                   @if($operate == 'edit' && $data->type == 5) checked="checked" @endif
                                            > 轮播图片
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
                <div class="form-group">
                    <label class="control-label col-md-2">封面图片</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->cover_pic))
                                    <img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$data->cover_pic.'?'.rand(0,99))}}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                            </div>
                            <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="cover" />
                                </span>
                                <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                            </div>
                        </div>
                        <div id="titleImageError" style="color: #a94442"></div>

                    </div>
                </div>


                {{--链接地址--}}
                <div class="form-group img-single-show _none">
                    <label class="control-label col-md-2">链接地址</label>
                    <div class="col-md-8 ">
                        <div><input type="text" class="form-control" name="link" placeholder="链接地址" value="{{$data->link or ''}}"></div>
                    </div>
                </div>


                {{--多 链接图片--}}
                @if(!empty($data->img_multiple))
                    @foreach(json_decode($data->img_multiple) as $num => $img)
                    {{--链接地址--}}
                    <div class="form-group img-multiple-show _none" style="padding: 16px 0;">
                        <label class="control-label col-md-2">图片</label>
                        <div class="col-md-8">

                            <div>{{$img->title or ''}}</div>
                            <div>{{$img->link or ''}}</div>
                            <div class="edit-img"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$img->cover_pic)}}" alt=""></div>

                            <div class="margin-top-8">
                                <button type="button" class="btn btn-danger delete-multiple-option" data-num="{{$num}}">
                                    <i class="fa fa-"></i> 删除
                                </button>
                            </div>

                        </div>
                    </div>
                    @endforeach
                @endif
                {{--添加链接图片--}}
                <div class="form-group img-multiple-option img-multiple-show _none">
                    <label class="control-label col-md-2">添加（链接）图片</label>

                    <div class="col-md-8">

                        <div><input type="text" class="form-control" name="multiples[1000][title]" placeholder="标题" value=""></div>
                        <div><input type="text" class="form-control" name="multiples[1000][link]" placeholder="链接地址" value=""></div>

                        <div class=" fileinput-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail">
                                </div>
                                <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input class="img-file" type="file" name="multiples[1000][file]" />
                                </span>
                                    <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                                </div>
                            </div>
                        </div>


                        <div class="margin-top-16">
                            <button type="button" class="btn btn-danger remove-img-multiple-option"><i class="fa fa-"></i> 移除该图片项</button>
                        </div>

                    </div>
                </div>
                {{--添加 多 链接图片--}}
                <div class="form-group img-multiple-show img-multiple-add _none">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="add-img-multiple-option"><i class="fa fa-plus"></i> 添加一个链接图片</button>
                    </div>
                </div>


                {{--轮播图片--}}
                @if(!empty($data->img_multiple))
                    @foreach(json_decode($data->img_multiple) as $num => $img)
                    {{--链接地址--}}
                    <div class="form-group img-carousel-show _none" style="padding: 16px 0;">
                        <label class="control-label col-md-2">轮播图片</label>
                        <div class="col-md-8">

                            <div>{{$img->title or ''}}</div>
                            <div>{{$img->link or ''}}</div>
                            <div class="edit-img"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$img->cover_pic)}}" alt=""></div>

                            <div class="margin-top-8">
                                <button type="button" class="btn btn-danger delete-multiple-option" data-num="{{$num}}">
                                    <i class="fa fa-"></i> 删除
                                </button>
                            </div>

                        </div>
                    </div>
                    @endforeach
                @endif
                {{--添加轮播图片--}}
                <div class="form-group img-carousel-option img-carousel-show _none">
                    <label class="control-label col-md-2">添加（轮播）图片</label>

                    <div class="col-md-8">

                        <div><input type="text" class="form-control" name="carousels[1000][title]" placeholder="标题" value=""></div>
                        <div><input type="text" class="form-control" name="carousels[1000][link]" placeholder="链接地址" value=""></div>

                        <div class=" fileinput-group">
                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail">
                                </div>
                                <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input class="img-file" type="file" name="carousels[1000][file]" />
                                </span>
                                    <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                                </div>
                            </div>
                        </div>


                        <div class="margin-top-16">
                            <button type="button" class="btn btn-danger remove-img-carousel-option"><i class="fa fa-"></i> 移除该图片项</button>
                        </div>

                    </div>
                </div>
                {{--添加轮播图片--}}
                <div class="form-group img-carousel-show img-carousel-add _none">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="add-img-carousel-option"><i class="fa fa-plus"></i> 添加一个轮播图片</button>
                    </div>
                </div>


            </div>
            </form>


            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="edit-module-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="_none" id="clone-container">

    {{----}}
    <div class="form-group img-multiple-option img-multiple-show">

        <label class="control-label col-md-2">添加（链接）图片</label>

        <div class="col-md-8">

            <div><input type="text" class="form-control img-title" name="" placeholder="标题" value=""></div>
            <div><input type="text" class="form-control img-link" name="" placeholder="链接地址" value=""></div>

            <div class="fileinput-group">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail">
                    </div>
                    <div class="btn-tool-group">
                        <span class="btn-file">
                            <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                            <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                            <input class="img-file" type="file" name="" />
                        </span>
                        <span class="">
                            <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="margin-top-16">
                <button type="button" class="btn btn-danger remove-img-multiple-option"><i class="fa fa-"></i> 移除该图片项</button>
            </div>

        </div>

    </div>


    {{----}}
    <div class="form-group img-carousel-option img-carousel-show">

        <label class="control-label col-md-2">添加（轮播）图片</label>

        <div class="col-md-8">

            <div><input type="text" class="form-control img-title" name="" placeholder="标题" value=""></div>
            <div><input type="text" class="form-control img-link" name="" placeholder="链接地址" value=""></div>

            <div class="fileinput-group">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                    </div>
                    <div class="fileinput-preview fileinput-exists thumbnail">
                    </div>
                    <div class="btn-tool-group">
                        <span class="btn-file">
                            <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                            <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                            <input class="img-file" type="file" name="" />
                        </span>
                        <span class="">
                            <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                        </span>
                    </div>
                </div>
            </div>

            <div class="margin-top-16">
                <button type="button" class="btn btn-danger remove-img-carousel-option"><i class="fa fa-"></i> 移除该图片项</button>
            </div>

        </div>
    </div>

</div>
@endsection


@section('custom-css')
    <link href="https://cdn.bootcss.com/select2/4.0.5/css/select2.min.css" rel="stylesheet">
@endsection


@section('custom-script')
<script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>
<script>
    $(function() {


        module_type_change();

        var multiple_n = 1000;
        var carousel_n = 1000;


        // 选择类型
        $("input[name=type]").on('change', function() {
            module_type_change();
        });



        // 添加链接图片项
        $("#edit-container").on('click', '#add-img-multiple-option', function() {
            var option = $("#clone-container").find(".img-multiple-option").clone();
            multiple_n = multiple_n + 1;
            option.find(".img-title").attr("name","multiples["+multiple_n+"][title]");
            option.find(".img-link").attr("name","multiples["+multiple_n+"][link]");
            option.find(".img-file").attr("name","multiples["+multiple_n+"][file]");
            $(".img-multiple-add").before(option);
        });
        // 删除链接图片项
        $("#edit-container").on('click', '.remove-img-multiple-option', function() {
            var option = $(this).parents(".img-multiple-option").remove();
        });


        // 添加图片轮播项
        $("#edit-container").on('click', '#add-img-carousel-option', function() {
            var option = $("#clone-container").find(".img-carousel-option").clone();
            carousel_n = carousel_n + 1;
            option.find(".img-title").attr("name","carousels["+carousel_n+"][title]");
            option.find(".img-link").attr("name","carousels["+carousel_n+"][link]");
            option.find(".img-file").attr("name","carousels["+carousel_n+"][file]");
            $(".img-carousel-add").before(option);
        });
        // 删除图片轮播项
        $("#edit-container").on('click', '.remove-img-carousel-option', function() {
            var option = $(this).parents(".img-carousel-option").remove();
        });



        // 【删除】
        $("#edit-container").on('click', ".delete-multiple-option", function() {
            var that = $(this);

            var encode_id = $("input[name=encode_id]").val();

            layer.msg('确定删除该"项"？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "{{url(config('outside.admin.prefix').'/admin/module/delete_multiple_option')}}",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            encode_id: encode_id,
                            num: that.attr('data-num')
                        },
                        function(data){
                            if(!data.success) layer.msg(data.msg);
                            else location.reload();
                        },
                        'json'
                    );
                }
            });
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
                url: "{{url('/admin/module/edit')}}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{url('/admin/module/list')}}";
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
            $(".img-carousel-show").hide();
        } else if(type == 2) {
            $(".column-show").show();
            $(".cover-show").show();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").show(); // show
            $(".img-single-show").hide();
            $(".img-multiple-show").hide();
            $(".img-carousel-show").hide();
        } else if(type == 3) {
            $(".column-show").hide();
            $(".cover-show").show();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").show(); // show
            $(".img-multiple-show").hide();
            $(".img-carousel-show").hide();
        } else if(type == 4) {
            $(".column-show").hide();
            $(".cover-show").hide();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").hide();
            $(".img-multiple-show").show(); // show
            $(".img-carousel-show").hide();
        } else if(type == 5) {
            $(".column-show").hide();
            $(".cover-show").hide();
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").hide();
            $(".img-multiple-show").hide();
            $(".img-carousel-show").show(); // show
        } else {
            $(".menu-single-show").hide();
            $(".menu-multiple-show").hide();
            $(".img-single-show").hide();
            $(".img-multiple-show").hide();
            $(".img-carousel-show").hide();
        }
    }
</script>
@endsection
