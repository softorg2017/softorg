<div class="right-piece- box-body bg-white margin-bottom-4px section-user radius-2px">

    <div class="item-container">
        <div class="panel-default box-default item-portrait-container">
            <a target="_blank" href="{{ url('/user/'.$data->id) }}">
                <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
            </a>
        </div>

        <div class="panel-default- box-default item-entity-container with-portrait">
            <div class="item-row item-title-row text-muted">
                <span class="item-user-portrait _none">
                    <img src="{{ url(env('DOMAIN_CDN').'/'.$data->portrait_img) }}" alt="">
                </span>
                <span class="item-user-name">
                    <b><a href="{{ url('/user/'.$data->id) }}" class="text-hover-red font-sm">{{ $data->username or '' }}</a></b>
                </span>
            </div>
            <div class="item-row item-info-row text-muted">
                <span class="">粉丝 {{ $data->fans_num or 0 }}</span>
                <span class="">•</span>
                <span class="">访问 {{ $data->visit_num or 0 }}</span>
                {{--<span class="info-tags text-danger">作者</span>--}}
            </div>
        </div>

        <div class="item-row item-info-row">

            @if(!empty($data->email))
            <div class="margin-4px">
                <i class="fa fa-envelope text-primary"></i>
                <span class="text-muted">{{ $data->email or '暂无' }}</span>
            </div>
            @endif
            @if(!empty($data->QQ_number))
            <div class="margin-4px">
                <i class="fa fa-qq text-primary"></i>
                @if(!empty($data->QQ_number))
                    <a class="" href="tencent://message/?uin={{ $data->QQ_number }}">
                        {{ $data->QQ_number or '暂无' }}
                    </a>
                @else
                    <span class="text-muted">{{ $data->QQ_number or '暂无' }}</span>
                @endif
            </div>
            @endif
            @if(!empty($data->wechat_id))
            <div class="margin-4px">
                <i class="fa fa-weixin text-primary"></i>
                <span class="text-muted">{{ $data->wechat_id or '暂无' }}</span>
            </div>
            @endif
            @if(!empty($data->contact_address))
            <div class="margin-4px">
                <i class="fa fa-map-marker text-primary"></i>
                <span class="text-muted">{{ $data->contact_address or '暂无' }}</span>
            </div>
            @endif
            @if(!empty($data->website))
            <div class="margin-4px">
                <i class="fa fa-globe text-primary"></i>
                @if(!empty($data->website))
                    <a target="_blank" href="{{ $data->website or '' }}">
                        {{ $data->website or '暂无' }}
                    </a>
                @else
                    <span class="text-muted">{{ $data->website or '暂无' }}</span>
                @endif
            </div>
            @endif
            <div class="margin-4px">
                <i class="fa fa-user text-orange"></i>
                <span class="text-muted">{{ $data->linkman or '暂无' }}</span>
            </div>
            <div class="margin-4px">
                <i class="fa fa-phone text-danger"></i>
                <span class="text-muted">
                    <a href="tel:{{ $u->linkman_phone or '' }}">
                        {{ $data->linkman_phone or '暂无' }}
                    </a>
                </span>
            </div>
            <div class="margin-4px">
                <i class="fa fa-weixin text-success"></i>
                <span class="text-muted">{{ $data->linkman_wechat_id or '暂无' }}</span>
            </div>
        </div>

        @if(!Auth::check())
        <div class="item-row">
            <div class="tool-inn tool-info follow-add follow-add-it" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                <i class="fa fa-plus"></i>
                <span class="">关注</span>
            </div>
        </div>
        @else
            @if(Auth::user()->id != $data->id)
            <div class="item-row">
                @if($is_follow)
                <div class="tool-inn tool-info follow-remove follow-remove-it" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                    <i class="fa fa-check"></i>
                    <span class="">已关注</span>
                </div>
                @else
                <div class="tool-inn tool-info follow-add follow-add-it" style="width:100%;text-align:center;" data-user-id="{{ $data->id }}">
                    <i class="fa fa-plus"></i>
                    <span class="">关注</span>
                </div>
                @endif
            </div>
            @endif
        @endif

    </div>

</div>


<div class="box-body bg-white margin-bottom-8px _none">

    <div class="margin">
        <i class="fa fa-user text-orange"></i>
        <b>{{ $data->username or '' }}</b>
    </div>

</div>