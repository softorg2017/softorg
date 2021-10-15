@foreach($notification_list as $num => $val)
<div class="a-piece a-option notification-piece notification-option margin-bottom-8px radius-2px" data-notification="{{ $val->id }}">
    <!-- BEGIN PORTLET-->
    <div class="panel-default box-default item-portrait-container hidden-xs-">
        <a href="{{ url('/user/'.$val->source->id) }}">
            <img src="{{ url(env('DOMAIN_CDN').'/'.$val->source->portrait_img) }}" alt="">
        </a>
    </div>

    <div class="panel-default box-default item-entity-container with-portrait">

        {{--header--}}
        <div class="item-row item-info-row text-muted">
            <span class="item-user-portrait visible-xs _none"><img src="{{ url(env('DOMAIN_CDN').'/'.$val->source->portrait_img) }}" alt=""></span>
            <span class="item-user-name"><a href="{{ url('/user/'.$val->source->id) }}"><b>{{ $val->source->username or '' }}</b></a></span>

            <span style="margin-left:4px;">
                @if($val->notification_category == 11)
                    @if($val->notification_type == 0)
                    @elseif($val->notification_type == 1)
                        评论了你的内容
                    @elseif($val->notification_type == 2)
                        回复了你
                    @elseif($val->notification_type == 3)
                        回复评论
                    @elseif($val->notification_type == 4)
                        点赞了你的评论
                    @elseif($val->notification_type == 5)
                        点赞评论
                    @elseif($val->notification_type == 11)
                        喜欢你的内容
                    @else
                    @endif
                @endif
            </span>

            <div class="pull-right">
                <span class="" role="button">
                    {{ date_show($val->created_at->timestamp) }}
                    {{--{{ time_show($val->created_at->getTimestamp()) }}--}}
                </span>
            </div>

        </div>


        @if($val->notification_category == 9)
        <div class="item-row item-info-row">
            @if($val->notification_type == 1)
                <span>关注了你</span>
            @else
                <span></span>
            @endif
        </div>
        @endif

        {{--@if($val->notification_category == 11 && $val->notification_type == 2)--}}
            {{--<div class="item-row item-info-row">--}}
                {{--<span>--}}
                    {{--回复了我--}}
                {{--</span>--}}
            {{--</div>--}}
        {{--@endif--}}

        {{--@if($val->notification_category == 11 && $val->notification_type == 3)--}}
            {{--<div class="item-row item-info-row">--}}
                {{--<span>--}}
                    {{--回复了--}}
                    {{--<a href="{{ url('/user/'.$val->reply->user->id) }}" target="_blank" class="user-link">--}}
                        {{--{{ $val->reply->owner->username }}--}}
                    {{--</a>--}}
                    {{--<span>:</span>--}}
                    {{--<span>{{ $val->communication->content or '' }}</span>--}}
                {{--</span>--}}
            {{--</div>--}}
        {{--@endif--}}

        @if($val->notification_category == 11 && $val->notification_type == 4)
            <div class="item-row item-info-row">
                <span>
                    <i class="fa fa-thumbs-up text-red"></i>
                </span>
            </div>
        @endif

        @if($val->notification_category == 11 && $val->notification_type == 5)
            <div class="item-row item-info-row">
                <span>
                    <i class="fa fa-thumbs-up text-red"></i>
                    点赞
                    <a href="{{ url('/user/'.$val->reply->owner->id) }}" target="_blank" class="user-link">
                    {{ $val->reply->owner->username }}
                    </a>
                    的评论
                </span>
            </div>
        @endif

        @if($val->notification_category == 11 && $val->notification_type == 11)
            <div class="item-row item-info-row">
                <span>
                    <i class="fa fa-heart text-red"></i>
                </span>
            </div>
        @endif


        <div class="item-row item-content-row _none">
            {{{ $val->communication->content or '' }}}
        </div>


        @if($val->notification_category == 11)
            @if(!empty($val->item))
            <a href="{{ url('/item/'.$val->item->id) }}" target="_blank">
                <div class="item-row forward-item-container" role="button">
                    <div class="portrait-box"><img src="{{ url(env('DOMAIN_CDN').'/'.$val->item->owner->portrait_img) }}" alt=""></div>
                    <div class="text-box">
                        @if($val->item->category == 99)
                            <div class="text-row forward-item-title">
                                {{ $val->item->content or '' }}
                            </div>
                            <div class="text-row forward-user-name">
                                转发{{ '@'.$val->item->forward_item->owner->username }} : {{ $val->item->forward_item->title or '' }}
                            </div>
                        @else
                            <div class="text-row forward-item-title">
                                {{ $val->item->title or '' }}
                            </div>
                            <div class="text-row forward-user-name">{{ '@'.$val->item->owner->username }}</div>
                        @endif
                    </div>
                </div>
                @if(in_array($val->notification_type, [1]))
                    <div class="item-row item-comment-container" role="button">
                        <div class="">
                            <span class="user-link"><b>{{ $val->communication->owner->username or '' }}</b></span>
                            @if(!empty($val->reply->reply->id))
                                <span class="font-12px">回复</span>
                                <span class="user-link"><b>{{ $val->reply->reply->owner->username or '' }}</b></span>
                            @endif
                            <span>:</span>
                            <span class="">{{ $val->communication->content or '' }}</span>
                        </div>
                    </div>
                @endif
                @if(in_array($val->notification_type, [2,3,4,5]))
                <div class="item-row item-comment-container" role="button">
                    <div class="">
                        <span class="user-link"><b>{{ $val->reply->owner->username or '' }}</b></span>
                        @if(!empty($val->reply->reply->id))
                        <span class="font-12px">回复</span>
                        <span class="user-link"><b>{{ $val->reply->reply->owner->username or '' }}</b></span>
                        @endif
                        <span>:</span>
                        <span class="">{{ $val->reply->content or '' }}</span>
                    </div>
                </div>
                @endif
                @if(in_array($val->notification_type, [2,3]))
                <div class="item-row item-comment-container margin-top-4" role="button">
                    <div class="">
                        <span class="user-link"><b>{{ $val->source->username or '' }}</b></span>
                        <span class="font-12px">回复</span>
                        <span class="user-link">{{ $val->reply->owner->username }}</span>
                        <span>:</span>
                        <span class="">{{{ $val->communication->content or '' }}}</span>
                    </div>
                </div>
                @endif
            </a>
            @else
            <div class="item-row forward-item-container" role="button" style="line-height:40px;text-align:center;">
                内容被作者删除或取消分享。
            </div>
            @endif
        @endif

        {{--tools--}}
        <div class="item-row item-tools-row _none">

            <div class="pull-right">


            </div>

        </div>


        {{--comment--}}
        <div class="item-row comment-container _none">

            <input type="hidden" class="comments-get comments-get-default">

            <div class="comment-input-container">
                <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                    {{csrf_field()}}
                    <input type="hidden" name="item_id" value="{{ $val->id or 0}}" readonly>
                    <input type="hidden" name="type" value="1" readonly>

                    <div class="item-row ">
                        <div class="comment-textarea-box">
                            <textarea class="comment-textarea" name="content" rows="2" placeholder="请输入你的评论"></textarea>
                        </div>
                        @if($val->category == 7)
                            <div class="item-row ">
                                <div class="btn-group">
                                    <button type="button" class="btn">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="support" value="0" checked="checked"> 只评论
                                            </label>
                                        </div>
                                    </button>
                                    <button type="button" class="btn">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="support" value="1"> 支持正方
                                            </label>
                                        </div>
                                    </button>
                                    <button type="button" class="btn">
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="support" value="2"> 支持反方
                                            </label>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        @endif
                        <div class="comment-button-box">
                            <a href="javascript:void(0);" class="comment-button comment-submit btn-primary" role="button">发 布</a>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
    <!-- END PORTLET-->
</div>
@endforeach

@if($notification_style == "paginate")
    {{{ $notification_list->links() }}}
@endif