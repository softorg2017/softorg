@extends(env('TEMPLATE_ROOT_FRONT').'layout.layout')

@section('head_title','编辑图文详情 - 如未科技')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('wx_share_title')朝鲜族组织平台@endsection
@section('wx_share_desc')朝鲜族社群组织活动分享平台@endsection
@section('wx_share_imgUrl'){{ url('/k-org.cn.png') }}@endsection


@section('sidebar')

    @include(env('TEMPLATE_ROOT_FRONT').'component.sidebar-root')

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
                <div class="box box-info form-container">

                    <div class="box-header with-border" style="margin:8px 0;">
                        <h3 class="box-title">编辑图文详情</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>

                    <form action="" method="post" class="form-horizontal form-bordered" id="form-edit-info">
                        <div class="box-body">
                            {{csrf_field()}}

                            {{--标题--}}
                            <div class="form-group">
                                <label class="control-label col-md-2"><sup class="text-red">*</sup> 标题</label>
                                <div class="col-md-9 ">
                                    <input type="text" class="form-control" name="title" placeholder="标题" value="{{ $data->title or '' }}">
                                </div>
                            </div>
                            {{--描述--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">描述</label>
                                <div class="col-md-9 ">
                                    <textarea class="form-control" name="description" rows="3" placeholder="描述">{{ $data->description or '' }}</textarea>
                                </div>
                            </div>
                            {{--内容--}}
                            <div class="form-group">
                                <label class="control-label col-md-2">内容详情</label>
                                <div class="col-md-9 ">
                                    <div>
                                    @include('UEditor::head')
                                    <!-- 加载编辑器的容器 -->
                                        <script id="container" name="content" type="text/plain">{!! $data->content or '' !!}</script>
                                        <!-- 实例化编辑器 -->
                                        <script type="text/javascript">
                                            var ue = UE.getEditor('container');
                                            ue.ready(function() {
                                                ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');  // 此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                            });
                                        </script>
                                    </div>
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
                <!-- END PORTLET-->
            </div>
        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 hidden-xs hidden-sm container-body-right">

        @include(env('TEMPLATE_ROOT_FRONT').'component.right-root')
        @include(env('TEMPLATE_ROOT_FRONT').'component.right-me')

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

        $("#edit-info-submit").on('click', function() {
            var options = {
                url: "/my-introduction/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
//                        location.href = "/my-info/index";
                        location.href = "/";
                    }
                }
            };
            $("#form-edit-info").ajaxSubmit(options);
        });
    });
</script>
@endsection
