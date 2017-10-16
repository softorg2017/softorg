@extends('front.'.config('common.view.front.template').'.layout.layout')

@section('title')
    {{$org->name or ''}}
@endsection
@section('header')
    {{$org->name or ''}}
@endsection
@section('description')
    {{$org->name or ''}}
@endsection
@section('breadcrumb')
    <li><a href="#"><i class="fa fa-home"></i>Home</a></li>
    <li><a href="{{url('/admin/product/list')}}"><i class="fa "></i>列表</a></li>
    <li><a href="#"><i class="fa "></i> Level</a></li>
@endsection


@section('content')
<div class="row">
    <div class="col-md-12">

        {{----}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">首页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="col-md-12">企业名称：{{$org->name or ''}}</div>
                <div class="col-md-12">企业描述：{{$org->description or ''}}</div>
                <div class="col-md-12">企业标语：{{$org->slogan or ''}}</div>
                <div class="col-md-12">企业电话：{{$org->telephone or ''}}</div>
                <div class="col-md-12">企业邮箱：{{$org->email or ''}}</div>
            </div>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->

        {{--产品--}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">产品页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    @foreach($org->products as $v)
                        <div class="col-md-3">
                            <div class="box box-warning">
                                <div class="box-header with-border">
                                    <a target="_blank" href="/product?id={{encode($v->id)}}">{{$v->title or ''}}</a>
                                </div>
                                <div class="box-body">
                                    {!! $v->content or '' !!}
                                </div>
                                <div class="box-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->

        {{--活动--}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">活动页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    @foreach($org->activities as $v)
                        <div class="col-md-3">
                            <div class="box box-success">
                                <div class="box-header with-border">
                                    <a target="_blank" href="/activity?id={{encode($v->id)}}">{{$v->title or ''}}</a>
                                </div>
                                <div class="box-body">
                                    {!! $v->content or '' !!}
                                </div>
                                <div class="box-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->

        {{--幻灯片--}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">幻灯片页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    @foreach($org->slides as $v)
                        <div class="col-md-3">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <a target="_blank" href="/slide?id={{encode($v->id)}}">{{$v->title or ''}}</a>
                                </div>
                                <div class="box-body">
                                    {!! $v->content or '' !!}
                                </div>
                                <div class="box-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->

        {{--问卷--}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">问卷页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    @foreach($org->surveys as $v)
                        <div class="col-md-3">
                            <div class="box box-info">
                                <div class="box-header with-border">
                                    <a target="_blank" href="/survey?id={{encode($v->id)}}">{{$v->title or ''}}</a>
                                </div>
                                <div class="box-body">
                                    {!! $v->content or '' !!}
                                </div>
                                <div class="box-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->

        {{--文章--}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">文章页</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    @foreach($org->articles as $v)
                        <div class="col-md-3">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <a target="_blank" href="/article?id={{encode($v->id)}}">{{$v->title or ''}}</a>
                                </div>
                                <div class="box-body">
                                    {!! $v->content or '' !!}
                                </div>
                                <div class="box-footer">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="box-footer">
            </div>
        </div>
        <!-- END PORTLET-->

        {{--联系我们--}}
        <!-- BEGIN PORTLET-->
        <div class="box box-info">

            <div class="box-header with-border" style="margin:16px 0;">
                <h3 class="box-title">联系我们</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="" data-original-title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="" data-original-title="Remove">
                        <i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body">
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
