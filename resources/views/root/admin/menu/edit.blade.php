@extends('root.admin.layout.layout')

@section('head_title')
    @if($operate == 'create') 添加目录 @else 编辑目录 @endif
@endsection

@section('header')
    @if($operate == 'create') 添加目录 @else 编辑目录 @endif
@endsection

@section('description')
    @if($operate == 'create') 添加目录 @else 编辑目录 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i> 首页</a></li>
    <li><a href="{{url('/admin/menu/list')}}"><i class="fa "></i> 目录列表</a></li>
    <li><a href="#"><i class="fa "></i> Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">@if($operate == 'create') 添加目录 @else 编辑目录 @endif</h3>
                <div class="box-tools pull-right _none">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-menu">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{$operate or ''}}" readonly>
                <input type="hidden" name="encode_id" value="{{$encode_id or encode(0)}}" readonly>

                {{--类别--}}
                <div class="form-group form-category">
                    <label class="control-label col-md-2">类别</label>
                    <div class="col-md-8">
                        <div class="btn-group">

                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="category" value="0"
                                               @if($operate == 'create' || ($operate == 'edit' && $data->category == 0)) checked="checked" @endif> 未分类
                                    </label>
                                </div>
                            </button>

                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="category" value="11"
                                               @if($operate == 'edit' && $data->category == 11) checked="checked" @endif> 业务模块
                                    </label>
                                </div>
                            </button>

                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="category" value="12"
                                               @if($operate == 'edit' && $data->category == 12) checked="checked" @endif> 产品模块
                                    </label>
                                </div>
                            </button>

                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="category" value="21"
                                               @if($operate == 'edit' && $data->category == 21) checked="checked" @endif> 案例模块
                                    </label>
                                </div>
                            </button>

                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="category" value="41"
                                               @if($operate == 'edit' && $data->category == 41) checked="checked" @endif> 资讯模块
                                    </label>
                                </div>
                            </button>

                        </div>
                    </div>
                </div>

                {{--name--}}
                <div class="form-group">
                    <label class="control-label col-md-2">name</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="name" placeholder="唯一标识，请与开发者联系" value="{{ $data->name or '' }}">
                    </div>
                </div>

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
                {{--描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        {{--<input type="text" class="form-control" name="description" placeholder="描述" value="{{ $data->description or '' }}">--}}
                        <textarea class="form-control" name="description" rows="3" cols="100%">{{ $data->description or ''}}</textarea>
                    </div>
                </div>
                {{--内容详情--}}
                <div class="form-group _none">
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

                {{--链接地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">链接地址</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="link_url" placeholder="链接地址" value="{{ $data->link_url or '' }}">
                    </div>
                </div>

                {{--cover 封面图片--}}
                <div class="form-group">
                    <label class="control-label col-md-2">封面图片</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->cover_pic))
                                    <img src="{{url(env('DOMAIN_CDN').'/'.$data->cover_pic)}}" alt="" />
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

                {{--启用--}}
                @if($operate == 'create')
                    <div class="form-group form-type">
                        <label class="control-label col-md-2">启用</label>
                        <div class="col-md-8">
                            <div class="btn-group">

                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="active" value="0" checked="checked"> 暂不启用
                                        </label>
                                    </div>
                                </button>
                                <button type="button" class="btn">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="active" value="1"> 启用
                                        </label>
                                    </div>
                                </button>

                            </div>
                        </div>
                    </div>
                @endif

            </div>
            </form>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-success" id="edit-menu-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection


@section('custom-script')
<script>
    $(function() {
        // 添加or编辑
        $("#edit-menu-submit").on('click', function() {
            var options = {
                url: "{{url('/admin/menu/edit')}}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{url('/admin/menu/list')}}";
                    }
                }
            };
            $("#form-edit-menu").ajaxSubmit(options);
        });
    });
</script>
@endsection
