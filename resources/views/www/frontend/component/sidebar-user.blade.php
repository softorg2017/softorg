<ul class="sidebar-menu">

    <li class="header">{{ $data->username or "用户" }}</li>

    <li class="treeview {{ $sidebar_menu_root_active or '' }}">
        <a href="{{ url('/user/'.$data->id) }}">
            <i class="fa fa-home text-orange"></i>
            <span>Ta的主页</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_introduction_active or '' }}">
        <a href="{{ url('/user/'.$data->id.'?type=introduction') }}">
            <i class="fa fa-file-image-o text-orange"></i>
            <span>图文介绍</span>
        </a>
    </li>

    @if($data->user_type == 11)
    <li class="treeview {{ $sidebar_menu_article_active or '' }}">
        <a href="{{ url('/user/'.$data->id.'?type=article') }}">
            <i class="fa fa-file-text-o text-orange"></i>
            <span>文章</span>
            <span class="margin-left-8px pull-right-">{{ $data->article_count or 0 }}</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_activity_active or '' }}">
        <a href="{{ url('/user/'.$data->id.'?type=activity') }}">
            <i class="fa fa-calendar text-orange"></i>
            <span>活动</span>
            <span class="margin-left-8px pull-right-">{{ $data->activity_count or 0 }}</span>
        </a>
    </li>
    @endif

    @if($data->user_type == 88)
    <li class="treeview {{ $sidebar_menu_org_active or '' }}">
        <a href="{{ url('/user/'.$data->id.'?type=org') }}">
            <i class="fa fa-cube text-orange"></i>
            <span>赞助组织</span>
            <span class="margin-left-8px pull-right-">{{ $data->pivot_org_count or 0 }}</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_activity_active or '' }}">
        <a href="{{ url('/user/'.$data->id.'?type=activity') }}">
            <i class="fa fa-calendar text-orange"></i>
            <span>活动</span>
            <span class="margin-left-8px pull-right-">{{ $data->activity_count or 0 }}</span>
        </a>
    </li>
    @endif


    <li class="header">平台</li>

    <li class="treeview {{ $sidebar_menu_root_active or '' }}">
        <a href="{{ url('/') }}">
            <i class="fa fa-home text-orange"></i>
            <span>返回平台首页</span>
        </a>
    </li>

</ul>