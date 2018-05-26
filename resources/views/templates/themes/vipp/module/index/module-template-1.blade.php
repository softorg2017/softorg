<div class="row full wrapper-module-container module-template {{ $style or '' }}">
    <div class="col-md-14">
        <div class="row full block-in">


            <div class="module-header-container wow fadeInUp" data-wow-delay=".2s">
                <span class="menu-title"><b>网站模板</b></span>
            </div>

            <div class="module-block-container rectangle-col-4 wow fadeInUp" data-wow-delay=".4s">

                @foreach($datas as $v)
                <a target="_blank" href="{{ url('/website/template/'.encode($v->id)) }}">
                    <div class="rectangle-container grow">
                        <div class="before-box before-3-4">
                            <div class="before-inner">
                                <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                            </div>
                        </div>
                        <div class="before-outer">
                            <div class="height-40px line-48px row-ellipsis">
                                <b>{{ $v->title or '' }}</b>
                            </div>
                        </div>
                    </div>
                </a>
                @endforeach

            </div>

            <div class="module-footer-container">
                <a href="{{ '/website/templates' }}" class="view-more visible-xs- btn-md btn-more">更多</a>
            </div>


        </div>
    </div>
</div>
