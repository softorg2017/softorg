@extends('super.admin.layout.layout')

@section('title')
    @if($operate == 'create') 注册机构 @else 编辑资料 @endif
@endsection

@section('header')
    @if($operate == 'create') 注册机构 @else 编辑资料 @endif
@endsection

@section('description')
    @if($operate == 'create') 注册机构 @else 编辑资料 @endif
@endsection

@section('breadcrumb')
    <li><a href="{{ url(config('common.super.admin.prefix').'/') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="{{ url(config('common.super.admin.prefix').'/org/list') }}"><i class="fa fa-th-list"></i>机构列表</a></li>
    <li><a href="javascript:void(0);"><i class="fa "></i> Here</a></li>
@endsection


@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN PORTLET-->
            <div class="box box-info">

                <div class="box-header with-border" style="margin:16px 0;">
                    <h3 class="box-title">注册机构</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                            <i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-softorg">

                    {{csrf_field()}}
                    <input type="hidden" name="operate" value="{{ $operate or 'create' }}" readonly>
                    <input type="hidden" name="id" value="{{ $id or 0 }}" readonly>

                    <div class="box-body">

                        {{--管理员手机--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【如未号】</label>
                            <div class="col-md-8 ">
                                @if($operate == 'create')
                                    <input type="text" class="form-control" name="website_name" placeholder="请输入如未号" value="{{ $data->website_name or '' }}">
                                @else
                                    <span class="_bold">{{ $data->softorg_id or '' }}</span>
                                @endif
                            </div>
                        </div>
                        {{--管理员昵称--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【管理员昵称】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="admin_nickname" placeholder="请输入手机" value="{{ $data->admin->nickname or '' }}">
                            </div>
                        </div>
                        {{--管理员手机--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【管理员手机】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="admin_mobile" placeholder="请输入手机" value="{{ $data->admin->mobile or '' }}">
                            </div>
                        </div>

                    </div>



                    <div class="box-header with-border" style="margin:16px 0;">
                        <h3 class="box-title">机构信息</h3>
                    </div>



                    <div class="box-body">

                        {{--名称--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【全称】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="name" placeholder="请输入全称" value="{{ $data->name or '' }}">
                            </div>
                        </div>
                        {{--名称--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【简称】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="short_name" placeholder="请输入简称" value="{{ $data->short_name or '' }}">
                            </div>
                        </div>
                        {{--标语 slogan--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【标语】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="slogan" placeholder="请输入标语" value="{{ $data->slogan or '' }}">
                            </div>
                        </div>
                        {{--描述--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【简介】</label>
                            <div class="col-md-8 ">
                                {{--<input type="text" class="form-control" name="description" placeholder="请输入描述" value="{{$org->description or ''}}">--}}
                                <textarea name="description" id="" cols="100%" rows="5">{{ $data->description or '' }}</textarea>
                            </div>
                        </div>
                        {{--地址--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【地址】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="address" placeholder="请输入地址" value="{{ $data->address or '' }}">
                            </div>
                        </div>
                        {{--电话--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【固定电话】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="telephone" placeholder="请输入固定电话" value="{{ $data->telephone or '' }}">
                            </div>
                        </div>
                        {{--手机--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【手机】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="mobile" placeholder="请输入手机" value="{{ $data->mobile or '' }}">
                            </div>
                        </div>
                        {{--Email--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【邮箱】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="email" placeholder="请输入邮箱" value="{{ $data->email or '' }}">
                            </div>
                        </div>
                        {{--QQ--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【QQ】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="qq" placeholder="请输入QQ" value="{{ $data->qq or '' }}">
                            </div>
                        </div>
                        {{--微信--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【微信号】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="wechat_id" placeholder="请输入微信号" value="{{ $data->wechat_id or '' }}">
                            </div>
                        </div>
                        {{--微信二维码--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【微信二维码】</label>
                            <div class="col-md-8 fileinput-group">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if(!empty($data->wechat_qrcode))
                                            <img src="{{ url(env('DOMAIN_CDN').'/'. $data->wechat_qrcode) }}" alt="" />
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                    </div>
                                    <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="wechat_qrcode" />
                                </span>
                                        <span class="">
                                    <button class="btn btn-sm btn-danger fileinput-exists" data-dismiss="fileinput">移除</button>
                                </span>
                                    </div>
                                </div>
                                <div id="titleImageError" style="color: #a94442"></div>

                            </div>
                        </div>
                        {{--微博名称--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【微博名称】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="weibo_name" placeholder="请输入微博名称" value="{{ $data->weibo_name or '' }}">
                            </div>
                        </div>
                        {{--微博地址--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【微博地址】</label>
                            <div class="col-md-8 ">
                                <input type="text" class="form-control" name="weibo_address" placeholder="请输入微博地址" value="{{ $data->weibo_address or '' }}">
                            </div>
                        </div>

                        {{--logo--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">【logo】</label>
                            <div class="col-md-8 fileinput-group">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if(!empty($data->logo))
                                            <img src="{{ url(env('DOMAIN_CDN').'/'.$data->logo) }}" alt="" />
                                        @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail">
                                    </div>
                                    <div class="btn-tool-group">
                                <span class="btn-file">
                                    <button class="btn btn-sm btn-primary fileinput-new">选择图片</button>
                                    <button class="btn btn-sm btn-warning fileinput-exists">更改</button>
                                    <input type="file" name="logo" />
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
                            <button type="button" onclick="" class="btn btn-primary" id="edit-softorg-submit"><i class="fa fa-check"></i>提交</button>
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
            // 添加or修改产品信息
            $("#edit-softorg-submit").on('click', function() {
                var options = {
                    url: "{{url(config('common.super.admin.prefix').'/org/edit')}}",
                    type: "post",
                    dataType: "json",
                    // target: "#div2",
                    success: function (data) {
                        if(!data.success) layer.msg(data.msg);
                        else
                        {
                            layer.msg(data.msg);
{{--                            location.href = "{{url(config('common.super.admin.prefix').'/org/list')}}";--}}
                        }
                    }
                };
                $("#form-edit-softorg").ajaxSubmit(options);
            });
        });
    </script>
@endsection