{{--banner--}}
<div class="row full has-fold- banner">
    <div class="col-xs-14">

        <div class="hero-product-container">
            <div class="hero-product-container-xs">
            </div>
            <div class="hero-product-description" fade-onload>

                <div class="banner-row banner-heading-top"><p>@yield('banner-heading-top')</p></div>
                <div class="banner-row banner-heading-center"><p><b>@yield('banner-heading')</b></p></div>
                <div class="banner-row banner-heading-bottom"><p>@yield('banner-heading-bottom')</p></div>

                <div class="banner-row banner-box">
                    <a href="#" class="btn-md btn-md-l"><span>Our Service</span></a>
                    <a href="#contact" class="btn-md btn-md-r"><span>Contact Us</span></a>
                </div>
            </div>
        </div>

        <div class="banner-canvas">
        </div>

        {{--<script>--}}
            {{--initialise(".banner-canvas");--}}
        {{--</script>--}}

    </div>
</div>