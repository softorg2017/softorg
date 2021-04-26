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
                <p>{{ Auth::guard('gps')->user()->username }}</p>
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
            <li class="header">GPS</li>

            <li class="treeview {{ $sidebar_navigation_active or '' }}">
                <a href="{{ url('/admin/navigation') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>Navigation</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_template_active or '' }}">
                <a href="{{ url('/admin/template-list') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>Template</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_tool_active or '' }}">
                <a href="{{ url('/admin/tool-list') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>Tool</span>
                </a>
            </li>
            <li class="treeview {{ $sidebar_test_active or '' }}">
                <a href="{{ url('/admin/test-list') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>Test</span>
                </a>
            </li>
            <li class="treeview">
                <a target="_blank" href="{{ url('/developing') }}">
                    <i class="fa fa-cube text-red"></i><span>Developing</span>
                </a>
            </li>




            <li class="treeview active _none">
                <a href=""><i class="fa fa-th"></i> <span>GPS</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/admin/tool-list') }}"><i class="fa fa-circle-o text-blue"></i>Tool</a></li>
                    <li><a href="{{ url('/admin/test-list') }}"><i class="fa fa-circle-o text-blue"></i>Test</a></li>
                </ul>
            </li>




            {{--内容管理--}}
            <li class="header">AdminLTE</li>

            <li class="treeview {{ $sidebar_test_active or '' }}">
                <a target="_blank" href="{{ url('/AdminLTE') }}">
                    <i class="fa fa-bar-chart text-green"></i> <span>AdminLTE</span>
                </a>
            </li>
            <li class="treeview">
                <a target="_blank" href="{{ url('/AdminLTE/pages/UI/icons.html') }}">
                    <i class="fa fa-cube text-red"></i><span>icons</span>
                </a>
            </li>




            {{--平台--}}
            <li class="header">平台</li>

            <li class="treeview">
                <a href="{{ env('DOMAIN_WWW') }}" target="_blank">
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