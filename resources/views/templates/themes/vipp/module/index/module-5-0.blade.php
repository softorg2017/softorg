<div class="row full wrapper-module-container">
    <div class="col-md-14">
        <div class="row full block-all">

            <div class="swiper-container">
                <div class="swiper-wrapper">
                    @foreach(json_decode($data->img_multiple) as $v)
                        <div class="swiper-slide box1">
                            <a target="_blank" href="@if(!empty($v->link)) {{url($v->link)}} @else javascript:void(0) @endif">
                                <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- 如果需要分页器 -->
                <div class="swiper-pagination"></div>

                <!-- 如果需要导航按钮 -->
                {{--<div class="swiper-button-prev"></div>--}}
                {{--<div class="swiper-button-next"></div>--}}

                <!-- 如果需要滚动条 -->
                <!--<div class="swiper-scrollbar"></div>-->
            </div>

        </div>
    </div>
</div>
