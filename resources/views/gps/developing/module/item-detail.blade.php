{{--house-detail--}}
<div class="module-container" id="property-single">
    <div class="container main-container">

        <div class="col-lg-12 col-md-12 ">

            {{----}}
            {{--@include('frontend.module.section-header-info', ['data'=>$data])--}}

            {{----}}
            {{--@include('frontend.module.section-information', ['data'=>$data])--}}

            {{--最新动态--}}
            {{--@include('frontend.module.section-recent-news', ['data'=>$data])--}}

            {{--图片展示--}}
            {{--@include('frontend.module.section-images', ['data'=>$data])--}}

            {{--图文详情--}}
            @include('frontend.module.section-detail', ['data'=>$data,'title_is'=>1])

            {{--视频展示--}}
            {{--@include('frontend.module.section-video')--}}

            {{--地图--}}
            {{--@include('frontend.module.section-map')--}}

            {{--经纪人--}}
            {{--@include('frontend.module.section-agent')--}}

            @include('frontend.module.section-rent-out', ['items'=>$rent_items])

        </div>

    </div>
</div>

