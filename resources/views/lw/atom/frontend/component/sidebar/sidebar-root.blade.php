<ul class="sidebar-menu">

    <li class="header">平台</li>

    <li class="treeview {{ $sidebar_menu_for_root_active or '' }}">
        <a href="{{ url('/') }}">
            <i class="fa fa-list text-orange"></i>
            <span>首页</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_object_active or '' }}">
        <a href="{{ url('/?type=object') }}">
            <i class="fa fa-list text-orange"></i>
            <span>物</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_people_active or '' }}">
        <a href="{{ url('/?type=people') }}">
            <i class="fa fa-list text-orange"></i>
            <span>人</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_product_active or '' }}">
        <a href="{{ url('/?type=product') }}">
            <i class="fa fa-list text-orange"></i>
            <span>作品</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_event_active or '' }}">
        <a href="{{ url('/?type=event') }}">
            <i class="fa fa-list text-orange"></i>
            <span>事件</span>
        </a>
    </li>

    <li class="treeview {{ $sidebar_menu_for_conception_active or '' }}">
        <a href="{{ url('/?type=conception') }}">
            <i class="fa fa-list text-orange"></i>
            <span>概念</span>
        </a>
    </li>

</ul>