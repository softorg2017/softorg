<div id="nav" class="nav ">
    <ul class="nav-l clearfix">
        <li id="nav_current" class="nav-current ">
            <a href="javascript:void(0);">
            </a>
        </li>
        <li>
            <a href="@yield('index-url')" class="js-nav-link" data-scroll-id="index" data-index="1">
                首页<span class="line"></span>
            </a>
        </li>
        <li>
            <a href="javascript:void(0);" class="js-nav-link" data-scroll-id="introduction" data-text="简介"
               data-black="1">
                简介<span class="line"></span>
            </a>
            <span>简介</span>
        </li>
        <li>
            <a href="@yield('index-url')/product" class="js-nav-link" data-scroll-id="business" data-text="产品" data-black="1">
                产品<span class="line"></span>
            </a>
            <span>产品</span>
        </li>
        <li>
            <a href="@yield('index-url')/activity" class="js-nav-link" data-scroll-id="activity" data-text="活动" data-black="1">
                活动<span class="line"></span>
            </a>
            <span>活动</span>
        </li>
        <li>
            <a href="@yield('index-url')/survey" class="js-nav-link" data-scroll-id="survey" data-text="问卷" data-black="1">
                问卷<span class="line"></span>
            </a>
            <span>问卷</span>
        </li>
        <li>
            <a href="@yield('index-url')/article" class="js-nav-link" data-scroll-id="article" data-text="文章" data-black="1">
                文章<span class="line"></span>
            </a>
            <span>文章</span>
        </li>
        <li>
            <a href="javascript:void(0);" class="js-nav-link" data-scroll-id="about" data-text="我们" data-black="1">
                我们<span class="line"></span>
            </a>
            <span>我们</span>
        </li>
    </ul>
</div>

<div id="nav_s" class="nav-s ">
    <div class="nav-s-ul ">
        <div class="nav-s-bg mask">
            <img src="{{asset('/frontend/images/bg_01.jpg')}}" alt="" class="blur">
            <img src="{{asset('/frontend/images/bg_01.jpg')}}" alt="">
        </div>

        <ul >
            <li>
                <a href="@yield('index-url')" class="js-nav-s-link"  >
                    首页
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="js-nav-s-link" >
                    简介
                </a>
            </li>
            <li>
                <a href="@yield('index-url')/product" class="js-nav-s-link" >
                    产品
                </a>
            </li>
            <li>
                <a href="@yield('index-url')/activity" class="js-nav-s-link" >
                    活动
                </a>
            </li>
            <li>
                <a href="@yield('index-url')/survey" class="js-nav-s-link" >
                    问卷
                </a>
            </li>
            <li>
                <a href="@yield('index-url')/article" class="js-nav-s-link" >
                    文章
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" class="js-nav-s-link" >
                    我们
                </a>
            </li>
        </ul>
    </div>

    <a id="nav_s_btn" href="javascript:void(0);" class="nav-s-btn">
        <span class="top-s"></span>
        <span class="middle-s"></span>
        <span class="bottom-s"></span>
    </a>
</div>