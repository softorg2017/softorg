@extends(env('LW_TEMPLATE_DOC_HOME').'layout.layout')


@section('head_title','我的轻博')


@section('header','')
@section('description','轻博 - 如未科技')
@section('breadcrumb')
    <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
doc.home.index
@endsection


@section('js')
    <script>
        $(function() {
        });
    </script>
@endsection
