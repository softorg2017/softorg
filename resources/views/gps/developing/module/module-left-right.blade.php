{{--<!-- START: module-service -->--}}
<section class="module-container bg-light" id="">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Module-Left-Right 左右结构</div>
            <div class="wow slideInRight module-subtitle-row title-sm">module-left-right-description</div>
        </header>


        <div class="module-row module-body-container">
            @foreach($items as $v)
                @if($loop->index < 2)
                <div class="row item-left-right-style">
                    <div class="col-md-6 col-sm-6 image-container">
                        <div class="image-box" role="button">
                            <img class="grow" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="Images">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 text-container">
                        <div class="text-box">
                            <div class="text-title-row title-sm color-blue _bold">
                                <a href="javascript:void(0);">{{ $v->title or '' }}</a>
                            </div>
                            <div class="text-description-row content-lg">
                                {{ $v->subtitle or '' }}
                                module-left-right-subtitle 卡哇伊
                                module-left-right-subtitle 珠江
                                module-left-right-subtitle 雅马哈
                                module-left-right-subtitle
                                module-left-right-subtitle
                                module-left-right-subtitle
                            </div>
                            <a href="javascript:void(0);" class="btn btn-flat btn-primary">了解更多</a>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>


        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/rent-out/list') }}" class="view-more style-dark">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>
        <footer class="module-row module-footer-container text-center">
            <div class="col-xs-6 col-xs-offset-3 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">
                <a href="javascript:void(0);" class="btn btn-lg btn-block btn-ghost btn-ghost-blue view-more-2" role="button"> 查看更多 </a>
            </div>
        </footer>


    </div>
</section>
{{--<!-- END -->--}}