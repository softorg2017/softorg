@extends('super.layout.layout')

@section('title','softorg 超级后台')
@section('header','softorg 超级后台')
@section('description','超级后台')
@section('breadcrumb')
    <li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>首页</a></li>
    <li><a href="#"><i class="fa "></i>Here</a></li>
@endsection

@section('content')
super.index
@endsection


@section('js')
    <script>
        $(function() {
        });
    </script>
@endsection
