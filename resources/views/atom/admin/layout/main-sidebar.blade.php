{{--<!-- Left side column. contains the logo and sidebar -->--}}
<aside class="main-sidebar">

    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel _none">
            <div class="pull-left image">
                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('atom')->user()->username }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form _none">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu tree"data-widget="tree">




            {{--内容管理--}}
            <li class="header">内容管理</li>

            <li class="treeview {{ $sidebar_item_all_list_active or '' }} ">
                <a href="{{ url('/admin/item/item-all-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>全部内容</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_object_list_active or '' }}">
                <a href="{{ url('/admin/item/item-object-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>物</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_people_list_active or '' }}">
                <a href="{{ url('/admin/item/item-people-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>人</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_product_list_active or '' }}">
                <a href="{{ url('/admin/item/item-product-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>作品</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_event_list_active or '' }}">
                <a href="{{ url('/admin/item/item-event-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>事件</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_conception_list_active or '' }}">
                <a href="{{ url('/admin/item/item-conception-list') }}">
                    <i class="fa fa-file-text text-green"></i><span>概念</span>
                </a>
            </li>




            {{--流量统计--}}
            <li class="header">流量统计</li>

            <li class="treeview {{ $sidebar_statistic_active or '' }}">
                <a href="{{ url('/statistic') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>流量统计</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_statistic_all_list_active or '' }}">
                <a href="{{ url('/atom/statistic/statistic-all-list') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>统计列表</span>
                </a>
            </li>




            {{--平台--}}
            <li class="header">平台</li>

            <li class="treeview">
                <a href="{{ url('/') }}" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>平台首页</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{ env('DOMAIN_SUPER') }}/admin" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>Super.Admin</span>
                </a>
            </li>






        </ul>
        <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>