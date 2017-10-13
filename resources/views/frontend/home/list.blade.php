@extends('frontend.layouts.app')
@section('css')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/frontend/css/list_1.0.0.css')}}">
@endsection

@section('content')
    @include('frontend.layouts.header')
    <div class="list-banner mask"></div>
    <section id="portfolio">
        <div class="container-fluid masonry-wrapper scrollimation fade-in in">
            <div id="projects-container" class="masonry">
                <a href="{{route('frontend.detail')}}" class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">途家盛捷服务公寓</h2>
                        <p>品牌（LOGO/VI）</p>
                    </div>
                    <div class="sr-only project-description">
                        品牌（LOGO/VI）
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">MODELAB/爱慕内衣</h2>
                        <p>品牌（LOGO/VI）</p>
                    </div>
                    <div class="sr-only project-description">
                        品牌（LOGO/VI）
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">觉</h2>
                        <p>品牌（LOGO/VI）</p>
                    </div>
                    <div class="sr-only project-description">
                        品牌（LOGO/VI）
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">CNZCO兴宇中科</h2>
                        <p>品牌（LOGO/VI）</p>
                    </div>
                    <div class="sr-only project-description">
                        品牌（LOGO/VI）
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">同仁堂保健酒</h2>
                        <p>包装</p>
                    </div>
                    <div class="sr-only project-description">
                        包装
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">伊利乳品</h2>
                        <p>包装</p>
                    </div>
                    <div class="sr-only project-description">
                        包装
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">雀巢咖啡</h2>
                        <p>包装</p>
                    </div>
                    <div class="sr-only project-description">
                        包装
                    </div>
                </a>

                <a class="project-item masonry-brick"
                   data-images="{{asset('/frontend/images/bg_05.jpg')}}">
                    <img class="img-responsive project-image"
                         src="{{asset('/frontend/images/bg_05.jpg')}}" alt="">
                    <div class="hover-mask">
                        <h2 class="project-title">雀巢礼盒</h2>
                        <p>包装</p>
                    </div>
                    <div class="sr-only project-description">
                        包装
                    </div>
                </a>

            </div>
        </div>
    </section>
    @include('frontend.layouts.footer')

@endsection

@section('js')

    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://cdn.bootcss.com/masonry/4.2.0/masonry.pkgd.min.js"></script>
    <script>
        $(function () {
            $('body').addClass('fp-viewing-0');
            $(window).load(function(){
                $('#projects-container').css({visibility:'visible'});

                $('#projects-container').masonry({
                    itemSelector: '.project-item:not(.filtered)',
                    isFitWidth: true,
                    isResizable: true,
                    isAnimated: !Modernizr.csstransitions,
                    gutterWidth: 0
                });
                var portfolio = $('#portfolio');
                var portfolit_offsetTop = portfolio.offset().top - $('#nav').height();

                $(document).on('scroll',function(){
                    var win_scrollTop = $(window).scrollTop();
                    var size = win_scrollTop - portfolit_offsetTop;
                    if( size > 0){
                        $('#nav').addClass('black');
                        $('#nav_current').addClass('changed').children('a').html("@");
                    }else{
                        $('#nav').removeClass('black');
                        $('#nav_current').removeClass('changed').children('a').html("");
                    }

                });
            });
        })
    </script>

@endsection