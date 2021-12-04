@foreach($ad_list as $item)
<div class="right-piece box-body block-full bg-white margin-bottom-4px radius-4px pull-right">

    <div class="item-container">

        @if(!empty($item->cover_pic))
        <figure class="image-container padding-top-1-2">
            <div class="image-box">
                <a class="clearfix zoom-" target="_self"  href="{{ url('/item/'.$item->id) }}">
                    <img class="grow" src="{{ env('DOMAIN_CDN').'/'.$item->cover_pic }}" alt="Property Image">
                    {{--@if(!empty($item->cover_pic))--}}
                    {{--<img class="grow" src="{{ url(env('DOMAIN_CDN').'/'.$item->cover_pic) }}">--}}
                    {{--@else--}}
                    {{--<img class="grow" src="{{ url('/common/images/notexist.png') }}">--}}
                    {{--@endif--}}
                </a>
                {{--<span class="btn btn-warning">热销中</span>--}}
            </div>
        </figure>
        @endif

        <div class="text-container">

            <div class="item-row">

                <div class="item-row text-title-row multi-ellipsis-1">
                    <a href="{{ url('/item/'.$item->id) }}"><b>{{ $item->title or '' }}</b></a>
                </div>

                @if(!empty($item->description))
                    <div class="item-row text-description-row margin-bottom-4px">
                        <small class="color-red-">{{ $item->description or '' }}</small>
                    </div>
                @endif

                <div class="item-row text-info-row text-muted">
                    <span class="info-tags text-danger">{{ $ad_tag or '该组织•贴片广告' }}</span>
                </div>

                <div class="item-row text-title-row multi-ellipsis-1 with-border-top _none-" style="display:none;">
                    <a href="{{ url('/org/'.$item->id) }}" style="color:#ff7676;font-size:13px;">
                        <img src="{{ url(env('DOMAIN_CDN').'/'.$item->cover_pic) }}" class="title-portrait" alt="">
                        <b>{{ $item->title or '' }}</b>
                    </a>
                </div>

            </div>

            <div class="item-row text-box with-border-top text-center clearfix _none">
                <a target="_self" href="{{ url('/item/'.$item->id) }}">
                    <button class="btn btn-default btn-flat btn-3d btn-clicker" data-hover="点击查看" style="border-radius:0;">
                        <strong>查看详情</strong>
                    </button>
                </a>
            </div>

        </div>

    </div>

</div>
@endforeach