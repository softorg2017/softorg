<ul class="sidebar-menu">

    <li class="header">{{ $data->username or "用户" }}</li>

    <li class="treeview {{ $sidebar_menu_root_active or '' }}">
        <a href="{{ url('/user/'.$data->id) }}">
            <i class="fa fa-home text-orange"></i>
            <span>我的名片</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_introduction_active or '' }}">
        <a href="{{ url('/user/'.$data->id.'?type=introduction') }}">
            <i class="fa fa-file-image-o text-orange"></i>
            <span>图文介绍</span>
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