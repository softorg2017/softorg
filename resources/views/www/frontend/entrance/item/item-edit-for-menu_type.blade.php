@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')


@section('head_title')
    【内容管理】 - 如未轻博
@endsection
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header') {{ $item->title or '' }} @endsection
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-item">
        <div class="main-body-left-container bg-white">


            <div class="box box-warning">

                <div class="box-header with-border" style="margin:16px 0;">
                    <h3 class="box-title">内容结构图</h3>
                    <div class="pull-right">
                        <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                    </div>
                </div>

                <div class="box-body" id="content-structure-list">
                    <div class="col-md-12 col-md-offset-2-">
                        <div class="input-group" data-id='{{ $data->id }}' style="margin-top:4px;margin-bottom:12px;">
                            <span class="input-group-addon"><b>封面</b></span>
                            <span class="form-control multi-ellipsis-1">{{ $data->title or '' }}</span>
                            <span class="input-group-addon btn edit-this-content" style="border-left:0;"><i class="fa fa-pencil"></i></span>
                        </div>
                    </div>
                    @foreach( $data->contents_recursion as $key => $content )
                        <div class="col-md-12 col-md-offset-2-">
                            <div class="input-group" data-id='{{ $content->id }}' style="margin-top:4px; margin-left:{{ $content->level*34 }}px">
                                <span class="input-group-addon">
                                    {{--@if($content->type == 1)--}}
                                        {{--<i class="fa fa-list-ul"></i>--}}
                                    {{--@else--}}
                                        {{--<i class="fa fa-file-text"></i>--}}
                                    {{--@endif--}}
                                    <b>{{ $content->rank or '0' }}</b>
                                </span>
                                <span class="form-control multi-ellipsis-1">{{ $content->title or '' }}</span>

                                @if($content->item_active == 0)
                                    <span class="input-group-addon btn enable-this-content" title="启用"><b>未启用</b></span>
                                @elseif($content->item_active == 1)
                                    <span class="input-group-addon btn disable-this-content" title="禁用"><b class="text-green">已启用</b></span>
                                @else
                                    <span class="input-group-addon btn enable-this-content" title="启用"><b class="text-red">已禁用</b></span>
                                @endif
                                {{--@if($content->type == 1)--}}
                                <span class="input-group-addon btn create-follow-menu" style="border-left:0;"><i class="fa fa-plus"></i></span>
                                {{--@endif--}}
                                <span class="input-group-addon btn edit-this-content" style="border-left:0;"><i class="fa fa-pencil"></i></span>
                                <span class="input-group-addon btn delete-this-content"><i class="fa fa-trash"></i></span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="box-footer">
                    <div class="row" style="margin:16px 0;">
                        <div class="col-md-12 col-md-offset-2-">
                            <button type="button" class="btn btn-success show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                            <a href="{{ url('/item/'.$data->id) }}" target="_blank"><button type="button" class="btn btn-primary">预览</button></a>
                            <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box box-info form-container">

                <div class="box-header with-border" style="margin:16px 0;">
                    <h3 class="box-title">添加/编辑内容</h3>
                    <div class="pull-right _none">
                        <button type="button" class="btn btn-success pull-right show-create-content"><i class="fa fa-plus"></i> 添加新内容</button>
                    </div>
                </div>

                <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-content">
                    <div class="box-body">

                        {{ csrf_field() }}
                        <input type="hidden" name="operate" value="{{ $operate or 'create' }}" readonly>
                        <input type="hidden" name="category" value="11" readonly>
                        <input type="hidden" name="item_type" value="11" readonly>
                        <input type="hidden" name="item_id" value="{{ $data->id or 0 }}" readonly>
                        <input type="hidden" name="content_id" value="{{ $content->id or 0 }}" readonly>

                        {{--类型--}}
                        <div class="form-group form-type _none">
                            <label class="control-label- col-md-2">类型</label>
                            <div class="col-md-12 ">
                                <div class="btn-group">
                                    <button type="button" class="btn">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type-" value="1" checked="checked"> 目录
                                            </label>
                                        </div>
                                    </button>
                                    <button type="button" class="btn">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="type-" value="2"> 内容
                                            </label>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                        {{--目录--}}
                        <div class="form-group" id="form-menu-option">
                            <label class="control-label- col-md-2">所属目录</label>
                            <div class="col-md-12 ">
                                <select name="p_id" id="menu" style="width:100%;">

                                    <option value="0">顶级目录</option>

                                    @foreach( $data->contents_recursion as $key => $content )
                                        {{--@if($content->type == 1)--}}

                                        <option value="{{ $content->id or '' }}">
                                            @for ($i = 0; $i < $content->level; $i++)
                                                —>
                                            @endfor
                                            {{ $content->title or '' }}
                                        </option>

                                        {{--@endif--}}
                                    @endforeach

                                </select>
                            </div>
                        </div>
                        {{--排序--}}
                        <div class="form-group" id="form-rank-option">
                            <label class="control-label- col-md-2">排序</label>
                            <div class="col-md-12 ">
                                <input type="text" class="form-control" name="rank" placeholder="默认排序" value="1">
                            </div>
                        </div>
                        {{--标题--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">标题</label>
                            <div class="col-md-12 ">
                                <input type="text" class="form-control" name="title" placeholder="请输入标题，必填" value="">
                            </div>
                        </div>
                        {{--描述--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">描述</label>
                            <div class="col-md-12 ">
                                <textarea class="form-control" name="description" rows="3" placeholder="描述"></textarea>
                            </div>
                        </div>
                        {{--内容--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">图文详情</label>
                            <div class="col-md-12 ">
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
                        {{--cover 封面图片--}}
                        <div class="form-group">
                            <label class="control-label- col-md-2">封面图片</label>
                            <div class="col-md-12 fileinput-group">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail cover_img_container">
                                        <img class="cover_img" src="" alt="" />
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
                        {{--是否启用--}}
                        <div class="form-group form-active" id="form-active-option">
                            <label class="control-label- col-md-2 _none">是否启用</label>
                            <div class="col-md-12 ">
                                <div class="btn-group">

                                    <button type="button" class="btn radio active-none">
                                        <label>
                                            <input type="radio" name="item_active" value="0"> 不启用
                                        </label>
                                    </button>
                                    <button type="button" class="btn radio">
                                        <label>
                                            <input type="radio" name="item_active" value="1" checked="checked"> 启用
                                        </label>
                                    </button>
                                    <button type="button" class="btn radio active-disable _none">
                                        <label>
                                            <input type="radio" name="item_active" value="9"> 禁用
                                        </label>
                                    </button>

                                </div>
                            </div>
                        </div>

                    </div>
                </form>

                <div class="box-footer">
                    <div class="row" style="margin:16px 0;">
                        <div class="col-md-12 col-md-offset-2-">
                            <button type="button" class="btn btn-primary" id="edit-content-submit"><i class="fa fa-check"></i> 提交</button>
                            <button type="button" class="btn btn-default" onclick="history.go(-1);">返回</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <div class="main-body-section main-body-right-section section-wrapper">
        <div class="main-body-right-container fixed-to-top">

            @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')
            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-user', ['data'=>$item->owner])--}}
            {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-user', ['data'=>$user])--}}

        </div>
    </div>

</div>


<div class="modal fade" id="edit-modal">
    <div class="col-md-8 col-md-offset-2" id="edit-ctn" style="margin-top:64px;margin-bottom:64px;padding-top:32px;background:#fff;"></div>
</div>


@endsection


@section('js')
<script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>
<script>
    $(function() {

        // 【编辑】提交
        $("#edit-content-submit").on('click', function() {
            var options = {
                url: "/item/content-edit?item-type=menu_type",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.reload();
                    }
                }
            };
            $("#form-edit-content").ajaxSubmit(options);
        });




        // 【添加】新内容
        $(".show-create-content").on('click', function() {

            reset_form();

            $("#form-edit-content").find('input[name=rank]').val(0);
            $("#form-edit-content").find('.active-disable').hide();
            $("#form-edit-content").find('.active-none').show();
            $('#form-edit-content').find('.cover_img_container').html('');
            $('#form-edit-content').find('input[name=active][value="1"]').prop('checked',true);

            $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});

        });




        // 在该目录下添加内容
        $("#content-structure-list").on('click', '.create-follow-menu', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');

            reset_form();

            $('#menu').find('option[value='+id+']').prop('selected','selected');

            $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});
        });

        // 【编辑】该内容
        $("#content-structure-list").on('click', '.edit-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var item_id = input_group.attr('data-id');

            var result;
            $.post(
                "/item/content-get",
                {
                    _token: $('meta[name="_token"]').attr('content'),
                    item_id:item_id
                },
                function(data){
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        $("#form-edit-content").find('input[name=operate]').val("edit");
                        $("#form-edit-content").find('input[name=content_id]').val(data.data.id);
                        $("#form-edit-content").find('input[name=rank]').val(data.data.rank);

                        if(data.data.id == $("#form-edit-content").find('input[name=item_id]').val())
                        {
                            console.log('封面');
                            $("#form-edit-content").find('input[name=rank]').val(0);
                            $("#form-menu-option").hide();
                            $("#form-rank-option").hide();
                            $("#form-active-option").hide();
                        }
                        else
                        {
                            $("#form-menu-option").show();
                            $("#form-rank-option").show();
                            $("#form-active-option").show();
                        }

                        $("#form-edit-content").find('input[name=active]:checked').prop('checked','');
                        var $active = data.data.active;
                        $("#form-edit-content").find('.active-none').hide();
                        $("#form-edit-content").find('.active-disable').show();
                        if($active == 0) $("#form-edit-content").find('.active-none').show();
                        $("#form-edit-content").find('input[name=active][value='+$active+']').prop('checked','checked');

                        $("#form-edit-content").find('input[name=title]').val(data.data.title);
                        $("#form-edit-content").find('textarea[name=description]').val(data.data.description);

                        var content = data.data.content;
                        if(data.data.content == null) content = '';
                        var ue = UE.getEditor('container');
                        ue.setContent(content);

                        $("#form-edit-content").find('.cover_img_container').html(data.data.cover_img);

//                        var type = data.data.type;
//                        $("#form-edit-content").find('input[name=type]').prop('checked',null);
//                        $("#form-edit-content").find('input[name=type][value='+type+']').prop('checked',true);
//                        if(type == 1) $("#form-edit-content").find('.form-type').hide();
//                        else $("#form-edit-content").find('.form-type').show();

                        $('#menu').find('option').prop('selected',null);
                        $('#menu').find('option[value='+data.data.p_id+']').prop("selected", true);
                        var selected_text = $('#menu').find('option[value='+data.data.p_id+']').text();
                        $("html, body").animate({ scrollTop: $("#form-edit-content").offset().top }, {duration: 500,easing: "swing"});

                    }
                },
                'json'
            );

        });

        // 【删除】
        $("#content-structure-list").on('click', '.delete-this-content', function () {
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '确定要删除该"内容"么，该内容下子内容自动进入父节点';

            layer.msg(msg, {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-delete",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
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

        // 【启用】
        $("#content-structure-list").on('click', ".enable-this-content", function() {
            var that = $(this);
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '确定要删除该"内容"么，该内容下子内容自动进入父节点';
            layer.msg('启用该内容？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-enable",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
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
        // 【禁用】
        $("#content-structure-list").on('click', ".disable-this-content", function() {
            var that = $(this);
            var input_group = $(this).parents('.input-group');
            var id = input_group.attr('data-id');
            var msg = '确定要删除该"内容"么，该内容下子内容自动进入父节点';
            layer.msg('禁用该内容？', {
                time: 0
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    $.post(
                        "/item/content-disable",
                        {
                            _token: $('meta[name="_token"]').attr('content'),
                            id:id
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




        // 取消添加or编辑
        $("#edit-modal").on('click', '.cancel-this-content', function () {
            $('#edit-ctn').html('');
            $('#edit-modal').modal('hide');
        });

        // 取消添加or编辑
        $("#edit-modal").on('click', '.create-this-content', function () {
            var options = {
                url: "/item/edits",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.reload();
                    }
                }
            };
            $("#form-edit-content").ajaxSubmit(options);
        });

    });


    // 【重置】编辑
    function reset_form()
    {
//        $("#form-edit-content").find('.form-type').show();

        $("#form-menu-option").show();
        $("#form-rank-option").show();
        $("#form-active-option").show();

        $("#form-edit-content").find('input[name=operate]').val("create");
        $("#form-edit-content").find('input[name=id]').val("{{ encode(0) }}");
        $("#form-edit-content").find('input[name=rank]').val(0);
        $("#form-edit-content").find('input[name=title]').val("");
        $("#form-edit-content").find('textarea[name=description]').val("");
        var ue = UE.getEditor('container');
        ue.setContent("");

        $("#form-edit-content").find('input[name=type]').prop('checked',null);
        $("#form-edit-content").find('input[name=type][value="1"]').prop('checked',true);

        $('#menu').find('option').prop('selected',null);
        $('#menu').find('option[value=0]').prop("selected", true);

        $("#form-edit-content").find('.active-disable').hide();
        $("#form-edit-content").find('.active-none').show();
        $('#form-edit-content').find('input[name=active][value="1"]').prop('checked',true);

    }
</script>
@endsection
