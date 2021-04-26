@extends(env('TEMPLATE_GPS_ADMIN').'layout.layout')

@section('head_title','测试 - GPS')

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
                <a class="margin btn btn-sm btn-primary" href="{{ url('/testing/url') }}">URL</a>
                <a class="margin btn btn-sm btn-primary" href="{{ url('/testing/++') }}">++</a>
                <a class="margin btn btn-sm btn-primary" href="{{ url('/testing/headers') }}">headers</a>
                <a class="margin btn btn-sm btn-primary" href="{{ url('/testing/json') }}">json</a>
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <!-- BEGIN PORTLET-->
        <div class="box box-default">

            <div class="box-header with-border">
                <h3 class="box-title"><b>Result</b></h3>
            </div>

            <div class="box-body">
                {{--{!! print_r($output) !!}--}}
                <br><br>
                @if(!empty($output) && count($output))
                    @foreach($output as $v)
                        @if(is_array($v))
                            <pre> {!! print_r($v) !!} </pre>
                        @else
                            {!! $v !!}
                        @endif
                        <br>
                        <br>
                    @endforeach
                @endif
            </div>

            <div class="box-footer">
            </div>

        </div>
        <!-- END PORTLET-->
    </div>
</div>
@endsection