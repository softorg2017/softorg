{{--<!-- START: 优势 -->--}}
<section class="module-container bg-light bg-grey" id="">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Article List</div>
            <div class="wow slideInRight module-subtitle-row title-sm">article-list-description</div>
        </header>


        <div class="module-row module-body-container section-block-container bg-f">

            <div>
                <div class="col-lg-4 col-md-4 col-sm-6 item-col">
                    <section class="section-container article-image-container">
                        <img data-action="zoom-" src="{{ url(config('company.info.wechat_qrcode')) }}" alt="Property Image">
                    </section>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 item-col">
                    @include(env('TEMPLATE_GPS').'developing.section.section-article-list-1', ['items'=>$items])
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 item-col">
                    @include(env('TEMPLATE_GPS').'developing.section.section-article-list-2', ['items'=>[]])
                </div>
            </div>

            <div>
                <div class="col-lg-4 col-md-4 col-sm-6 item-col">
                    @include(env('TEMPLATE_GPS').'developing.section.section-article-list-1', ['items'=>$items])
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 item-col">
                    @include(env('TEMPLATE_GPS').'developing.section.section-article-list-2', ['items'=>$items])
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6 item-col">
                    @include(env('TEMPLATE_GPS').'developing.section.section-article-list-2', ['items'=>$items])
                </div>
            </div>

        </div>


    </div>
</section>
{{--<!-- END -->--}}