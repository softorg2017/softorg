{{--<!-- START: 优势 -->--}}
<section class="module-container text-center bg-dark bg-grey-27">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Module-1-0</div>
            <div class="wow slideInRight module-subtitle-row title-sm">module-1-0-description</div>
        </header>


        <div class="module-row module-body-container">
            @foreach($items as $v)
                <div class="item-col col-lg-4 col-md-4 col-sm-6 col-xs-12" style="display: table-cell;">
                    <div class="item-container case-bin">
                        <a target="_blank" href="{{ url('/item/'.$v->id) }}">

                            <figure class="image-container padding-top-3-5">
                                <div class="image-box">
                                    <b></b>
                                    <img class="grow" data-action="zoom-" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="Property Image">
                                </div>
                            </figure>

                            <figure class="text-container clearfix">
                                <div class="text-box text-left">
                                    <div class="text-title-row multi-ellipsis-1" title="{{ $v->title or '' }}">
                                        <span class="_bold">{{ $v->title or '' }}</span>
                                    </div>
                                    <div class="text-description-row">
                                        <div>
                                            <span>租金：<i class="fa fa-cny"></i></span>
                                            <span class="color-red _bold">{{ $v->custom->price or '' }}</span>
                                        </div>
                                        <div>
                                            <span>押金：<i class="fa fa-cny"></i></span>
                                            <span>{{ $v->custom->deposit or '' }} </span>
                                        </div>
                                    </div>
                                </div>
                            </figure>
                        </a>

                    </div>
                </div>
            @endforeach
        </div>


        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/rent-out/list') }}" class="view-more style-dark">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>


    </div>
</section>
{{--<!-- END -->--}}