@extends(env('LW_TEMPLATE_SUPER_ADMIN').'layout.layout')


@section('head_title')
    @if(in_array(env('APP_ENV'),['local','dev'])){{ $local or 'L.' }}@endif
    {{ $title_text or '首页' }} - 超级管理员系统 - 如未科技
@endsection


@section('header','Super')
@section('description','超级管理员系统 - 如未科技')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection


@section('content')
super.admin.index
@endsection


@section('js')
    <script>
        $(function() {
        });
    </script>
@endsection
