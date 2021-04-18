{{--main--}}
<section class="section-container bg-light bg-f">
    <div class="row">

        <header class="module-row module-header-container with-border-bottom text-center">
            <div class="wow slideInLeft module-title-row title-md _bold">{{ $data->title or '' }}</div>
            <div class="wow slideInRight module-subtitle-row title-sm">section-header-info-description</div>
            <a class="module-subtitle-row pull-right print-btn" href="javascript:void(0);">浏览 ({{ $data->visit_num or '' }}) 次</a>
        </header>

        <div class="module-row module-body-container property-single-meta">

            <div class="col-sm-5 col-xs-12 pull-right" style="margin: 8px 0">
                <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$data->cover_pic }}" alt="Agent Image">
            </div>
            <div class="col-sm-7 col-xs-12 pull-left" style="margin: 8px 0">

                <ul class="clearfix">
                    <li>
                        <span>租金 :</span>
                        <span class="custom-average"><b>{{ $data->custom->price or '' }}</b></span>
                        <a class="show-modal-item" href="javascript:void(0);">资讯价格</a>
                    </li>
                    <li>
                        <span>押金 :</span>
                        <span><b>{{ $data->custom->deposit or '' }}</b></span>
                        {{--<a class="show-modal-jg" href="javascript:void(0);">获取最新价格变动</a>--}}
                    </li>
                    <li><span>品牌 :</span> {{ $data->custom->brand or '' }} </li>
                    <li><span>型号 :</span> {{ $data->custom->model or '' }} </li>
                </ul>

                <!--免费专车-->
                <div class="row _none">
                    <div class="free-car">
                        <div class="car-top">
                            <p class="tit"><b>免费专车</b></p>
                            <p class="describe">全城免费专车接送看房，人均节省<span class="num">827元</span>路费</p>
                        </div>
                        <div class="car-bottom">
                            <a class="ticket show-modal-zc" href="javascript:void(0);" data-toggle="modal-" data-target="#grab-modal">
                                <i class="fa fa-car"></i> <b>抢专车券</b>
                            </a> &nbsp; &nbsp;
                            <span class="num">{{ $ticket_total or 257 }}人</span>已抢
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</section>
<style>
    .property-single-meta .custom-average { color: #ff6d6f; font-size: 24px; }
    .property-single-meta ul li a { padding:4px 8px; margin-left:8px; border-radius: 2px; border: 1px solid #ff6d6f; color: #ff6d6f; font-size:12px; }
</style>
<style>
    .free-car { width:100%; border: 1px solid #eee; padding: 16px; margin-top: 16px; border-radius: 4px; z-index: 1000; }
    .free-car .car-top { width:auto; padding: 8px 0; border-bottom: 1px solid #f4f4f4; }
    .free-car .car-bottom { width:auto; padding: 8px 0; margin: 16px 0 8px; }
    .free-car .num { color: #ff6d6f; }
    .free-car .ticket { padding: 12px 24px; border-radius: 2px; font-size:20px; color: #ff6d6f; border: 2px solid #ff6d6f; }
    .free-car .ticket:hover { color: #22f3ae; border: 2px solid #22f3ae; }
</style>