@extends('frontend.layouts.app')

@section('content')
    @include('frontend.layouts.header')

    <div id="fullpage">
        <div id="index" class="section index mask loaded">
            <div class="index-container">
                <h1>精益资本</h1>
                <p>
                    <span>发</span><span>掘</span><span>科</span><span>技</span><span>的</span><span>价</span><span>值</span>
                </p>
            </div>

            <a id="index_next" href="javascript:void(0);" class="index-next">
                下一页
            </a>
        </div>

        <div id="introduction" class="section introduction ">
            <div class="introduction-container js-load">
                <div class="introduction-left">LEAN</div>
                <div class="introduction-right">
                    <span class="introduction-right-top"></span>
                    <span class="introduction-top-text ">发掘科技的价值</span>
                    <span class="introduction-right-bottom"></span>
                    <span class="introduction-bottom-text ">精益创业的验证</span>
                    <div class="introduction-content">
                        <p>精益资本成立于2015年，为创业公司提供业务并购、资产交易以及数据支持服务。</p>
                        <p>我们致力于为创业公司提供其最需要的科技资产，使其可以最短时间最小成本的进入市场进行精益创业的验证。</p>
                        <p>主要面向天使轮之后和B轮以前的新型科技及互联网公司。</p>
                    </div>
                </div>
            </div>
            <div id="introduction_logo_container" class="introduction-logo-container">
                <p>合作伙伴</p>
                <a href="javascript:void(0);" id="introduction_close_btn" class="introduction-close-btn"></a>
                <div class="introduction-logos">
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_01.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_02.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_03.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_04.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_05.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_06.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_07.png')}}" alt="">
                    </span>
                    <span class="introduction-logo">
                        <img src="{{asset('/frontend/images/introduction_logo/logo_08.png')}}" alt="">
                    </span>
                </div>
            </div>
        </div>

        <div id="business" class="section business ">
            <div class="business-container clearfix js-load">
                <div class="col-4">
                    <div class="business-icon">
                        <img src="{{asset('/frontend/images/img_02.png')}}" alt="">
                    </div>
                    <div class="business-title">业务并购</div>
                    <p class="business-desc">
                        为互联网初创企业进行业务并购服务，并购标的包括各领域的初创项目、整体业务、项目团队等。
                    </p>
                </div>
                <div class="col-4">
                    <div class="business-icon">
                        <img src="{{asset('/frontend/images/img_03.png')}}" alt="">
                    </div>
                    <div class="business-title">资产交易</div>
                    <p class="business-desc">
                        为互联网公司提供资产交易顾问服务，包括社交媒体资产、用户数据、人力资产、移动应用、网站产品以及其他各类资产。
                    </p>
                </div>
                <div class="col-4">
                    <div class="business-icon">
                        <img src="{{asset('/frontend/images/img_04.png')}}" alt="">
                    </div>
                    <div class="business-title">金融支持</div>
                    <p class="business-desc">
                        面对有潜力的项目与恰当的交易结构，通过与风险投资机构 (VC) 进行股权投资合作，或与创业贷款机构 (VL) 进行过桥债务合作，为交易提供金融支持。
                    </p>
                </div>
            </div>
        </div>

        <div id="idea" class="section idea ">
            <div class="idea-logo js-load">
                <div class="idea-logo-top"></div>
                <div class="idea-logo-l">L</div>
                <div class="idea-logo-e">E</div>
                <div class="idea-logo-a">A</div>
                <div class="idea-logo-n">N</div>
                <div class="idea-logo-bottom"></div>
                <div class="idea-logo-content">
                    <p><span class="sp">精益创业</span>是硅谷流行的一种创业方法论，它的核心思想是，先在市场中投入一个极简的原型产品，然后通过不断的学习和有价值的用户反馈，对产品进行<span
                                class="sp">快速迭代优化</span>，以期适应<span class="sp">市场</span>。</p>
                    <p>同样，我们所追求的也是让每一个新兴公司都可以使用<span class="sp">最精益的方法</span>获得所需要的业务资源，比如<span
                                class="sp">并购或资产交易</span>。通过我们的专业服务，我们可以为您的业务提供<span class="sp">关键驱动力</span>，让您在变化万千的市场中<span
                                class="sp">快速实施战略</span>。</p>
                </div>
            </div>
        </div>

        <div id="contrast" class="section contrast ">
            <div class="contrast-container js-load">
                <div class="col-6 contrast-bad">
                    <div class="title">
                        内部实施的缺点
                    </div>
                    <ol>
                        <li>1. 成本难测，可能拖累公司整体财务计划 <span class="line"></span></li>
                        <li>2. 耗费时间，可能失去关键市场机会窗口 <span class="line"></span></li>
                        <li>3. 内部组建团队实施，从招聘到绩效，增加创始人的管理成本 <span class="line"></span><span class="line2"></span></li>
                    </ol>
                </div>
                <div class="col-6 contrast-good">
                    <div class="title">
                        资产并购的优点
                    </div>
                    <ol>
                        <li>1. 成本确定，方便战略规划和财务规划 <span class="like"></span></li>
                        <li>2. 时间确定，资产并购交易快速执行，有利于战略的快速实施 <span class="like"></span></li>
                        <li>3. 直接得到有价值的资产或团队，最大幅度降低管理成本 <span class="like"></span></li>
                    </ol>
                </div>
            </div>
        </div>

        <div id="advantage" class="section advantage ">
            <div class="advantage-container">
                <div class="col-4 js-load">
                    <div class="title">全面的资产并购数据库</div>
                    <div class="content">
                        <p>通过与媒体与平台渠道的合作，我们整合了中国最顶尖的创投圈信息渠道以及并购市场核心数据。</p>

                        <p>我们的项目数据库包括: 社交 · 电商 · 游戏 · O2O · 医疗 · 智能硬件 · 汽车 · 房产 · 教育 ·
                            企业服务等数十个领域的上百个项目产品、资产、数据以及团队资源数据。</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="title">专业的金融与法律服务</div>
                    <div class="content">
                        <p>在法律专业的服务上，我们与并购，融资，金融方面最专业的协力律所合作，以期为并购以及资产交易提供最专业的尽职调查、流程设计、法律保证以及交易实施服务。</p>

                        <p>在金融专业服务上，我们与近十家风险基金和数家资金量雄厚的地产、实业集团达成战略协议，并力图基于这些合作伙伴，为并购交易提供最稳健的服务保证。</p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="title">跨领域的初创公司洞见</div>
                    <div class="content">
                        <p>我们的核心团队来自中国最顶尖的互联网公司、初创公司以及战略咨询公司，并与中国最优秀的互联网公司、投资基金、FA达成顾问合作，我们了解科技的价值。</p>

                        <p>基于核心团队以及顾问的行业经验，我们提供对各领域以及个资产领域最精确的洞见和最深入的研究，为交易提供价值驱动。</p>
                    </div>
                </div>
            </div>
            <div class="advantage-slide-container">
                <div class="col-4 slide">
                    <div class="title">全面的资产并购数据库</div>
                    <div class="content">
                        <p>通过与媒体与平台渠道的合作，我们整合了中国最顶尖的创投圈信息渠道以及并购市场核心数据。</p>

                        <p>我们的项目数据库包括: 社交 · 电商 · 游戏 · O2O · 医疗 · 智能硬件 · 汽车 · 房产 · 教育 ·
                            企业服务等数十个领域的上百个项目产品、资产、数据以及团队资源数据。</p>
                    </div>
                </div>
                <div class="col-4 slide">
                    <div class="title">专业的金融与法律服务</div>
                    <div class="content">
                        <p>在法律专业的服务上，我们与并购，融资，金融方面最专业的协力律所合作，以期为并购以及资产交易提供最专业的尽职调查、流程设计、法律保证以及交易实施服务。</p>

                        <p>在金融专业服务上，我们与近十家风险基金和数家资金量雄厚的地产、实业集团达成战略协议，并力图基于这些合作伙伴，为并购交易提供最稳健的服务保证。</p>
                    </div>
                </div>
                <div class="col-4 slide">
                    <div class="title">跨领域的初创公司洞见</div>
                    <div class="content">
                        <p>我们的核心团队来自中国最顶尖的互联网公司、初创公司以及战略咨询公司，并与中国最优秀的互联网公司、投资基金、FA达成顾问合作，我们了解科技的价值。</p>

                        <p>基于核心团队以及顾问的行业经验，我们提供对各领域以及个资产领域最精确的洞见和最深入的研究，为交易提供价值驱动。</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="case" class="section case ">
            <div class="case-container js-load">
                <div class="col-4">
                    <div class="case-img">
                        <img src="{{asset('/frontend/images/img_05.png')}}" alt="">
                    </div>
                    <div class="case-desc">
                        A公司将
                        <span class="sp">微信和微博</span>
                        等社交媒体资产出售给B公司
                    </div>
                </div>
                <div class="col-4">
                    <div class="case-img">
                        <img src="{{asset('/frontend/images/img_06.png')}}" alt="">
                    </div>
                    <div class="case-desc">
                        C公司将一个
                        <span class="sp">iOS技术团队</span>
                        出售给D公司
                    </div>
                </div>
                <div class="col-4">
                    <div class="case-img">
                        <img src="{{asset('/frontend/images/img_07.png')}}" alt="">
                    </div>
                    <div class="case-desc">
                        E公司将一个
                        <span class="sp">Android应用</span>
                        出售给F公司
                    </div>
                </div>
            </div>
        </div>

        <div id="about" class="section about ">
            <div class="about-container js-load">
                <div class="about-desc">
                    我们的团队来自互联网、咨询、投资行业，获得过知名加速器、风险投资基金、地产基金的注资，希望可以对互联网创业公司的集合整理为更多的创业者提供更好更迅速的创业支持。
                </div>
                <div class="about-contact">
                    <div class="col-4">
                        <div class="about-contact-img">
                            <img src="{{asset('/frontend/images/img_email.svg')}}" alt="">
                        </div>
                        <div class="about-contact-text">
                            <a href="mailto:talk@leancaptial.vc">
                                talk@leancaptial.vc
                            </a>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="about-contact-img">
                            <img src="{{asset('/frontend/images/img_weixin.svg')}}" alt="">
                        </div>
                        <div class="about-contact-text">
                            leancapital
                        </div>
                        <div class="about-contact-qrcode">
                            <img src="{{asset('/frontend/images/lean_qrcode.jpg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="about-contact-img">
                            <img src="{{asset('/frontend/images/img_phone.svg')}}" alt="">
                        </div>
                        <div class="about-contact-text">
                            400-9219-801
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="footer" class="section footer ">
            <div class="footer-logo js-load"></div>
            <p>
                <span>发</span><span>掘</span><span>科</span><span>技</span><span>的</span><span>价</span><span>值</span>
            </p>
            <div class="copyright">
                &copy; 精益资本. All Rights Reserved. 沪ICP备13021804号
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('/frontend/libs/jquery.fullPage.min.js')}}"></script>
    <script src="{{asset('/frontend/js/index.js')}}"></script>
@endsection