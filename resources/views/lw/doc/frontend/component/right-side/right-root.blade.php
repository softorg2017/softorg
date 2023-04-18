<div class="box-body bg-white margin-bottom-4px right-menu">

    <a href="{{ url('/') }}">
        <div class="box-body {{ $sidebar_menu_for_root_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>平台首页</span>
        </div>
    </a>

    <a href="{{ url('/mine/item-mine') }}">
        <div class="box-body {{ $sidebar_menu_for_mine_active or '' }}">
            <i class="fa fa-list text-orange" style="width:24px;"></i>
            <span>我的轻博</span>
        </div>
    </a>

    <a href="{{ url('/mine/item-my-favor') }}">
        <div class="box-body {{ $sidebar_menu_for_my_favor_active or '' }}">
            <i class="fa fa-heart text-orange" style="width:24px;"></i>
            <span>点赞</span>
        </div>
    </a>

    <a href="{{ url('/mine/item-my-collection') }}">
        <div class="box-body {{ $sidebar_menu_for_my_collection_active or '' }}">
            <i class="fa fa-star text-orange" style="width:24px;"></i>
            <span>收藏</span>
        </div>
    </a>

</div>