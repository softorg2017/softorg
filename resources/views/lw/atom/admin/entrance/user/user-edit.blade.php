@extends(env('TEMPLATE_ADMIN').'admin.layout.layout')

@section('create-text') 添加机构 @endsection
@section('edit-text') 编辑机构 @endsection
@section('list-text') 全部机构 @endsection

@section('head_title')
    @if($operate == 'create') @yield('create-text') @else @yield('edit-text') @endif - 管理员后台 - 如未科技
@endsection


@section('header','')
@section('description', '管理员后台-如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/admin') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{ url('/admin/user/user-all-list') }}"><i class="fa fa-list"></i>@yield('list-text')</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">@if($operate == 'create') @yield('create-text') @else @yield('edit-text') @endif</h3>
                <div class="box-tools pull-right">
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-item">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="operate" value="{{ $operate or '' }}" readonly>
                <input type="hidden" name="operate_id" value="{{ $operate_id or 0 }}" readonly>


                {{--类别--}}
                <div class="form-group form-category">
                    <label class="control-label col-md-2">类型</label>
                    <div class="col-md-8">
                        <div class="btn-group">

                            @if($operate == 'create' || ($operate == 'edit' && $data->user_type == 11))
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="user_type" value="11" checked="checked"> 组织
                                        {{--<input type="radio" name="user_type" value=11--}}
                                               {{--@if($operate == 'edit' && $data->user_type == 11) checked="checked" @endif--}}
                                        {{--> 组织--}}
                                    </label>
                                </div>
                            </button>
                            @endif

                            @if(($operate == 'create' || $operate == 'edit' && $data->user_type == 88))
                            <button type="button" class="btn">
                                <div class="radio">
                                    <label>
                                        <input type="radio" name="user_type" value="88"
                                           @if($operate == 'edit' && $data->user_type == 88) checked="checked" @endif
                                        > 赞助商
                                    </label>
                                </div>
                            </button>
                            @endif

                        </div>
                    </div>
                </div>


                {{--用户名--}}
                <div class="form-group">
                    <label class="control-label col-md-2"><sup class="text-red">*</sup> 用户名</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="username" placeholder="用户名" value="{{ $data->username or '' }}">
                    </div>
                </div>
                {{--手机--}}
                <div class="form-group">
                    <label class="control-label col-md-2"><sup class="text-red">*</sup> 登录手机</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="mobile" placeholder="手机" value="{{ $data->mobile or '' }}">
                    </div>
                </div>
                {{--描述--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">描述</label>
                    <div class="col-md-8 ">
                        {{--<input type="text" class="form-control" name="description" placeholder="描述" value="{{$data->description or ''}}">--}}
                        <textarea class="form-control" name="description" rows="3" cols="100%">{{ $data->description or '' }}</textarea>
                    </div>
                </div>
                {{--标签--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标签</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="tag" placeholder="标签" value="{{ $data->tag or '' }}">
                    </div>
                </div>

                {{--邮箱--}}
                <div class="form-group">
                    <label class="control-label col-md-2">邮箱</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="email" placeholder="邮箱" value="{{ $data->email or '' }}">
                    </div>
                </div>
                {{--QQ--}}
                <div class="form-group">
                    <label class="control-label col-md-2">QQ</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="QQ_number" placeholder="QQ" value="{{ $data->QQ_number or '' }}">
                    </div>
                </div>
                {{--微信号--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微信号</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="wechat_id" placeholder="微信号" value="{{ $data->wechat_id or '' }}">
                    </div>
                </div>
                {{--微信二维码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微信二维码</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->wechat_qr_code_img))
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->wechat_qr_code_img) }}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                            </div>
                            <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="wechat_qr_code" />
                                </span>
                                <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                            </div>
                        </div>
                        <div id="titleImageError1" style="color: #a94442"></div>

                    </div>
                </div>
                {{--微博名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微博名称</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="weibo_name" placeholder="微博名称" value="{{ $data->weibo_name or '' }}">
                    </div>
                </div>
                {{--微博地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微博地址</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="weibo_address" placeholder="微博地址，请携带http或https" value="{{ $data->weibo_address or '' }}">
                    </div>
                </div>
                {{--网站--}}
                <div class="form-group">
                    <label class="control-label col-md-2">网站</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="website" placeholder="网站地址，请携带http或https" value="{{ $data->website or '' }}">
                    </div>
                </div>

                {{--联系地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">地址</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="contact_address" placeholder="地址" value="{{ $data->contact_address or '' }}">
                    </div>
                </div>

                {{--联系人--}}
                <div class="form-group">
                    <label class="control-label col-md-2">【联系人】</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="linkman" placeholder="联系人" value="{{ $data->linkman or '' }}">
                    </div>
                </div>
                {{--联系人电话--}}
                <div class="form-group">
                    <label class="control-label col-md-2">【联系人】电话</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="linkman_phone" placeholder="联系人电话" value="{{ $data->linkman_phone or '' }}">
                    </div>
                </div>
                {{--联系人微信ID--}}
                <div class="form-group">
                    <label class="control-label col-md-2">【联系人】微信号</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="linkman_wechat_id" placeholder="联系人微信号" value="{{ $data->linkman_wechat_id or '' }}">
                    </div>
                </div>
                {{--联系人微信二维码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">【联系人】微信二维码</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->linkman_wechat_qr_code_img))
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->linkman_wechat_qr_code_img) }}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                            </div>
                            <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="linkman_wechat_qr_code" />
                                </span>
                                <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                            </div>
                        </div>
                        <div id="titleImageError2" style="color: #a94442"></div>

                    </div>
                </div>

                {{--链接地址--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">链接地址</label>
                    <div class="col-md-8 ">
                        <input type="text" class="form-control" name="link_url" placeholder="链接地址" value="{{ $data->link_url or '' }}">
                    </div>
                </div>

                {{--目录--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">目录</label>
                    <div class="col-md-8 ">
                        <select class="form-control" onchange="select_menu()">
                            <option data-id="0">未分类</option>
                            {{--@if(!empty($data->menu_id))--}}
                                {{--@foreach($menus as $v)--}}
                                    {{--<option data-id="{{$v->id}}" @if($data->menu_id == $v->id) selected="selected" @endif>{{$v->title}}</option>--}}
                                {{--@endforeach--}}
                            {{--@else--}}
                                {{--@foreach($menus as $v)--}}
                                    {{--<option data-id="{{$v->id}}">{{$v->title}}</option>--}}
                                {{--@endforeach--}}
                            {{--@endif--}}
                        </select>
                        <input type="hidden" value="{{ $data->menu_id or 0 }}" name="menu_id" id="menu-selected">
                    </div>
                </div>
                {{--目录--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">添加目录</label>
                    <div class="col-md-8 ">
                        <select name="menus[]" id="menus" multiple="multiple" style="width:100%;">
                            {{--<option value="{{$data->people_id or 0}}">{{$data->people->name or '请选择作者'}}</option>--}}
                        </select>
                    </div>
                </div>

                {{--内容--}}
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

                {{--多图展示--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">多图展示</label>
                    <div class="col-md-8 fileinput-group">
                        @if(!empty($data->custom2))
                            @foreach($data->custom2 as $img)
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        <img src="{{ url(env('DOMAIN_CDN').'/'.$img->img) }}" alt="" />
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        @endif
                    </div>

                    <div class="col-md-8 col-md-offset-2 ">
                        <input id="multiple-images" type="file" class="file-" name="multiple_images[]" multiple >
                    </div>
                </div>

                {{--头像--}}
                <div class="form-group">
                    <label class="control-label col-md-2">头像</label>
                    <div class="col-md-8 fileinput-group">

                        <div class="fileinput fileinput-new" data-provides="fileinput">
                            <div class="fileinput-new thumbnail">
                                @if(!empty($data->portrait_img))
                                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="" />
                                @endif
                            </div>
                            <div class="fileinput-preview fileinput-exists thumbnail">
                            </div>
                            <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="portrait" />
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
                    <div class="form-group form-type _none">
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
                        <button type="button" class="btn btn-success" id="edit-item-submit"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection


@section('custom-css')
    {{--<link rel="stylesheet" href="https://cdn.bootcss.com/select2/4.0.5/css/select2.min.css">--}}
    <link rel="stylesheet" href="{{ asset('/lib/css/select2-4.0.5.min.css') }}">
@endsection


@section('custom-script')
{{--<script src="https://cdn.bootcss.com/select2/4.0.5/js/select2.min.js"></script>--}}
<script src="{{ asset('/lib/js/select2-4.0.5.min.js') }}"></script>
<script>
    $(function() {

        $("#multiple-images").fileinput({
            allowedFileExtensions : [ 'jpg', 'jpeg', 'png', 'gif' ],
            showUpload: false
        });

        // 添加or编辑
        $("#edit-item-submit").on('click', function() {
            var options = {
                url: "{{ url('/admin/user/user-edit') }}",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "{{ url('/admin/user/user-all-list') }}";
                    }
                }
            };
            $("#form-edit-item").ajaxSubmit(options);
        });

        $('#menus').select2({
            ajax: {
                url: "{{url('/admin/item/select2_menus')}}",
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
@endsection
