{{--<!-- Main Footer -->--}}
<footer class="main-footer margin-left-0">
    <!-- To the right -->
    <div class="pull-right hidden-xs _none">
        Anything you want
    </div>
    <!-- Default to the left -->
    {{--<strong>Copyright &copy; 上海如哉网络科技有限公司 2017-2020 <a href="#">Company</a>.</strong> All rights reserved. 沪ICP备17052782号-4--}}
    <small class="">
        {{--注册组织•赞助商请联系管理员--}}
        <a href="/">首页</a>
        <span style="margin-left:4px;margin-right:4px;">|</span>
        @if(!Auth::check())
            <a href="{{ url('/login-link') }}">登录</a>
        @else
            <a href="{{ url('/user/'.Auth::id()) }}">返回我的名片</a>
            <span class="margin-left-4px margin-right-4px">|</span>
            <a href="{{ url('/login-my-doc') }}">登录我的轻博</a>
            <span class="margin-left-4px margin-right-4px">|</span>
            <a href="{{ url('/my-doc-account-create') }}">创建一个轻博</a>
            <span class="margin-left-4px margin-right-4px">|</span>
            <a href="{{ env('DOMAIN_DOC') }}" target="_blank">轻博首页</a>
        @endif
        {{--<span style="margin-left:4px;margin-right:4px;">|</span>--}}
        {{--<a href="/introduction">平台介绍</a>--}}
        {{--<span style="margin-left:4px;margin-right:4px;">|</span>--}}
        {{--<a href="/org">组织登录</a>--}}
        {{--<span style="margin-left:4px;margin-right:4px;">|</span>--}}
        {{--<a href="/org/register">注册新组织</a>--}}
    </small>
    <br>
    {{--<small>如有疑问请联系管理员 电话：<strong>17721364771</strong></small>--}}
    {{--<br>--}}
    {{--<small>联系电话：</small><strong>17721364771</strong>--}}
    {{--<br>--}}
    <small>版权所有&copy;上海如哉网络科技有限公司</small><span class="_none">(2017-2021)</span>
    <br class="visible-xs">
    <a target="_blank" href="https://beian.miit.gov.cn"><small>沪ICP备17052782号-5</small></a>
</footer>