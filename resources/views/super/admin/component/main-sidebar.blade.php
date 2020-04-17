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
                <p>{{Auth::guard('super_admin')->user()->nickname}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
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




            <li class="header">机构管理</li>

            <li class="treeview">
                <a href="{{url('/'.config('common.super.admin.prefix').'/org/list')}}">
                    <i class="fa fa-th-list"></i><span>机构列表</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{url('/'.config('common.super.admin.prefix').'/org/menu/list')}}">
                    <i class="fa fa-folder-open-o"></i><span>目录列表</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{url('/'.config('common.super.admin.prefix').'/org/item/list')}}">
                    <i class="fa fa fa-file-text-o"></i><span>内容列表</span>
                </a>
            </li>




            <li class="header">内容管理</li>




            <li class="treeview">
                <a href=""><i class="fa fa-th"></i> <span>其他</span>
                    <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('/super/admin/product/list') }}"><i class="fa fa-circle-o text-red"></i><span>产品列表</span></a></li>
                    <li><a href="{{ url('/super/admin/article/list') }}"><i class="fa fa-circle-o text-red"></i><span>文章列表</span></a></li>
                    <li><a href="{{ url('/super/admin/activity/list') }}"><i class="fa fa-circle-o text-red"></i><span>活动列表</span></a></li>
                    <li><a href="{{ url('/super/admin/survey/list') }}"><i class="fa fa-circle-o text-red"></i><span>问卷列表</span></a></li>
                    <li><a href="{{ url('/super/admin/slide/list') }}"><i class="fa fa-circle-o text-red"></i><span>幻灯片列表</span></a></li>
                </ul>
            </li>


        </ul>
        <!-- /.sidebar-menu -->
    </section>
    {{--<!-- /.sidebar -->--}}
</aside>