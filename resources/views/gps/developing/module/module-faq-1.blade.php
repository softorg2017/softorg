
{{--<!-- START: module-faqs -->--}}
<section class="module-container text-center bg-light bg-f">
    <div class="container main-container">


        <header class="module-row module-header-container text-center">
            <div class="wow slideInLeft module-title-row title-with-double-line title-md _bold">Frequently Asked Questions</div>
            <div class="wow slideInRight module-subtitle-row title-sm">Frequently Asked Questions-description</div>
        </header>


        <div class="module-row module-body-container">

            <div class="bellows text-left">
                @foreach($items as $v)
                    <div class="bellows__item">
                        <div class="bellows__header">
                            <span class="title-xs">{{ $v->title or '' }}</span>
                        </div>
                        <div class="bellows__content">
                            {!! $v->content or '' !!}
                        </div>
                    </div>
                @endforeach
            </div>

        </div>


        <footer class="module-row module-footer-container text-center">
            <a href="{{ url('/') }}" class="view-more style-dark">查看更多 <i class="fa fa-hand-o-right"></i></a>
        </footer>


    </div>
</section>
{{--<!-- END -->--}}