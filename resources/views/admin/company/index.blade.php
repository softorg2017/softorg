@extends('admin.layout.layout')

@section('title','轻企后台')
@section('header','轻企后台')
@section('description','企业基本信息')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin: 15px 0;">
                <h3 class="box-title">企业基本信息</h3>
                <div class="pull-right">
                    <a href="{{url('/admin/company/edit')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa "></i>编辑信息</button>
                    </a>
                </div>
            </div>

            <form class="form-horizontal form-bordered">
            <div class="box-body">
                {{--名称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业名称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->name or ''}}</label></div>
                    </div>
                </div>
                {{--简称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业简称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->short or ''}}</label></div>
                    </div>
                </div>
                {{--企业标语 Slogan--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业标语：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->slogan or ''}}</label></div>
                    </div>
                </div>
                {{--企业描述--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业描述：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->description or ''}}</label></div>
                    </div>
                </div>
                {{--企业电话--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业电话：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->telephone or ''}}</label></div>
                    </div>
                </div>
                {{--企业邮箱--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业邮箱：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->email or ''}}</label></div>
                    </div>
                </div>
                {{--企业QQ--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业QQ：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->qq or ''}}</label></div>
                    </div>
                </div>
                {{--企业微信--}}
                <div class="form-group">
                    <label class="control-label col-md-2">企业微信号：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$company->wechat or ''}}</label></div>
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
