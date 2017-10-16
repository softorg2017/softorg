@extends('front.'.config('common.view.front.template').'.layout.app')

@section('css')
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/frontend/css/list_1.0.0.css')}}">
@endsection

@section('content')
    @include('front.'.config('common.view.front.template').'.layout.header')

    <div class="list-banner mask"></div>
    <section id="portfolio">
        <div class="container-fluid masonry-wrapper scrollimation fade-in in">
            <div id="projects-container" class="masonry">

                @yield('data-content')

            </div>
        </div>
    </section>

    @include('front.'.config('common.view.front.template').'.layout.footer')

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