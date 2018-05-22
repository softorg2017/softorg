{{--<!-- Left side column. contains the logo and sidebar -->--}}
<aside class="main-sidebar">

    {{--<!-- sidebar: style can be found in sidebar.less -->--}}
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="/AdminLTE/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::guard('outside_admin')->user()->nickname}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form" style="display:none;">
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

            <li class="header">HEADER</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview">
                <a href=""><i class="fa fa-th"></i> <span>首页管理</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{url('/admin/softorg/index')}}"><i class="fa fa-circle-o text-aqua"></i>基本信息</a></li>
                    <li><a href="{{url('/admin/softorg/edit')}}"><i class="fa fa-circle-o text-aqua"></i>编辑基本信息</a></li>
                </ul>
            </li>



            {{--内容管理--}}
            <li class="header">页面管理</li>

            <li class="treeview">
                <a href="{{url(config('outside.admin.prefix').'/admin/module/list')}}">
                    <i class="fa fa-folder-open-o text-yellow"></i> <span>模块列表</span>
                </a>
            </li>


            {{--内容管理--}}
            <li class="header">内容管理</li>

            <li class="treeview">
                <a href="{{url(config('outside.admin.prefix').'/admin/menu/list')}}">
                    <i class="fa fa-folder-open-o text-yellow"></i> <span>目录列表</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{url(config('outside.admin.prefix').'/admin/item/list')}}">
                    <i class="fa fa-file-text-o text-yellow"></i> <span>内容列表</span>
                </a>
            </li>


            {{--模板管理--}}
            <li class="header">模板管理</li>

            <li class="treeview">
                <a href="{{url(config('outside.admin.prefix').'/admin/template/list')}}">
                    <i class="fa fa-tv text-blue"></i> <span>模板列表</span>
                </a>
            </li>

            {{--企业首页--}}
            <li class="header">企业首页</li>

            <li class="treeview">
                <a href="{{url('/')}}" target="_blank">
                    <i class="fa fa-tv text-blue"></i> <span>企业首页</span>
                </a>
            </li>
        </ul>
        <!-- /.sidebar-menu -->



    </section>
    {{--<!-- /.sidebar -->--}}

</aside>