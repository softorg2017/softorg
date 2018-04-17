@extends('admin.layout.layout')

@section('title','softorg')
@section('header','机构(企业)基本信息')
@section('description','机构(企业)基本信息')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin: 15px 0;">
                <h3 class="box-title">机构(企业)基本信息</h3>
                <div class="pull-right">
                    <a href="{{url(config('common.org.admin.prefix').'/admin/softorg/edit')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa "></i>编辑信息</button>
                    </a>
                </div>
            </div>

            <form class="form-horizontal form-bordered">
            <div class="box-body">
                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">全称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->name or ''}}</label></div>
                    </div>
                </div>
                {{--简称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">简称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->short or ''}}</label></div>
                    </div>
                </div>
                {{--标语 Slogan--}}
                <div class="form-group">
                    <label class="control-label col-md-2">标语：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->slogan or ''}}</label></div>
                    </div>
                </div>
                {{--描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">描述：</label>
                    <div class="col-md-8 ">
                        <div><label class="">{{$org->description or ''}}</label></div>
                    </div>
                </div>
                {{--地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">地址：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->address or ''}}</label></div>
                    </div>
                </div>
                {{--电话--}}
                <div class="form-group">
                    <label class="control-label col-md-2">电话：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->telephone or ''}}</label></div>
                    </div>
                </div>
                {{--邮箱--}}
                <div class="form-group">
                    <label class="control-label col-md-2">邮箱：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->email or ''}}</label></div>
                    </div>
                </div>
                {{--QQ--}}
                <div class="form-group">
                    <label class="control-label col-md-2">QQ：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->qq or ''}}</label></div>
                    </div>
                </div>
                {{--微信号--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微信号：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->wechat_id or ''}}</label></div>
                    </div>
                </div>
                {{--微信二维码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微信二维码：</label>
                    <div class="col-md-8 ">
                        <div style="width:100px;height:100px;"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$org->wechat_qrcode)}}" alt=""></div>
                    </div>
                </div>
                {{--微博--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微博名称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->weibo_name or ''}}</label></div>
                    </div>
                </div>
                {{--微博地址--}}
                <div class="form-group">
                    <label class="control-label col-md-2">微博地址：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$org->weibo_address or ''}}</label></div>
                    </div>
                </div>
                {{--logo--}}
                <div class="form-group">
                    <label class="control-label col-md-2">logo：</label>
                    <div class="col-md-8 ">
                        <div style="width:100px;height:100px;"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$org->logo)}}" alt=""></div>
                    </div>
                </div>
                {{--qrcode--}}
                <div class="form-group">
                    <label class="control-label col-md-2">二维码：</label>
                    <div class="col-md-8 ">
                        <a class="btn btn-success _left" target="_blank" href="/admin/download_root_qrcode">下载首页二维码</a>
                    </div>
                </div>
            </div>
            </form>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection


@section('js')
<script>
    $(function() {
        // initialize with defaults
//            $("#input-id").fileinput();

        // with plugin options
        $("#input-id").fileinput({'showUpload':false, 'previewFileType':'any'});
    });
</script>
@endsection
