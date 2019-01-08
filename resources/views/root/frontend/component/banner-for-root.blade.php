{{--banner--}}
<div class="banner-container main-slider-wrapper clearfix">
    <div class="banner-slider-container">
        <div class="banner-slider-box" id="main-slider">
                <div class="slide"><img src="{{ url('/common/images/banner1.jpg') }}" alt="Slide"></div>
                <div class="slide"><img src="{{ url('/templates/moban2030/assets/images/slider/1.jpg') }}" alt="Slide"></div>
                {{--<div class="slide"><img src="{{ url('/templates/moban2030/assets/images/slider/2.jpg') }}" alt="Slide"></div>--}}
                {{--<div class="slide"><img src="{{ url('/templates/moban2030/assets/images/slider/3.jpg') }}" alt="Slide"></div>--}}
                {{--<div class="slide"><img src="{{ url('/templates/moban2030/assets/images/slider/4.jpg') }}" alt="Slide"></div>--}}
        </div>
    </div>
    <div id="slider-contents">
        <div class="container text-center">
            <div class="jumbotron">
                <h1>{{ config('company.info.name') }}</h1>
                <div class="contents clearfix">
{{--                    <p class="font-24px"><b>{{ config('company.info.slogan') }}</b></p>--}}
                </div>
                <a class="btn btn-warning btn-lg btn-3d" data-hover="联系我们" href="{{ url('/contact') }}" role="button">联系我们</a>
                <a class="btn btn-default btn-border btn-lg" href="javascript:void(0);" role="button">Get a Quote</a>
            </div>
        </div>
    </div>
</div>