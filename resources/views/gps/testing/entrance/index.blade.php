@include(env('TEMPLATE_GPS_TEST').'layout.layout')

@section('head_title','内容列表 - 原子系统 - 如未科技')


@section('header','')
@section('description','内容列表 - 原子系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-home"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border">
                <h3 class="box-title">item.index</h3>
            </div>

            <div class="box-body">
                {{ $output or '' }}11
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
    });
</script>
@endsection
