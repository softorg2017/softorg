{{--<!-- START: 优势 -->--}}
<section class="module-container bg-dark" id="home-property-for-rent-listing">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _blod">Coverage</div>
            <div class="wow slideInRight module-subtitle-row title-sm">coverage-description</div>
        </header>


        <div class="module-row module-body-container root-slider">
            @foreach($items as $v)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6 item-col">
                    <div class="item-container padding-8px">

                        <figure class="image-container padding-top-3-5">
                            <div class="image-box">
                                <a class="clearfix zoom-" target="_blank"  href="{{ url('/item/'.$v->id) }}">
                                    <img class="grow" data-action="zoom-" src="{{ url(env('DOMAIN_CDN').'/'.$v->cover_pic) }}" alt="Image">
                                </a>
                                {{--<span class="btn btn-warning">热销中</span>--}}
                            </div>
                        </figure>

                        <figure class="text-container clearfix">
                            <div class="text-box">
                                <div class="text-title-row multi-ellipsis-1"><a href="{{ url('/item/'.$v->id) }}"><b>{{ $v->title or '' }}</b></a></div>
                                <div class="text-description-row _none">
                                    <div>
                                        <i class="fa fa-cny"></i> <span class="font-18px color-red"><b>{{ $v->custom->price or '' }}</b></span>
                                    </div>
                                    <div>
                                        <span class="property-location"><i class="fa fa-map-marker"></i> 14 Tottenham Road, London</span>
                                    </div>
                                    {{--<span><i class="fa fa-arrows-alt"></i> 3060 SqFt</span>--}}
                                    {{--<span><i class="fa fa-bed"></i> 3 Beds</span>--}}
                                    {{--<span><i class="fa fa-bathtub"></i> 3 Baths</span>--}}
                                    {{--<span><i class="fa fa-cab"></i> Yes</span>--}}
                                </div>
                            </div>
                            <div class="text-box with-border-top text-right clearfix">
                                <a target="_blank" href="{{ url('/item/'.$v->id) }}">
                                    <button class="btn btn-default btn-3d btn-clicker" data-hover="点击查看" style="border-radius:0;">
                                        <strong>查看详情</strong>
                                    </button>
                                </a>
                            </div>
                        </figure>

                    </div>
                </div>
            @endforeach
        </div>


        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/') }}" class="view-more">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>


    </div>
</section>
{{--<!-- END -->--}}