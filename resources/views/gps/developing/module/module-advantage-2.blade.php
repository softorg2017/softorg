{{--<!-- START: 优势 -->--}}
<section class="module-container text-center bg-dark bg-pink-1">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Module-Advantage-2</div>
            <div class="wow slideInRight module-subtitle-row title-sm">module-advantage-2-description</div>
        </header>


        <div class="module-row module-body-container">
            @foreach($items as $v)
                <div class="col-md-4 col-sm-6 item-col">
                    <div class="item-container padding-8px">

                        <figure class="image-container padding-top-1-2">
                            <div class="image-box">
                                <a class="clearfix zoom-" target="_blank"  href="{{ url('/item/'.$v->id) }}">
                                    <img class="grow" data-action="zoom-" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="Property Image">
                                </a>
                                {{--<span class="btn btn-warning">热销中</span>--}}
                            </div>
                        </figure>

                        <figure class="text-container clearfix">
                            <div class="text-box">
                                <div class="text-title-row multi-ellipsis-1" title="{{ $v->title or '' }}">
                                    <a href="{{ url('/item/'.$v->id) }}" class="multi-ellipsis-1 content-lg _bold">{{ $v->title or '' }}</a>
                                </div>
                            </div>
                            <div class="text-box with-border-top text-center clearfix">
                                <a href="{{ url('/item/'.$v->id) }}" class="">
                                    <button class="btn btn-item-1 color-red-1 content-lg">了解更多</button>
                                </a>
                            </div>
                        </figure>

                    </div>
                </div>
            @endforeach
        </div>


        <footer class="module-row module-footer-container text-center">
            <div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <a href="javascript:void(0);" class="btn btn-lg btn-block btn-ghost btn-ghost-white view-more-2" role="button"> 查看更多 </a>
            </div>
        </footer>
        <footer class="module-row module-footer-container text-center">
            <div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <a href="javascript:void(0);" class="btn btn-lg btn-block btn-ghost btn-ghost-blue view-more-2" role="button"> 查看更多 </a>
            </div>
        </footer>


    </div>
</section>
{{--<!-- END -->--}}