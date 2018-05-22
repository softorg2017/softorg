{{--隐藏的头部目录--}}
<div class="top-wrapper">
    <div class="top extra menu sticky">
        <div class="wrap">
            <div class="settings">
            </div>
            <div class="right">
                {{--@yield('header-extra-menus')--}}
                @if( count($menus) > 0 )
                    @foreach($menus as $menu)
                        <a class="big-txt" href="{{url('/menu/'.encode($menu->id))}}">{{ $menu->title }}</a>
                    @endforeach
                @endif
                <a href="#contact" class="hidden-sm">关于我们</a>
                <a href="#" class="btn-icon-close"><i class="icon-close"></i></a>
            </div>
        </div>
    </div>
</div>


{{--头部--}}
<div class="top-wrapper">
    <div class="top primary menu sticky">
        <div class="wrap">
            <a fade-onload href="@yield('root-link')" title="Home" rel="home" id="logo">
                <img class="logo logo-black" src="@yield('info-logo-url')" alt="@yield('info-short-name')"/>
                <img class="logo logo-white" src="@yield('info-logo-url')" alt="@yield('info-short-name')"/>
            </a>
            <div class="right" fade-onload>
                <a class="hidden-sm text-item" href="{{url('/')}}">首页</a>

                {{--@yield('header-primary-menus')--}}
                <a class="big-txt" href="{{url('/website/templates/')}}">建站模板</a>
                {{--@if( count($menus) > 0 )--}}
                {{--@foreach($menus as $menu)--}}
                {{--@if($loop->index < 2)--}}
                {{--<a class="big-txt" href="{{url(config('common.org.front.prefix').'/menu/'.encode($menu->id))}}">{{ $menu->title }}</a>--}}
                {{--@else--}}
                {{--<a class="big-txt hidden-sm" href="{{url(config('common.org.front.prefix').'/menu/'.encode($menu->id))}}">{{ $menu->title }}</a>--}}
                {{--@endif--}}
                {{--@endforeach--}}
                {{--@endif--}}
                {{--<a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/product">产品</a>--}}
                {{--<a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/article">文章</a>--}}
                {{--<a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/activity">活动</a>--}}
                {{--<a class="hidden-sm text-item" href="/org/{{$org->website_name or '1'}}/survey">问卷</a>--}}

                <a class="btn-menu-burger" href="#">
                    <img class="icon-menu icon-menu--white" src="{{asset('/templates/themes/vipp/assets/img/icon-menu-white@2x.svg')}}" alt="目录">
                    <img class="icon-menu icon-menu--black" src="{{asset('/templates/themes/vipp/assets/img/icon-menu-black@2x.svg')}}" alt="目录">
                    <i class="icon-close"></i>
                </a>
            </div>
        </div>
    </div>
</div>


{{--侧边栏--}}
<div class="tray-menu--mask"></div>
<div class="tray-menu">
    <ul class="main menu-level menu-current menu-in">
        <li>
            <div>
                <img class="logo" src="@yield('info-logo-url')" alt="@yield('info-short-name')">
            </div>
            <div style="display:none;">
                <img class="logo" src="@yield('info-logo-url')" alt="@yield('info-short-name')">
            </div>
        </li>
        <li>
            <ul class="first-nav">
                {{--@yield('sidebar-menus')--}}
                @if( count($menus) > 0 )
                    @foreach($menus as $menu)
                        <li><a class="big-txt" href="{{url('/menu/'.encode($menu->id))}}">
                                <i class="fa fa-dot-circle-o" style="font-size:8px;margin-right:8px;"></i> {{ $menu->title }}</a></li>
                        <li class="padder">&nbsp;</li>
                    @endforeach
                @endif
            </ul>
        </li>
        <li class="padder">&nbsp;</li>
        <li style="display:none;">
            <ul class="second-nav">
                <li><a href="@yield('root-link')/product">产品</a></li>
                <li><a href="@yield('root-link')/article">文章</a></li>
                <li><a href="@yield('root-link')/activity">活动</a></li>
                <li><a href="@yield('root-link')/survey">问卷</a></li>
                <li><a href="#contact" class="">关于我们</a></li>
            </ul>
        </li>
        <li class="padder">&nbsp;</li>
    </ul>
</div>