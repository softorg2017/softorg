@if(isset($item->owner->ad))
<div class="right-piece box-body block-full bg-white padding-0 margin-bottom-4px radius-4px">
    <div class="item-container bg-white">

        <figure class="image-container padding-top-2-5">
            <div class="image-box">
                <a class="clearfix zoom-" target="_self"  href="{{ url('/item/'.$item->id) }}">
                    <img class="grow" src="{{ env('DOMAIN_CDN').'/'.$item->cover_pic }}" alt="Property Image" style="border-radius:8px 8px 0 0;">
                    {{--@if(!empty($item->cover_pic))--}}
                    {{--<img class="grow" src="{{ url(env('DOMAIN_CDN').'/'.$item->cover_pic) }}">--}}
                    {{--@else--}}
                    {{--<img class="grow" src="{{ url('/common/images/notexist.png') }}">--}}
                    {{--@endif--}}
                </a>
                {{--<span class="btn btn-warning">热销中</span>--}}
                <span class="paste-tag-inn info-tags text-danger">该组织•贴片广告</span>
            </div>
        </figure>

        <figure class="text-container clearfix">

            <div class="text-box">

                <div class="text-row text-title-row multi-ellipsis-1" style="padding:4px 0;">
                    <a href="{{ url('/item/'.$item->id) }}"><b>{{ $item->title or '' }}</b></a>
                </div>

                @if(!empty($item->description))
                    <div class="item-row text-description-row margin-bottom-4px">
                        <small class="color-red-">{{ $item->description or '' }}</small>
                    </div>
                @endif

                <div class="text-row text-title-row multi-ellipsis-1 _none">
                    <span class="info-tags text-danger">该组织•贴片广告</span>
                </div>

                <div class="text-title-row multi-ellipsis-1 with-border-top _none-" style="display:none;">
                    <a href="{{ url('/org/'.$item->id) }}" style="color:#ff7676;font-size:13px;">
                        <img src="{{ url(env('DOMAIN_CDN').'/'.$item->cover_pic) }}" class="title-portrait" alt="">
                        <b>{{ $item->title or '' }}</b>
                    </a>
                </div>

            </div>

            <div class="text-box with-border-top text-center clearfix _none">
                <a target="_self" href="{{ url('/item/'.$item->id) }}">
                    <button class="btn btn-default btn-flat btn-3d btn-clicker" data-hover="点击查看" style="border-radius:0;">
                        <strong>查看详情</strong>
                    </button>
                </a>
            </div>

        </figure>

    </div>
</div>
@endif