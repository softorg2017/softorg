<div class="box-body bg-white margin-bottom-4px right-home">

    @if(!Auth::check())
        <a href="{{ url('/login-link?return=root') }}">
            <div class="box-body">
                <i class="fa fa-sign-in text-blue" style="width:24px;"></i><span>已有名片，去登录</span>
            </div>
        </a>
        <a href="{{ url('/login-link?return=root') }}">
            <div class="box-body">
                <i class="fa fa-sign-in text-blue" style="width:24px;"></i><span>还没有名片，创建我的名片</span>
            </div>
        </a>
        {{--<a href="{{url('/register')}}">--}}
        {{--<div class="box-body {{ $menu_anonymous or '' }}">--}}
        {{--<i class="fa fa-circle-o text-blue"></i> <span>&nbsp; 注册</span>--}}
        {{--</div>--}}
        {{--</a>--}}
    @else
        {{--<a href="{{url('/home')}}">--}}
        <div class="box-body _none">
            <i class="fa fa-home text-blue" style="width:24px;"></i><span>{{ Auth::user()->username }}</span>
        </div>
        {{--</a>--}}
        <a href="{{ url('/my-card') }}">
            <div class="box-body {{ $right_menu_my_card_active or '' }}">
                <i class="fa fa-user text-red" style="width:24px;"></i>
                <span>我的名片</span>
            </div>
        </a>
        <a href="{{ url('/my-cards-case') }}">
            <div class="box-body {{ $right_menu_my_cards_case_active or '' }}">
                <i class="fa fa-list-alt text-red" style="width:24px;"></i>
                <span>我的名片夹</span>
            </div>
        </a>
        <a href="{{ url('/my-follow') }}" class="_none">
            <div class="box-body {{ $right_menu_my_follow_active or '' }}">
                <i class="fa fa-list-alt text-red" style="width:24px;"></i>
                <span>我的关注</span>
            </div>
        </a>
        <a href="{{ url('/my-favor') }}" class="_none">
            <div class="box-body {{ $right_menu_my_favor_active or '' }}">
                <i class="fa fa-heart text-red" style="width:24px;"></i>
                <span>我的收藏</span>
            </div>
        </a>
        <a href="{{ url('/my-notification') }}" class="_none">
            <div class="box-body {{ $right_menu_my_notification_active or '' }}">
                <i class="fa fa-bell text-red" style="width:24px;"></i>
                <span>消息通知</span>
            </div>
        </a>
        <a href="{{ url(env('DOMAIN_DOC')) }}" class="" target="_blank">
            <div class="box-body {{ $right_menu_my_doc_active or '' }}">
                <i class="fa fa-list text-red" style="width:24px;"></i>
                <span>我的轻博</span>
            </div>
        </a>
        <a href="{{ url('/my-doc-list') }}" class="">
            <div class="box-body {{ $right_menu_my_doc_list_active or '' }}">
                <i class="fa fa-list text-red" style="width:24px;"></i>
                <span>我的轻博账号</span>
            </div>
        </a>
        <a href="{{ url('/my-community') }}" class="">
            <div class="box-body {{ $right_menu_my_doc_list_active or '' }}">
                <i class="fa fa-list text-red" style="width:24px;"></i>
                <span>我的社区</span>
            </div>
        </a>
    @endif

</div>