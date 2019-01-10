{{--main--}}
<section class="module-container bg-light">
    <div class="container main-container">

        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line color-1 border-light title-h2"><b>我们的客户</b></div>
            <div class="wow slideInRight module-subtitle-row color-5 title-h4 _none"><b>description-client-1</b></div>
        </header>

        <div class="module-row module-body-container">
            <div class="cooperation-container">
                @foreach($items as $v)
                    <div class="cooperation-item" role="button">
                        <div class="cooperation-item-box pulse">
                            <a target="_blank" href="{{ $v->link_url or 'javascript:void(0);' }}">
                                <img class="" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="{{ $v->title or '' }}">
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/rent-out/list') }}" class="view-more style-dark">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>

    </div>
</section>