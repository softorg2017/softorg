@extends('super.admin.layout.layout')

@section('title','超级管理员')
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
