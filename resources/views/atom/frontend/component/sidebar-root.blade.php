<ul class="sidebar-menu">

    <li class="header">平台</li>

    <li class="treeview {{ $sidebar_menu_root_active or '' }}">
        <a href="{{ url('/') }}">
            <i class="fa fa-list text-orange"></i>
            <span>平台首页</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_activity_active or '' }}">
        <a href="{{ url('/?type=activity') }}">
            <i class="fa fa-list text-orange"></i>
            <span>只看活动</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_organization_active or '' }}">
        <a href="{{ url('/organization-list') }}">
            <i class="fa fa-list text-orange"></i>
            <span>社群组织</span>
        </a>
    </li>

    <li class="header _none">我的</li>

    <div class="_none">
    @if(!Auth::check())

        <li class="treeview">
            <a href="{{ url('/login-link') }}">
                <i class="fa fa-circle-o"></i>
                <span>登录</span>
            </a>
        </li>
        <li class="treeview _none">
            <a href="{{ url('/register') }}">
                <i class="fa fa-circle-o"></i>
                <span>注册</span>
            </a>
        </li>
    @else
        <li class="treeview">
            <a href="javascript:void(0);">
                <i class="fa fa-home text-red"></i>
                <span>{{ Auth::user()->username }}</span>
            </a>
        </li>
        <li class="treeview {{ $sidebar_menu_my_follow_active or '' }}">
            <a href="{{ url('/my-follow') }}">
                <i class="fa fa-user text-red"></i>
                <span>我的关注</span>
            </a>
        </li>
        <li class="treeview {{ $sidebar_menu_my_favor_active or '' }}">
            <a href="{{ url('/my-favor') }}">
                <i class="fa fa-heart text-red"></i>
                <span>我的收藏</span>
            </a>
        </li>
        <li class="treeview {{ $sidebar_menu_my_notification_active or '' }}">
            <a href="{{ url('/my-notification') }}">
                <i class="fa fa-bell text-red"></i>
                <span>消息通知</span>
            </a>
        </li>
        <li class="treeview">
            <a href="{{ url('/logout') }}">
                <i class="fa fa-sign-out text-blue"></i>
                <span>退出</span>
            </a>
        </li>
    @endif
    </div>

</ul>