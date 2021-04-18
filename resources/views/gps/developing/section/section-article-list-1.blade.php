{{--图片展示--}}
<section class="section-container article-list-container">
    <div class="row">

        <header class="module-row module-header-container border-bottom border-2px border-color-e6 text-center">
            <div class="wow slideInLeft module-title-row title-md _bold">Section-Article-1</div>
        </header>

        <div class="module-row module-body-container property-contents with-border-bottom-2px" id="">
            <ul>
                @foreach($items as $v)
                    <a href="{{ url('/item/'.$v->id) }}" class="content-lg">
                        <li class="wobble-horizontal">
                            <span class="title-inn pull-left row-ellipsis"><i class="fa fa-file-o"></i> {{ $v->title or '' }}</span>
                            <span class="time-inn pull-right text-right">11-27</span>
                        </li>
                    </a>
                @endforeach
            </ul>
        </div>

        <footer class="module-row module-footer-container border-top border-2px border-color-e6 content-lg text-center">
            <a class="print-btn" href="/">查看更多 <i class="fa fa-angle-double-right"></i></a>
        </footer>

    </div>
</section>