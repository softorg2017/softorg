<ul class="sidebar-menu">

    <li class="header">{{ $user->username or "用户" }}</li>

    <li class="treeview {{ $sidebar_menu_root_active or '' }}">
        <a href="{{ url('/user/'.$user->id) }}">
            <i class="fa fa-list text-orange"></i>
            <span>Ta的主页</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_article_active or '' }}">
        <a href="{{ url('/user/'.$user->id.'?type=article') }}">
            <i class="fa fa-list text-orange"></i>
            <span>文章</span>
            <span class="margin-left-8px pull-right-">{{ $user->article_count or 0 }}</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_activity_active or '' }}">
        <a href="{{ url('/user/'.$user->id.'?type=activity') }}">
            <i class="fa fa-list text-orange"></i>
            <span>活动</span>
            <span class="margin-left-8px pull-right-">{{ $user->activity_count or 0 }}</span>
        </a>
    </li>


    <li class="header">平台</li>

    <li class="treeview {{ $sidebar_menu_root_active or '' }}">
        <a href="{{ url('/') }}">
            <i class="fa fa-home text-orange"></i>
            <span>返回平台首页</span>
        </a>
    </li>

</ul>