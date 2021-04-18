@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')

@section('head_title','我的信息 - 朝鲜族组织平台')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')朝鲜族组织平台@endsection
@section('wx_share_desc')朝鲜族社群组织活动分享平台@endsection
@section('wx_share_imgUrl'){{ url('/k-org.cn.png') }}@endsection


@section('sidebar')

    @include(env('TEMPLATE_DEFAULT').'frontend.component.sidebar-root')

@endsection


@section('header','')
@section('description','')
@section('content')
<div style="display:none;">
    <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
</div>

<div class="container">

    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 container-body-left">

        <div class="row">
            <div class="col-md-12">
                <!-- BEGIN PORTLET-->
                <div class="box box-info">

                    <div class="box-header with-border">
                        <h3 class="box-title">基本信息</h3>
                        <div class="pull-right">
                            <a href="{{url('/my-info/edit')}}">
                                <button type="button" onclick="" class="btn btn-success pull-right"><i class="fa fa-edit"></i>编辑信息</button>
                            </a>
                        </div>
                    </div>

                    <form class="form-horizontal form-bordered">
                        <div class="box-body">
                            {{--名称--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">用户名：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->username or '' }}</label>
                                </div>
                            </div>
                            {{--真实姓名--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">真实姓名：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->true_name or '' }}</label>
                                </div>
                            </div>
                            {{--职业--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">职业：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->telephone or '' }}</label>
                                </div>
                            </div>
                            {{--电话--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">电话：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->mobile or '' }}</label>
                                </div>
                            </div>
                            {{--邮箱--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">邮箱：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->email or '' }}</label>
                                </div>
                            </div>
                            {{--描述--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">个人签名：</label>
                                <div class="col-md-8 ">
                                    <label class="">{{  $info->description or '' }}</label>
                                </div>
                            </div>
                            {{--portrait--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">头像：</label>
                                <div class="col-md-8 ">
                                    <div style="width:100px;height:100px;"><img src="{{ url(env('DOMAIN_CDN').'/'.$info->portrait_img) }}" alt=""></div>
                                </div>
                            </div>
                            {{--qrcode--}}
                            <div class="form-group" style="display:none;">
                                <label class="control-label col-md-2">二维码：</label>
                                <div class="col-md-8 ">
                                    <a class="btn btn-success _left" target="_blank" href="/admin/download/qrcode">下载首页二维码</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="box-footer">
                        <div class="row" style="margin:8px 0;">
                            <div class="col-md-8">
                                <a href="{{url('/my-info/edit')}}">
                                    <button type="button" onclick="" class="btn btn-success"><i class="fa fa-edit"></i>编辑信息</button>
                                </a>
                                <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END PORTLET-->


                <div class="box box-info _none">

                    <div class="box-header">
                        <h3 class="box-title">修改密码</h3>
                        <div class="pull-right">
                            <a href="{{url('/home/info/password/reset')}}">
                                <button type="button" onclick="" class="btn btn-primary pull-right"><i class="fa "></i>修改密码</button>
                            </a>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row" style="margin:8px 0;">
                            <div class="col-md-8 col-md-offset-2">
                                <a href="{{url('/home/info/password/reset')}}">
                                    <button type="button" onclick="" class="btn btn-primary"><i class="fa "></i>修改密码</button>
                                </a>
                                <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 hidden-xs hidden-sm container-body-right">

        @include(env('TEMPLATE_DEFAULT').'frontend.component.right-root')
        @include(env('TEMPLATE_DEFAULT').'frontend.component.right-me')

    </div>

</div>
@endsection


@section('style')
<style>
    .box-footer a {color:#777;cursor:pointer;}
    .box-footer a:hover {color:orange;cursor:pointer;}
    .comment-container {border-top:2px solid #ddd;}
    .comment-choice-container {border-top:2px solid #ddd;}
    .comment-choice-container .form-group { margin-bottom:0;}
    .comment-entity-container {border-top:2px solid #ddd;}
    .comment-piece {border-bottom:1px solid #eee;}
    .comment-piece:first-child {}
</style>
@endsection

@section('js')
<script>
    $(function() {
        $('article').readmore({
            speed: 150,
            moreLink: '<a href="#">展开更多</a>',
            lessLink: '<a href="#">收起</a>'
        });
    });
</script>
@endsection
