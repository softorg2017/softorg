@extends('front.'.config('common.view.front.template').'.layout.detail')

@section('title','活动详情')
@section('header','活动详情')
@section('description','活动详情')
@section('breadcrumb')
    <li><a href="{{url(config('common.website.front.prefix').'/'.$data->company->website_name)}}">
            <i class="fa fa-home"></i>{{$data->company->name}}企业首页</a></li>
    <li><a href="{{url(config('common.website.front.prefix').'/'.$data->company->website_name).'/activity'}}"><i class="fa "></i>活动列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">{{$data->title or ''}}</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                {!! $data->content or '' !!}
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
