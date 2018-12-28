@extends('admin.layout.layout')

@section('head_title','404')
@section('header','404')
@section('description')
    {{ $error or '页面不存在' }}
@endsection

@section('breadcrumb')
<li><a href="{{url('/admin')}}"><i class="fa fa-dashboard"></i>首页</a></li>
<li><a href="#"><i class="fa "></i>Here</a></li>
@endsection

@section('content')
        <div class="error-page">
            <h2 class="headline text-yellow"> 404</h2>

            <div class="error-content">
                <h3 style="display:none;"><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>
                <h3> &nbsp;</h3>
                <h3><i class="fa fa-warning text-yellow"></i> {{ $error or '页面不存在' }} </h3>

                <p>
                    页面不存在或者参数有误，你可以 <a href="/admin">返回首页</a> 或者 重试！
                </p>

                <p style="display:none;">
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="/admin">return to admin</a> or try using the search form.
                </p>

            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
@endsection


@section('js')
<script>
    $(function() {
    });
</script>
@endsection