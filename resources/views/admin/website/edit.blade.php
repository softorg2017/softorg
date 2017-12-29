@extends('admin.layout.layout')

@section('title', '网站编辑')
@section('header', '网站编辑')
@section('description', '网站编辑')

@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
{{--主页--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">编辑 - 自定义主页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-home">
            <div class="box-body">

                {{csrf_field()}}
                <input type="hidden" name="type" value="home" readonly>
                {{--内容--}}
                <div class="form-group">
                    <label class="control-label col-md-2">自定义主页</label>
                    <div class="col-md-8 ">
                        <div>
                            @include('UEditor::head')
                            {{--加载编辑器的容器--}}
                            <script id="container1" name="content" type="text/plain">{!! $data->home or '' !!}</script>
                            <!-- 实例化编辑器 -->
                            <script type="text/javascript">
                                var ue1 = UE.getEditor('container1');
                                ue1.ready(function() {
                                    ue1.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                });
                            </script>
                        </div>
                    </div>
                </div>

            </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary edit-submit" data-form="#form-home"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default" onclick="history.go(-1);">返回</button>
                        <a target="_blank" href="/org/{{ $org->website_name }}/home"><button class="btn btn-success _right">访问自定义主页</button></a>

                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

{{--简介页--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">编辑 - 简介单页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-introduction">
                <div class="box-body">

                    {{csrf_field()}}
                    <input type="hidden" name="type" value="introduction" readonly>
                    {{--内容--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">简介单页</label>
                        <div class="col-md-8 ">
                            <div>
                            {{--@include('UEditor::head')--}}
                                {{--加载编辑器的容器--}}
                                <script id="container2" name="content" type="text/plain">{!! $data->introduction or '' !!}</script>
                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                    var ue2 = UE.getEditor('container2');
                                    ue2.ready(function() {
                                        ue2.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary edit-submit" data-form="#form-introduction"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default" onclick="history.go(-1);">返回</button>
                        <a target="_blank" href="/org/{{ $org->website_name }}/introduction"><button class="btn btn-success _right">访问简介单页</button></a>
                    </div>
                </div>
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

{{--联系我们--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">编辑 - 联系我们单页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <form action="" method="post" class="form-horizontal form-bordered" id="form-information">
                <div class="box-body">

                    {{csrf_field()}}
                    <input type="hidden" name="type" value="information" readonly>
                    {{--内容--}}
                    <div class="form-group">
                        <label class="control-label col-md-2">联系我们单页</label>
                        <div class="col-md-8 ">
                            <div>
                            {{--@include('UEditor::head')--}}
                                {{--加载编辑器的容器--}}
                                <script id="container3" name="content" type="text/plain">{!! $data->information or '' !!}</script>
                                <!-- 实例化编辑器 -->
                                <script type="text/javascript">
                                    var ue3 = UE.getEditor('container3');
                                    ue3.ready(function() {
                                        ue3.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

            <div class="box-footer">
                <div class="row" style="margin:16px 0;">
                    <div class="col-md-8 col-md-offset-2">
                        <button type="button" class="btn btn-primary edit-submit" data-form="#form-information"><i class="fa fa-check"></i> 提交</button>
                        <button type="button" class="btn btn-default" onclick="history.go(-1);">返回</button>
                        <a target="_blank" href="/org/{{ $org->website_name }}/information"><button class="btn btn-success _right">访问联系我们单页</button></a>
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
    {{--var ue1 = UE.getEditor('container1');--}}
    {{--ue1.ready(function() {--}}
        {{--ue1.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.--}}
    {{--});--}}
    {{--var ue2 = UE.getEditor('container2');--}}
    {{--ue2.ready(function() {--}}
        {{--ue2.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.--}}
    {{--});--}}
    {{--var ue3 = UE.getEditor('container3');--}}
    {{--ue3.ready(function() {--}}
        {{--ue3.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.--}}
    {{--});--}}

    $(function() {

        // 自定义编辑
        $(".edit-submit").on('click', function() {
            var form = $($(this).attr('data-form'));
            var options = {
                url: "/admin/website/edit",
                type: "post",
                dataType: "json",
                // target: "#div2",
                success: function (data) {
                    if(!data.success) layer.msg(data.msg);
                    else
                    {
                        layer.msg(data.msg);
                        //location.href = "/admin/website/list";
                    }
                }
            };
            form.ajaxSubmit(options);
        });
    });
</script>
<script type="text/javascript">


</script>
@endsection
