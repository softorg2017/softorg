@extends(env('TEMPLATE_GPS_ADMIN').'layout.layout')

@section('head_title','【GPS】工具')

@section('header','工具')
@section('description','工具')
@section('breadcrumb')
    <li><a href="/"><i class="fa fa-dashboard"></i>导航</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border">
                <h3 class="box-title">Developing.Tools</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div action="" class="form-horizontal form-bordered">
                <div class="box-header with-border" style="display:none;">
                </div>
                <div class="box-body">
                    {{--密码--}}
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-1">
                            <h4 class="box-title">密码加密 password_hash(md5($str),PASSWORD_BCRYPT);</h4>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-1">
                            <div><input type="text" class="form-control" placeholder="请输入待加密的密码" id="password"></div>
                        </div>
                        <div class="col-md-9 col-md-offset-1">
                            <div><input type="text" class="form-control" placeholder="结果" id="password-encode-result"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-9 col-md-offset-1">
                            <button type="button" class="btn btn-sm btn-primary" id="tool-password-encode-submit"><i class="fa fa-check"></i> 提交</button>
                            <button type="button" class="btn btn-sm btn-default" onclick="history.go(-1);">返回</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer" style="display:none;">
            </div>
        </div>
        <!-- END PORTLET-->
    </div>
</div>

{{--null & bg-maroon--}}
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border">
                <h3 class="box-title">Life.Tools</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <a href="" target="_blank"><button type="button" class="btn btn-sm bg-maroon margin"></button></a>
                <a href="" target="_blank"><button type="button" class="btn btn-sm bg-orange margin"></button></a>
                <a href="" target="_blank"><button type="button" class="btn btn-sm bg-maroon margin"></button></a>
                <a href="" target="_blank"><button type="button" class="btn btn-sm bg-maroon margin"></button></a>
            </div>

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

        // 生成密码
        $("#tool-password-encode-submit").on('click', function() {
            var url = '/admin/tool';
            $.post(
                url,
                {
                    _token:$('meta[name="_token"]').attr('content'),
                    type:"password_encode",
                    password:$("#password").val()
                },
                function(data){
                    if(data.success){
                        layer.msg(data.msg);
                        $("#password-encode-result").val(data.data.password_encode);
                    } else {
                        layer.msg(2);
                    }
            }, 'json');
        });

    });
</script>
@endsection