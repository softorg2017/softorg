@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')

@section('head_title','我的信息 - 朝鲜族组织平台')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')@endsection
@section('wx_share_desc')@endsection
@section('wx_share_imgUrl')@endsection


@section('sidebar')

    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar.sidebar-root')

@endsection


@section('header','')
@section('description','')
@section('content')
<div class="container">

    <div class="main-body-section main-body-left-section section-wrapper page-root">
        <div class="container-box pull-left margin-bottom-16px">

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
                            {{--QQ--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">QQ：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->QQ_number or '' }}</label>
                                </div>
                            </div>
                            {{--微信号--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">微信号：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->wx_id or '' }}</label>
                                </div>
                            </div>
                            {{--微信二维码--}}
                            <div class="form-group" style="display:none;">
                                <label class="control-label col-md-2">微信二维码：</label>
                                <div class="col-md-8 ">
                                    <div style="width:100px;height:100px;"><img src="{{ url(env('DOMAIN_CDN').'/'.$info->wx_qr_code_img) }}" alt=""></div>
                                </div>
                            </div>
                            {{--微博名称--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">微博名称：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->wb_name or '' }}</label>
                                </div>
                            </div>
                            {{--微博地址--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">微博地址：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->wb_address or '' }}</label>
                                </div>
                            </div>
                            {{--网站--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">网站：</label>
                                <div class="col-md-8 ">
                                    <label class="control-label">{{  $info->website or '' }}</label>
                                </div>
                            </div>
                            {{--描述--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">描述：</label>
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

    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        {{--@include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-root')--}}
        @include(env('TEMPLATE_ROOT_FRONT').'component.right-side.right-me')

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
