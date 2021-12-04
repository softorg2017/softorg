<ul class="sidebar-menu">

    <li class="header">平台</li>

    <li class="treeview {{ $sidebar_menu_for_root_active or '' }}">
        <a href="{{ url('/') }}">
            <i class="fa fa-list text-orange"></i>
            <span>首页</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_mine_active or '' }}">
        <a href="{{ url('/?type=product') }}">
            <i class="fa fa-list text-orange"></i>
            <span>我的轻博</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_favor_active or '' }}">
        <a href="{{ url('/?type=people') }}">
            <i class="fa fa-list text-orange"></i>
            <span>点赞</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_collection_active or '' }}">
        <a href="{{ url('/?type=object') }}">
            <i class="fa fa-list text-orange"></i>
            <span>收藏</span>
        </a>
    </li>

</ul>