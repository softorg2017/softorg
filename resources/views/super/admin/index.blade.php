@extends(env('TEMPLATE_SUPER_ADMIN').'layout.layout')

@section('head_title','超级管理员系统')

@section('header','超级管理员')
@section('description','超级管理员')
@section('breadcrumb')
    <li><a href="{{url('/super/admin')}}"><i class="fa fa-dashboard"></i>首页</a></li>
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
