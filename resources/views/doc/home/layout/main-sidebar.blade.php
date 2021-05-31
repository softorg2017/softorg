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
                <p>{{ Auth::guard('super')->user()->nickname }}</p>
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
        <ul class="sidebar-menu">

            <!-- Optionally, you can add icons to the links -->

            <li class="treeview _none">
                <a href="">
                    <i class="fa fa-th"></i> <span>Super</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{url('/'.config('common.super.admin.prefix').'/softorg/index')}}">
                            <i class="fa fa-circle-o text-aqua"></i>基本信息
                        </a>
                    </li>
                    <li>
                        <a href="{{url('/'.config('common.super.admin.prefix').'/softorg/edit')}}">
                            <i class="fa fa-circle-o text-aqua"></i>编辑基本信息
                        </a>
                    </li>
                </ul>
            </li>




            <li class="header"><i class="fa fa-circle-o"></i> 内容管理</li>

            <li class="treeview {{ $sidebar_item_list_for_all_active or '' }}">
                <a href="{{url('/home/item/item-list-all')}}">
                    <i class="fa fa-list text-red"></i>
                    <span>全部内容</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_list_for_article_active or '' }}">
                <a href="{{url('/home/item/item-list?item-type=article')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>文章</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_list_for_menu_type_active or '' }}">
                <a href="{{url('/home/item/item-list?item-type=menu_type')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>书目</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_list_for_time_line_active or '' }}">
                <a href="{{url('/home/item/item-list?item-type=time_line')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>时间线</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_item_list_for_debase_active or '' }}">
                <a href="{{url('/home/item/item-list?item-type=debase')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>辩题</span>
                </a>
            </li>











            {{--流量统计--}}
            <li class="header">流量统计</li>

            <li class="treeview {{ $sidebar_statistic_active or '' }}">
                <a href="{{ url('/admin/statistic') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>流量统计</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_statistic_all_list_active or '' }}">
                <a href="{{ url('/admin/statistic/statistic-all-list') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>统计列表</span>
                </a>
            </li>



            {{--平台--}}
            <li class="header">平台</li>

            <li class="treeview">
                <a href="{{ env('DOMAIN_DOC') }}" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>平台首页</span>
                </a>
            </li>



        </ul>
        <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>