@extends(env('TEMPLATE_SUPER_ADMIN').'layout.layout')


{{--html.head--}}
@section('head_title')【Super】404 - 如未科技@endsection
@section('meta_author')@endsection
@section('meta_title')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header','404')
@section('description')
    {{ $error or '页面不存在' }}
@endsection




{{----}}
@section('content')
    <div class="error-page">
        <h3 class="headline text-yellow"> 404</h3>

        <div class="error-content">
            <h4 style="display:none;"><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h4>
            <h3> &nbsp;</h3>
            <h4><i class="fa fa-warning text-yellow"></i> {{ $error or '页面不存在 or 参数有误' }} </h4>

            <p>
                你可以 <a href="/admin">返回首页</a>
                或者 <a href="javascript:history.go(-1);">返回上一页</a>
                或者 <a href="javascript:location.reload();">刷新</a> 重试！
            </p>

            <p style="display:none;">
                We could not find the page you were looking for.
                Meanwhile, you may <a href="/admin">return to admin</a> or try using the search form.
            </p>
        </div>
    </div>
@endsection




@section('js')
<script>
    $(function() {
    });
</script>
@endsection