@extends('front.'.config('common.view.front.template').'.layout.layout')

@section('title','文章列表')
@section('header','文章列表')
@section('description','文章列表')
@section('breadcrumb')
    <li><a href="{{url(config('common.website.front.prefix').'/'.$company->website_name)}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="{{url(config('common.website.front.prefix').'/'.$company->website_name)}}"><i class="fa "></i>列表</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        @foreach($company->articles as $v)
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title"><a href="{{url('/article?id='.encode($v->id))}}">{{$v->title}}</a></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                {!! $v->content or '' !!}
            </div>

            <div class="box-footer">
            </div>
        </div>
        @endforeach
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
