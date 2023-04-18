@extends(env('TEMPLATE_ADMIN').'admin.layout.layout')


@section('head_title','基本资料 - 管理员系统 - 如未科技')
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header','')
@section('description','朝鲜族组织活动平台 - 管理员后台系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/admin') }}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin: 15px 0;">
                <h3 class="box-title">基本资料</h3>
                <div class="pull-right">
                    <a href="{{url('/admin/info/edit')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa "></i>编辑信息</button>
                    </a>
                </div>
            </div>

            <form class="form-horizontal form-bordered">
            <div class="box-body">
                {{--昵称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">用户名：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->username or '' }}</label></div>
                    </div>
                </div>
                {{--真实名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">真实名称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->true_name or '' }}</label></div>
                    </div>
                </div>
                {{--手机号--}}
                <div class="form-group">
                    <label class="control-label col-md-2">手机号：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->mobile or '' }}</label></div>
                    </div>
                </div>
                {{--固定电话--}}
                <div class="form-group">
                    <label class="control-label col-md-2">固定电话：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->telephone or '' }}</label></div>
                    </div>
                </div>
                {{--邮箱--}}
                <div class="form-group">
                    <label class="control-label col-md-2">邮箱：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->email or '' }}</label></div>
                    </div>
                </div>
                {{--QQ--}}
                <div class="form-group">
                    <label class="control-label col-md-2">QQ：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->QQ_number or '' }}</label></div>
                    </div>
                </div>
                {{--微信号--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微信号：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->wechat_id or '' }}</label></div>
                    </div>
                </div>
                {{--微博地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微博地址：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{ $data->weibo_address or '' }}</label></div>
                    </div>
                </div>
                {{--portrait--}}
                <div class="form-group _none">
                    <label class="control-label col-md-2">头像：</label>
                    <div class="col-md-8 ">
                        <div class="info-img-block"><img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt=""></div>
                    </div>
                </div>
                {{--修改密码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">修改密码：</label>
                    <div class="col-md-8 ">
                        <a class="btn btn-danger _left" href="{{ url('/admin/info/password-reset') }}">修改密码</a>
                    </div>
                </div>
            </div>
            </form>

            <div class="box-footer">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        {{--<a href="{{url('/admin/administrator/edit')}}">--}}
                            {{--<button type="button" onclick="" class="btn btn-success"><i class="fa "></i>编辑信息</button>--}}
                        {{--</a>--}}
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
    <style>
        .info-img-block {width: 100px;height: 100px;overflow: hidden;}
        .info-img-block img {width: 100%;}
    </style>
@endsection

@section('js')
<script>
    $(function() {
        // with plugin options
        $("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});
    });
</script>
@endsection
