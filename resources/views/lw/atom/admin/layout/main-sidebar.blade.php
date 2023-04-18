<aside class="main-sidebar">
    <section class="sidebar">


        <div class="user-panel _none">
            <div class="pull-left image">
                @if(@getimagesize(Auth::guard('atom_admin')->user()->portrait_img))
                    <img src="{{ url(env('DOMAIN_CDN').'/'.Auth::guard('atom_admin')->user()->portrait_img) }}" class="img-circle" alt="User Image" style="height:45px;">
                @else
                    <img src="/resource/common/images/atom_P.png" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('atom_admin')->user()->username }}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>


        <form action="#" method="get" class="sidebar-form _none">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>



        <ul class="sidebar-menu tree"data-widget="tree">


            {{--内容管理--}}
            <li class="header">内容管理</li>

            <li class="treeview {{ $menu_active_of_item_list_for_all or '' }} ">
                <a href="{{ url('/admin/item/item-list-for-all') }}">
                    <i class="fa fa-file-text text-green"></i><span>全部内容</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_object or '' }}">
                <a href="{{ url('/admin/item/item-list-for-object') }}">
                    <i class="fa fa-file-text text-green"></i><span>物</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_people or '' }}">
                <a href="{{ url('/admin/item/item-list-for-people') }}">
                    <i class="fa fa-file-text text-green"></i><span>人</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_product or '' }}">
                <a href="{{ url('/admin/item/item-list-for-product') }}">
                    <i class="fa fa-file-text text-green"></i><span>作品</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_event or '' }}">
                <a href="{{ url('/admin/item/item-list-for-event') }}">
                    <i class="fa fa-file-text text-green"></i><span>事件</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_conception or '' }}">
                <a href="{{ url('/admin/item/item-list-for-conception') }}">
                    <i class="fa fa-file-text text-green"></i><span>概念</span>
                </a>
            </li>




            {{--平台--}}
            <li class="header">平台</li>

            <li class="treeview">
                <a href="{{ env('DOMAIN_PROTOCOL').env('LW_DOMAIN_WWW') }}" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>平台首页</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ env('DOMAIN_PROTOCOL').env('LW_DOMAIN_DOC') }}" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>轻博首页</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{ env('DOMAIN_PROTOCOL').env('LW_DOMAIN_SUPER') }}/admin" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>Super.Admin</span>
                </a>
            </li>

        </ul>


    </section>
</aside>