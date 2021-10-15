@extends('frontend.layout.layout')

@section('title','404')
@section('header','404')
@section('description','参数有误')
@section('breadcrumb')
<li><a href="{{url('/backend')}}"><i class="fa fa-dashboard"></i>首页</a></li>
<li><a href="#"><i class="fa "></i>Here</a></li>
@endsection

@section('content')
        <div class="error-page">
            <h3 class="headline text-yellow"> 404</h3>

            <div class="error-content">
                <h4><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h4>

                <p>
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