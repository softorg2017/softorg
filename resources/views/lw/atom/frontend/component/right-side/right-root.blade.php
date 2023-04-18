<div class="box-body bg-white margin-bottom-4px right-menu">

    <a href="{{ url('/') }}">
        <div class="box-body {{ $sidebar_menu_for_root_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>平台首页</span>
        </div>
    </a>

    <a href="{{ url('/?type=object') }}">
        <div class="box-body {{ $sidebar_menu_for_object_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>物</span>
        </div>
    </a>

    <a href="{{ url('/?type=people') }}">
        <div class="box-body {{ $sidebar_menu_for_people_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>人</span>
        </div>
    </a>

    <a href="{{ url('/?type=product') }}">
        <div class="box-body {{ $sidebar_menu_for_product_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>作品</span>
        </div>
    </a>

    <a href="{{ url('/?type=event') }}">
        <div class="box-body {{ $sidebar_menu_for_event_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>事件</span>
        </div>
    </a>

    <a href="{{ url('/?type=conception') }}">
        <div class="box-body {{ $sidebar_menu_for_conception_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>概念</span>
        </div>
    </a>

</div>