{{--house-detail--}}
<div class="module-container" id="property-single">
    <div class="container main-container">

            {{--头部信息--}}
            @include(env('TEMPLATE_GPS').'developing.module.section-header-info', ['data'=>$data])

            {{--基本信息--}}
            @include(env('TEMPLATE_GPS').'developing.module.section-information', ['data'=>$data])

            {{--最新动态--}}
            {{--@include(env('TEMPLATE_GPS').'developing.module.section-recent-news', ['data'=>$data])--}}

            {{--图片展示--}}
            {{--@include(env('TEMPLATE_GPS').'developing.module.section-images', ['data'=>$data])--}}

            {{--图文详情--}}
            @include(env('TEMPLATE_GPS').'developing.module.section-detail', ['data'=>$data,'title_is'=>0])

            {{--视频展示--}}
            {{--@include(env('TEMPLATE_GPS').'developing.module.section-video')--}}

            {{--地图--}}
            {{--@include(env('TEMPLATE_GPS').'developing.module.section-map')--}}

            {{--经纪人--}}
            {{--@include(env('TEMPLATE_GPS').'developing.module.section-agent')--}}

            @include(env('TEMPLATE_GPS').'developing.module.section-block-bar', ['items'=>$items])

    </div>
</div>