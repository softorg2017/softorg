<aside class="main-sidebar">
    <section class="sidebar">


        <div class="user-panel _none">
            <div class="pull-left image">
                @if(@getimagesize(Auth::guard('doc_admin')->user()->portrait_img))
                    <img src="{{ url(env('DOMAIN_CDN').'/'.Auth::guard('doc_admin')->user()->portrait_img) }}" class="img-circle" alt="User Image" style="height:45px;">
                @else
                    <img src="/resource/common/images/doc_P_240.png" class="img-circle" alt="User Image">
                @endif
            </div>
            <div class="pull-left info">
                <p>{{ Auth::guard('doc_admin')->user()->username }}</p>
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

            <li class="treeview {{ $menu_active_of_item_list_for_all or '' }}">
                <a href="{{url('/home/item/item-list-for-all')}}">
                    <i class="fa fa-list text-red"></i>
                    <span>全部内容</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_article or '' }}">
                <a href="{{url('/home/item/item-list?item-type=article')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>文章</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_activity or '' }}">
                <a href="{{url('/home/item/item-list?item-type=activity')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>活动</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_menu_type or '' }}">
                <a href="{{url('/home/item/item-list?item-type=menu_type')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>书目</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_time_line or '' }}">
                <a href="{{url('/home/item/item-list?item-type=time_line')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>时间线</span>
                </a>
            </li>
            <li class="treeview {{ $menu_active_of_item_list_for_debase or '' }}">
                <a href="{{url('/home/item/item-list?item-type=debase')}}">
                    <i class="fa fa-circle-o text-red"></i>
                    <span>辩题</span>
                </a>
            </li>




            {{--管理员--}}
            <li class="header">管理员</li>

            <li class="treeview {{ $sidebar_user_administrator_list_active or '' }}">
                <a href="{{ url('/home/user/my-administrator-list') }}">
                    <i class="fa fa-cny text-red"></i> <span>我的管理员</span>
                </a>
            </li>




            {{--平台--}}
            <li class="header">平台</li>

            <li class="treeview">
                <a href="{{ env('DOMAIN_PROTOCOL').env('LW_DOMAIN_DOC') }}" target="_blank">
                    <i class="fa fa-cube text-default"></i> <span>轻博首页</span>
                </a>
            </li>



        </ul>


    </section>
</aside>