@extends(env('TEMPLATE_GPS_ADMIN').'layout.layout')

@section('head_title','GPS - 测试')
@section('header','测试')
@section('description','测试')
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-home"></i>首页</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title"><b>Testing</b></h3>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/testing') }}">Root</a>
            </div>

            <div class="box-body">
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/testing/url') }}">URL</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/testing/++') }}">++</a>
                <a target="_blank" class="margin btn btn-sm btn-primary" href="{{ url('/testing/headers') }}">headers</a>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection