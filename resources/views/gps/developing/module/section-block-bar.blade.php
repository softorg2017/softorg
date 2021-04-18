{{--<!-- START: module-link-contact -->--}}
<section class="section-container bg-light bg-f">
    <div class="row">

        <header class="module-row module-header-container with-border-bottom text-center">
            <div class="wow slideInLeft module-title-row title-md _bold">热门租琴</div>
            {{--<div class="wow slideInRight module-subtitle-row title-sm">Description-Left-Right-Bar</div>--}}
        </header>

        <div class="module-row module-body-container">
            @foreach($items as $v)
                <div class="col-lg-4 col-md-6 col-sm-6 item-col">
                    <a class="zoom- clearfix" target="_blank" href="{{ url('/item/'.$v->id) }}">
                        <div class="item-container model-left-right bg-grey-f5 item-col">

                            <figure class="image-container padding-top-1-4-">
                                <div class="image-box">
                                    <img data-action="zoom-" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="Property Image">
                                    {{--<span class="btn btn-warning">热销中</span>--}}
                                </div>
                            </figure>

                            <figure class="text-container">
                                <div class="text-box">
                                    <div class="text-title-row multi-ellipsis-1">
                                        <span class="multi-ellipsis-1 _bold">{{ $v->title or '' }}</span>
                                    </div>
                                    <div class="text-description-row">
                                        <div>
                                            <span>租金：<i class="fa fa-cny"></i></span>
                                            <span class="color-red">{{ $v->custom->price or '' }}</span>
                                        </div>
                                        <div>
                                            <span>押金：<i class="fa fa-cny"></i> </span>
                                            <span>{{ $v->custom->deposit or '' }} </span>
                                        </div>
                                    </div>
                                </div>
                            </figure>

                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/') }}" class="view-more">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>

    </div>
</section>
{{--<!-- END: module-link-contact -->--}}