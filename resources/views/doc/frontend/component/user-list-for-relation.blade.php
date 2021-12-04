@foreach($user_list as $u)
<div class="a-piece a-option user-piece user-option user margin-bottom-8px radius-2px"
     data-user="{{ $u->relation_user->id or 0 }}"
     data-type="{{ $u->relation_type or 0 }}"
>
    <div class="panel-default box-default item-entity-container">

        <div class="item-table-box">

            <div class="item-left-box">
                <a href="{{ url('/user/'.$u->relation_user->id) }}">
                    <img class="media-object" src="{{ url(env('DOMAIN_CDN').'/'.$u->relation_user->portrait_img) }}">
                </a>
            </div>

            <div class="item-right-box">

                <div class="item-row item-title-row">

                    <a href="{{ url('/user/'.$u->relation_user->id) }}">
                        <b>{{ $u->relation_user->username or '' }}</b>
                    </a>

                    @if(Auth::check() && $u->relation_user_id != Auth::user()->id)

                        <span class="tool-inn tool-set _none"><i class="fa fa-cog"></i></span>

                        @if($u->relation_type == 21)
                            <span class="tool-inn tool-info follow-remove follow-remove-it"><i class="fa fa-exchange"></i> 相互关注</span>
                        @elseif($u->relation_type == 41)
                            <span class="tool-inn tool-info follow-remove follow-remove-it"><i class="fa fa-check"></i> 已关注</span>
                        @elseif($u->relation_type == 71)
                            <span class="tool-inn tool-info follow-add follow-add-it"><i class="fa fa-plus text-yellow"></i> 关注</span>
                        @else
                            <span class="tool-inn tool-info follow-add follow-add-it"><i class="fa fa-plus text-yellow"></i> 关注</span>
                        @endif

                        <div class="tool-menu-list _none" style="z-index:999;">
                            <ul>
                                @if(in_array($u->relation_type, [21,41]))
                                    <li class="follow-remove-it" role="button"><i class="fa fa-minus"></i> 取消关注</li>
                                @endif
                                @if(in_array($u->relation_type, [21,71]))
                                    <li class="fans-remove-it" role="button"><i class="fa fa-minus"></i> 移除粉丝</li>
                                @endif
                            </ul>
                        </div>

                    @endif

                </div>

                <div class="item-row item-info-row">
                    <span>粉丝 {{ $u->relation_user->fans_num }}</span>
                    {{--<span> • 内容 {{ $u->relation_user->item_count }}</span>--}}
                    {{--<span> • 文章 {{ $u->relation_user->article_count }}</span>--}}
                    {{--<span> • 活动 {{ $u->relation_user->activity_count }}</span>--}}
                    <span> • 访问 {{ $u->relation_user->visit_num }}</span>
                </div>

                {{--Email--}}
                @if(!empty($u->relation_user->email))
                    <div class="item-row item-info-row">
                        <i class="fa fa-envelope text-primary" style="width:16px;"></i>
                        <span class="text-muted">{{ $u->relation_user->email or '暂无' }}</span>
                    </div>
                @endif
                {{--QQ--}}
                @if(!empty($u->relation_user->relation_user->QQ_number))
                    <div class="item-row item-info-row">
                        <i class="fa fa-qq text-primary" style="width:16px;"></i>
                        <a target="_blank" href="tencent://message/?uin={{ $u->relation_user->QQ_number }}">
                            {{ $u->QQ_number or '暂无' }}
                        </a>
                    </div>
                @endif
                {{--微信号--}}
                @if(!empty($u->relation_user->wechat_id))
                            <div class="item-row item-info-row">
                                <i class="fa fa-weixin text-success" style="width:16px;"></i>
                                <span class="text-muted">{{ $u->relation_user->wechat_id or '暂无' }}</span>
                                @if(!empty($u->relation_user->wechat_qr_code_img))
                                    <a class="lightcase-image" href="{{ url(env('DOMAIN_CDN').'/'.$u->relation_user->wechat_qr_code_img) }}">
                                        <i class="fa fa-qrcode text-danger" style="width:16px;font-weight:500;"></i>
                                    </a>
                                @endif
                            </div>
                        </a>
                @endif
                {{--网站--}}
                @if(!empty($u->relation_user->website))
                    <div class="item-row item-info-row">
                        <i class="fa fa-globe text-primary" style="width:16px;"></i>
                        <a target="_blank" href="{{ $u->relation_user->website or '' }}">
                            {{ $u->relation_user->website or '暂无' }}
                        </a>
                    </div>
                @endif
                {{--联系人姓名--}}
                @if(!empty($u->relation_user->linkman_name))
                    <div class="item-row item-info-row">
                        <i class="fa fa-user text-orange" style="width:16px;"></i>
                        <span class="text-muted">{{ $u->relation_user->linkman_name or '暂无' }}</span>
                    </div>
                @endif
                {{--联系人电话--}}
                @if(!empty($u->relation_user->linkman_phone))
                    <div class="item-row item-info-row">
                        <i class="fa fa-phone text-danger" style="width:16px;"></i>
                        <span class="text-muted">
                        <a href="tel:{{ $u->relation_user->linkman_phone or '' }}">
                            <strong>{{ $u->relation_user->linkman_phone or '暂无' }}</strong>
                        </a>
                    </span>
                    </div>
                @endif
                {{--联系人微信--}}
                @if(!empty($u->relation_user->linkman_wechat_id))
                    <div class="item-row item-info-row">
                        <i class="fa fa-weixin text-success" style="width:16px;"></i>
                        <span class="text-muted">{{ $u->relation_user->linkman_wechat_id or '暂无' }}</span>
                        @if(!empty($u->relation_user->linkman_wechat_qr_code_img))
                            <a class="lightcase-image" href="{{ url(env('DOMAIN_CDN').'/'.$u->relation_user->linkman_wechat_qr_code_img) }}">
                                <i class="fa fa-qrcode text-danger" style="width:16px;font-weight:500;"></i>
                            </a>
                        @endif
                    </div>
                @endif
                {{--地址--}}
                @if(!empty($u->relation_user->contact_address))
                    <div class="item-row item-info-row">
                        <i class="fa fa-map-marker text-primary" style="width:16px;"></i>
                        <span class="text-muted">{{ $u->relation_user->contact_address or '暂无' }}</span>
                    </div>
                @endif

                {{--@if(!empty($u->description))--}}
                <div class="item-row item-info-row">
                    {{ $u->relation_user->description or '暂无简介' }}
                </div>
                {{--@endif--}}

            </div>

        </div>

    </div>
</div>
@endforeach