@extends('admin.layout.layout')

@section('title','管理员信息')
@section('header','管理员信息')
@section('description','管理员信息')
@section('breadcrumb')
    <li><a href="{{url(config('common.org.admin.prefix').'/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info form-container">

            <div class="box-header with-border" style="margin: 15px 0;">
                <h3 class="box-title">管理员信息</h3>
                <div class="pull-right">
                    <a href="{{url('/admin/administrator/edit')}}">
                        <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa "></i>编辑信息</button>
                    </a>
                </div>
            </div>

            <form class="form-horizontal form-bordered">
            <div class="box-body">
                {{--邮箱--}}
                <div class="form-group">
                    <label class="control-label col-md-2">邮箱：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$me->email or ''}}</label></div>
                    </div>
                </div>
                {{--昵称--}}
                <div class="form-group">
                    <label class="control-label col-md-2">昵称：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$me->nickname or ''}}</label></div>
                    </div>
                </div>
                {{--真实姓名--}}
                <div class="form-group">
                    <label class="control-label col-md-2">真实姓名：</label>
                    <div class="col-md-8 ">
                        <div><label class="control-label">{{$me->true_name or ''}}</label></div>
                    </div>
                </div>
                {{--portrait--}}
                <div class="form-group">
                    <label class="control-label col-md-2">头像：</label>
                    <div class="col-md-8 ">
                        <div class="info-img-block"><img src="{{url(config('common.host.'.env('APP_ENV').'.cdn').'/'.$me->portrait_img)}}" alt=""></div>
                    </div>
                </div>
                {{--修改密码--}}
                <div class="form-group">
                    <label class="control-label col-md-2">修改密码：</label>
                    <div class="col-md-8 ">
                        <a class="btn btn-danger _left" href="{{url('/admin/administrator/password/reset')}}">修改密码</a>
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
