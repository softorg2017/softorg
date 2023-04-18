@extends(env('TEMPLATE_DOC_FRONT').'layout.layout')


@section('head_title','【轻博】我的信息 - 如未轻博')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')如未轻博@endsection
@section('wx_share_desc')如未轻博@endsection
@section('wx_share_imgUrl'){{ url('/k-org.cn.png') }}@endsection




@section('sidebar')
    @include(env('TEMPLATE_DOC_FRONT').'component.sidebar.sidebar-root')
@endsection
@section('header','')
@section('description','')
@section('content')
<div style="display:none;">
    <input type="hidden" id="" value="{{ $encode or '' }}" readonly>
</div>

<div class="container">


    <div class="main-body-section main-body-left-section section-wrapper page-root">
        <div class="container-box pull-left margin-bottom-16px">


            <div class="box box-info form-container">

                <div class="box-header with-border" style="margin:8px 0;">
                    <h3 class="box-title">编辑个人信息</h3>
                    <div class="box-tools pull-right">
                    </div>
                </div>

                <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-info">
                    <div class="box-body">
                        {{csrf_field()}}

                        {{--名称--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">用户名</label>
                            <div class="col-md-9 ">
                                <input type="text" class="form-control" name="username" placeholder="请输入用户名" value="{{ $info->username or '' }}">
                            </div>
                        </div>
                        {{--真实姓名--}}
                        <div class="form-group _none">
                            <label class="control-label col-md-2">真实姓名</label>
                            <div class="col-md-9 ">
                                <input type="text" class="form-control" name="true_name" placeholder="真实姓名" value="{{ $info->true_name or '' }}">
                            </div>
                        </div>
                        {{--电话--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">电话</label>
                            <div class="col-md-9 ">
                                <input type="text" class="form-control" name="mobile" placeholder="电话" value="{{ $info->mobile or '' }}">
                            </div>
                        </div>
                        {{--真实姓名--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">邮箱</label>
                            <div class="col-md-9 ">
                                <input type="text" class="form-control" name="email" placeholder="邮箱" value="{{ $info->email or '' }}">
                            </div>
                        </div>
                        {{--描述--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">个人签名</label>
                            <div class="col-md-9 ">
                                <input type="text" class="form-control" name="description" placeholder="个人签名" value="{{ $info->description or '' }}">
                                {{--<textarea name="description" id="" cols="100%" rows="2" placeholder="个人签名">{{ $info->description or '' }}</textarea>--}}
                            </div>
                        </div>

                        {{--头像--}}
                        <div class="form-group">
                            <label class="control-label col-md-2">头像</label>
                            <div class="col-md-9 fileinput-group">

                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                        @if(!empty($info->portrait_img))
                                            <img src="{{ url(env('DOMAIN_CDN').'/'.$info->portrait_img) }}" alt="" />
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

                    </div>
                </form>

                <div class="box-footer">
                    <div class="row" style="margin:8px 0;">
                        <div class="col-md-8 col-md-offset-2">
                            <button type="button" onclick="" class="btn btn-primary" id="edit-info-submit"><i class="fa fa-check"></i>提交</button>
                            <button type="button" onclick="history.go(-1);" class="btn btn-default">返回</button>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>


    <div class="main-body-section main-body-section main-body-right-section section-wrapper hidden-xs">

        @include(env('TEMPLATE_DOC_FRONT').'component.right-side.right-root')

    </div>


</div>
@endsection




@section('style')
@endsection



@section('js')
<script>
    $(function() {

        $("#edit-info-submit").on('click', function() {
            var options = {
                url: "/mine/my-info-edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        location.href = "/mine/my-info-index";
                    }
                }
            };
            $("#form-edit-info").ajaxSubmit(options);
        });
    });
</script>
@endsection
