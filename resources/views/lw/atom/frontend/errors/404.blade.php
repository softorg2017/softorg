@extends(env('TEMPLATE_DEFAULT').'frontend.layout.layout')

@section('head_title','404 页面不存在或参数有误 - 朝鲜族组织平台')
@section('meta_title')@endsection
@section('meta_author')@endsection
@section('meta_description')@endsection
@section('meta_keywords')@endsection


@section('header','')
@section('description','')
@section('content')
<div class="container">

    <div class="col-sm-12 col-md-12 container-body-left" style="width:100%;float:left;text-align:center;">

        <div class="error-page">

            <div class="error-content">

                <h1 class="headline- text-yellow">
                    <i class="fa fa-warning" style="width:auto;margin-right:4px;font-size:28px;"></i>
                    404.
                </h1>

                <p>
                    真遗憾，您访问的页面好像被劫持了。
                </p>

                <h3 style="display:none;"><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

                <h4 style="margin-top:32px;font-size:20px;font-weight:300;">
                    {{--<i class="fa fa-warning text-yellow" style="width:24px;margin-right:8px;"></i>--}}
                    {{--抱歉--}}
                    {{ $error["text"] or '页面不存在或者参数有误！' }}
                </h4>
                <p>
{{--                    {{ $error["text"] or '页面不存在或者参数有误！' }}--}}
                </p>

                <div style="margin-top:32px;margin-bottom:16px;">
                    <p>
                        您可以
                    </p>
                    <a href="/" class="a"><i class="fa fa-home"></i> 返回首页</a>
                    <span>或</span>
                    <a href="javascript:location.reload();" class="a"><i class="fa fa-rotate-left"></i> 刷新重试</a>
                </div>

                <div>
                    <span id="time" style="color:#ff0018;" data-time="5">5</span> 秒钟自动跳到首页
                </div>

                <p style="display:none;">
                    We could not find the page you were looking for.
                    Meanwhile, you may <a href="/">return to admin</a> or try using the search form.
                </p>

            </div>
        </div>

    </div>

    <div class="col-sm-12 col-md-3 hidden-xs hidden-sm container-body-right">

        {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-root')--}}
        {{--@include(env('TEMPLATE_DEFAULT').'frontend.component.right-me')--}}

    </div>


</div>
@endsection


@section('custom-style')
<style>
    .a { padding:4px 8px; margin:4px 2px; border:1px solid #ccc; }
</style>
@endsection


@section('js')
<script>
    $(function () {
        setTimeout(ChangeTime, 1200);
    });

    function ChangeTime()
    {
        var time;
        time = $("#time").attr('data-time');
        time = parseInt(time);
        time--;
        console.log(time);

        if (time <= 0) {
            window.location.href = "{{ url('/') }}";
        }
        else {
            $("#time").text(time);
            $("#time").attr('data-time',time);
            setTimeout(ChangeTime, 1000);
        }
    }
</script>
@endsection