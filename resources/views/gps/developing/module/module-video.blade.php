{{--<!-- START: module-link-contact -->--}}
<section class="module-container text-center bg-dark bg-pink-1" id="module-video">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Module-Video 视频</div>
            <div class="wow slideInRight module-subtitle-row title-sm">module-video-description</div>
        </header>


        <div class="module-row module-body-container ">
            <div class="col-md-4 col-md-offset-4 probootstrap-animate-">
                <p class="text-center">

                    <a class="btn btn-ghost btn-ghost-white btn-lg btn-block lightcase-video- _none" data-rel="lightcase" role="button"
                       href="">
                        <i class="fa fa-play-circle-o"></i>
                    </a>
                    <a class="btn btn-ghost btn-ghost-white btn-lg btn-block lightcase-video- _none" data-rel="lightcase" role="button"
                       href="" data-lc-options='{width:640, height:336, autoplay:false}'
                       data-lc-href="">
                        <i class="fa fa-play-circle-o"></i>
                    </a>


                    <a class="btn btn-ghost btn-ghost-white btn-lg btn-block _none" data-fancybox- data-width="640" data-height="336"
                       href="">
                        <i class="fa fa-play-circle-o"></i>
                    </a>
                    <a class="btn btn-ghost btn-ghost-white btn-lg btn-block" data-fancybox="" href="#myVideo">
                        <i class="fa fa-play-circle-o"></i>
                    </a>
                    <video width="720" height="416"  controls="true" controlslist="nodownload" id="myVideo" style="display:none;">
                        <source src="{{ asset('/custom/videos/xiaotang_01.mp4') }}" type="video/mp4">
                    </video>

                </p>
            </div>
        </div>


        <div class="module-row module-body-container bg-f">
            <div class="section-container">

                <figure class="text-container clearfix">
                    <div class="text-box clearfix text-center">
                        {{--<span class="title-sm">钢琴入门教学 小汤一</span>--}}
                        <div class="title-with-double-line border-lightgit  title-sm _bold">钢琴入门教学 小汤一</div>
                    </div>
                    <div class="text-box clearfix text-center">
                        @for($i=1; $i<31; $i++)
                            <div class="col-lg-1 col-md-1 col-sm-2 col-xs-3 button-col">
                                <a href="{{ url('/course/xiaotang01?id='.sprintf("%02d", $i)) }}">
                                    <button class="btn btn-default btn-3d" data-hover="点击查看">
                                        <strong>第{{ sprintf("%02d", $i) }}讲</strong>
                                    </button>
                                </a>
                            </div>
                        @endfor
                    </div>
                </figure>

            </div>
        </div>


        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/') }}" class="view-more" role="button">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>


    </div>
</section>
{{--<!-- END: module-link-contact -->--}}

<style>
    #module-video { background:url(/common/images/bg-11.jpg); background-size:cover; }
    #module-video:before { display:inline-block; content:" "; position:absolute; top:0; bottom:0; left:0; right:0; background:rgba(0,0,0,0.4);  z-index:0; }

    #module-video .fa-play-circle-o { font-size:64px; }

    #module-video .section-container { padding:16px; margin-bottom:16px; }
    #module-video .button-col { margin:0; padding:1px; }
    #module-video .btn { width:100%;height:100%; }

    @media (max-width: 767px) {
        #module-video .section-container { padding: 16px 8px; }
    }
</style>