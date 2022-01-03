@foreach($user_list as $u)
<div class="item-piece item-wrapper a-option user-piece user-option user margin-bottom-4px radius-2px"
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
                        @if(!empty($u->relation_user->true_name))
                            <b>{{ $u->relation_user->true_name or '' }}</b>
                        @else
                            <b>{{ $u->relation_user->username or '' }}</b>
                        @endif
                    </a>

                    @if(Auth::check() && $u->relation_user_id != Auth::user()->id)

                        <span class="tool-inn tool-set _none"><i class="fa fa-cog"></i></span>

                        @if($u->relation_type == 21)
                            <span class="tool-inn tool-info follow-remove follow-remove-it"><i class="fa fa-exchange"></i> 相互收藏</span>
                        @elseif($u->relation_type == 41)
                            <span class="tool-inn tool-info follow-remove follow-remove-it"><i class="fa fa-check"></i> 已收藏</span>
                        @elseif($u->relation_type == 71)
                            <span class="tool-inn tool-info follow-add follow-add-it"><i class="fa fa-star-o text-yellow"></i> 收藏名片</span>
                        @else
                            <span class="tool-inn tool-info follow-add follow-add-it"><i class="fa fa-star-o text-yellow"></i> 收藏名片</span>
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

                @if(!empty($u->relation_user->company))
                <div class="item-row item-info-row-">
                    <span><b style="color:#444;">{{ $u->relation_user->company or '暂无' }}</b></span>
                    @if(!empty($u->relation_user->position))
                        / <span><b style="color:#666;">{{ $u->relation_user->position or '暂无' }}</b></span>
                    @endif
                </div>
                @endif

                <div class="item-row item-info-row">
                    <span>粉丝 {{ $u->relation_user->fans_num }}</span>
                    <span> • 访问 {{ $u->relation_user->visit_num }}</span>
                    {{--<span> • 文章 {{ $u->relation_user->article_count }}</span>--}}
                    {{--<span> • 活动 {{ $u->relation_user->activity_count }}</span>--}}
                </div>

                @if(!empty($u->relation_user->contact_phone))
                    <div class="item-row item-info-row">
                        <i class="fa fa-phone text-primary"></i>
                        <a href="tel:{{ $u->relation_user->contact_phone or '' }}">{{ $u->relation_user->contact_phone or '暂无' }}</a>
                    </div>
                @endif
                {{--邮箱--}}
                @if(!empty($u->relation_user->email))
                    <div class="item-row item-info-row">
                        <i class="fa fa-envelope text-primary"></i>
                        <span class="text-muted">{{ $u->relation_user->email or '暂无' }}</span>
                    </div>
                @endif
                {{--微信--}}
                @if(!empty($u->relation_user->wx_id))
                    <div class="item-row item-info-row">
                        @if(!empty($u->relation_user->wx_qr_code_img))
                            <a class="lightcase-image" href="{{ url(env('DOMAIN_CDN').'/'.$u->relation_user->wx_qr_code_img) }}">
                                <i class="fa fa-weixin text-primary"></i>
                                <span class="text-muted">{{ $u->relation_user->wx_id or '暂无' }}</span>
                                <i class="fa fa-qrcode text-danger" style="width:16px;font-weight:500;"></i>
                            </a>
                        @else
                            <i class="fa fa-weixin text-primary"></i>
                            <span class="text-muted">{{ $u->relation_user->wx_id or '暂无' }}</span>
                        @endif
                    </div>
                @endif
                {{--QQ--}}
                @if(!empty($u->relation_user->QQ_number))
                    <div class="item-row item-info-row">
                        <i class="fa fa-qq text-primary"></i>
                        <a class="" href="tencent://message/?uin={{ $u->relation_user->QQ_number }}">
                            {{ $u->relation_user->QQ_number or '暂无' }}
                        </a>
                    </div>
                @endif
                {{--微博--}}
                @if(!empty($u->relation_user->wb_name))
                    <div class="item-row item-info-row">
                        @if(!empty($u->relation_user->wb_address))
                            <a target="_blank" href="{{ $u->relation_user->wb_address }}">
                                <i class="fa fa-wb text-primary"></i>
                                <span class="">{{ $u->relation_user->wb_name or '暂无' }}</span>
                            </a>
                        @else
                            <i class="fa fa-wb text-primary"></i>
                            <span class="text-muted">{{ $u->relation_user->wb_name or '暂无' }}</span>
                        @endif
                    </div>
                @endif


                @if(!empty($u->description))
                <div class="item-row item-info-row">
                    {{ $u->relation_user->description or '暂无简介' }}
                </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endforeach