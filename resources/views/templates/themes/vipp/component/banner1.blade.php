{{--banner--}}
<div class="row full has-fold- banner1">
    <div class="col-xs-14">
        <div class="hero-product-container" style="padding-top: 60vh">
            <div class="hero-product-container-xs">
            </div>
            <div class="hero-product-description white" fade-onload>

                <div class="banner-row banner-heading-top"><p>@yield('banner-heading-top')</p></div>
                <div class="banner-row banner-heading-center"><p><b>@yield('banner-heading')</b></p></div>
                <div class="banner-row banner-heading-bottom"><p>@yield('banner-heading-bottom')</p></div>

                <div class="banner-row banner-box">
                    <a href="{{url(config('common.org.front.index').'/'.$org->website_name) }}" class="btn-md btn-md-l"><span>返回首页</span></a>
                    <a href="#contact" class="btn-md btn-md-r"><span>联系我们</span></a>
                </div>

                {{--<h4>@yield('banner-h4')</h4>--}}
                {{--<h1 class="hero-heading">@yield('banner-h1')</h1>--}}
                {{--<div style="margin-bottom:32px;"><p>@yield('banner-h4')</p></div>--}}
                {{--<a href="javascript:void(0);" class="btn-md btn-md-l"><span>@yield('banner-a')</span></a>--}}
                {{--<a href="#product" class="btn-md btn-md-l"><span>返回首页</span></a>、--}}
                {{--<a href="#contact" class="btn-md btn-md-r"><span>联系我们</span></a>--}}
            </div>
        </div>
    </div>
</div>