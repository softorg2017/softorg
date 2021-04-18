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
                    <span> • 文章 {{ $u->relation_user->article_count }}</span>
                    <span> • 活动 {{ $u->relation_user->activity_count }}</span>
                </div>

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