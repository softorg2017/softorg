@extends('org.admin.layout.layout')

@section('title')
    @if($operate == 'create') 添加内容 @else 编辑内容 @endif
@endsection

@section('header')
    @if($operate == 'create') 添加内容 @else 编辑内容 @endif
@endsection

@section('description')
    @if($operate == 'create') 添加内容 @else 编辑内容 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url(config('common.org.admin.prefix').'/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="{{url(config('common.org.admin.prefix').'/item/list')}}"><i class="fa "></i> 内容列表</a></li>
    <li><a href="javascript:void(0);"><i class="fa "></i> Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title"></h3>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{ $operate or '' }}" readonly>
                <input type="hidden" name="encode_id" value="{{ $encode_id or encode(0) }}" readonly>

                {{--标题--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标题</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="title" placeholder="请输入标题" value="{{ $data->title or '' }}">
                    </div>
                </div>
                {{--副标题--}}
                <div class="form-group">
                    <label class="control-label col-md-2">副标题</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="subtitle" placeholder="请输入副标题" value="{{ $data->subtitle or '' }}">
                    </div>
                </div>
                {{--说明--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="description" placeholder="描述" value="{{ $data->description or '' }}">
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
                            <option data-id="{{$v->id}}" @if($data->menu_id == $v->id) selected="selected" @endif>{{ $v->title }}</option>
                            @endforeach
                            @else
                            @foreach($org->menus as $v)
                            <option data-id="{{$v->id}}">{{$v->title}}</option>
                            @endforeach
                            @endif
                        </select>
                        <input type="hidden" value="{{ $data->menu_id or 0}}" name="menu_id" id="menu-selected">
                    </div>
                </div>
                {{--目录--}}
                <div class="form-group">
                    <label class="control-label col-md-2">添加目录</label>
                    <div class="col-md-8 ">
                        <select name="menus[]" id="menus" style="width:100%;" multiple="multiple">
                            {{--<option value="{{ $data->people_id or 0}}">{{ $data->people->name or '请选择作者'}}</option>--}}
                        </select>
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
                {{--cover--}}
                <div class="form-group">
                    <label class="control-label col-md-2">封面图片</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->cover_pic))
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->cover_pic) }}" alt="" />
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

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
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

        // 添加or编辑
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "{{url(config('common.org.admin.prefix').'/item/edit')}}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{url(config('common.org.admin.prefix').'/item/list')}}";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });

        $('#menus').select2({
            ajax: {
                url: "{{url(config('common.org.admin.prefix').'/item/select2_menus')}}",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        keyword: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;
//                    console.log(data);
                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
            minimumInputLength: 0,
            theme: 'classic'
        });

    });
</script>
<script type="text/javascript">


</script>
@endsection
