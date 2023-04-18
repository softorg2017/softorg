@foreach($item_list as $i)
@if(!empty($i->item))
<div class="a-piece item-piece item-option radius-4px {{ $getType or 'items' }}"
     data-item="{{ $i->item->id or 0}}"
     data-id="{{ $i->item->id or 0 }}"
     data-item-id="{{ $i->item->id or 0 }}"
     data-getType="{{ $getType or 'items' }}"
>

    <div class="item-container bg-white">


        <figure class="text-container clearfix">
            <div class="text-box">
                <div class="text-title-row multi-ellipsis-1">
                    <a href="{{ url('/user/'.$i->item->owner->id) }}" style="color:#ff7676;font-size:13px;">
                        <span class="item-user-portrait">
                            {{--<img src="/common/images/bg/background-image.png" data-src="{{ url(env('DOMAIN_CDN').'/'.$i->item->owner->portrait_img) }}" alt="">--}}
                            <img src="{{ url(env('DOMAIN_CDN').'/'.$i->item->owner->portrait_img) }}" alt="">
                        </span>
                        {{ $i->item->owner->username or '' }}
                    </a>
{{--                    <span class="text-muted disabled pull-right"><small>{{ date_show($i->item->updated_at->timestamp) }}</small></span>--}}
                    <span class="text-muted disabled pull-right"><small>{{ date_show($i->item->published_at) }}</small></span>
                </div>
            </div>
        </figure>


        @if(!empty($i->item->cover_pic))
            <figure class="image-container padding-top-2-5">
                <div class="image-box">
                    <a class="clearfix zoom-" target="_self" href="{{ url('/item/'.$i->item->id) }}">
                        {{--<img class="grow" src="/common/images/bg/background-image.png" data-src="{{ env('DOMAIN_CDN').'/'.$i->item->cover_pic }}" alt="Cover">--}}
                        <img class="grow" src="{{ env('DOMAIN_CDN').'/'.$i->item->cover_pic }}" alt="Cover">
                        {{--@if(!empty($i->item->cover_pic))--}}
                        {{--<img class="grow" src="{{ url(env('DOMAIN_CDN').'/'.$i->item->cover_pic) }}">--}}
                        {{--@else--}}
                        {{--<img class="grow" src="{{ url('/common/images/notexist.png') }}">--}}
                        {{--@endif--}}
                    </a>
                    {{--<span class="btn btn-warning">热销中</span>--}}
                    <span class="paste-tag-inn">
                    @if($i->item->time_type == 1)
                            @if(!empty($i->item->start_time))
                                <span class="label label-success start-time-inn"><b>{{ time_show($i->item->start_time) }}</b></span>
                            @endif
                            @if(!empty($i->item->end_time))
                                <span style="font-size:12px;">至</span>
                                <span class="label label-danger end-time-inn"><b>{{ time_show($i->item->end_time) }} (结束)</b></span>
                            @endif
                        @endif
                </span>
                </div>
            </figure>
        @endif


        <figure class="text-container clearfix">
            <div class="text-box with-border-top">

                <div class="text-row text-title-row multi-ellipsis-1 margin-top-4px margin-bottom-4px">
                    <a href="{{ url('/item/'.$i->item->id) }}"><b>{{ $i->item->title or '' }}</b></a>
                </div>

                @if(empty($i->item->cover_pic))
                    @if($i->item->time_type == 1)
                        <div class="text-row text-time-row multi-ellipsis-1">
                            @if(!empty($i->item->start_time))
                                <span class="label label-success start-time-inn"><b>{{ time_show($i->item->start_time) }}</b></span>
                            @endif
                            @if(!empty($i->item->end_time))
                                <span class="font-12px"> 至 </span>
                                <span class="label label-danger end-time-inn"><b>{{ time_show($i->item->end_time) }} (结束)</b></span>
                            @endif
                        </div>
                    @endif
                @endif

                <div class="text-title-row multi-ellipsis-1 _none">
                    <span class="info-tags text-danger">该组织•贴片广告</span>
                </div>

            </div>

            <div class="text-box with-border-top clearfix">

                <div class="text-row text-tool-row">

                    {{--浏览--}}
                    <a class="tool-button" href="{{ url('/item/'.$i->item->id) }}" role="button">
                        <span>
                            <i class="fa fa-eye"></i> @if($i->item->visit_num){{ $i->item->visit_num }} @endif
                        </span>
                    </a>

                    {{--点赞&$收藏--}}
                    <small class="tool-button operate-btn favor-btn" data-num="{{ $i->item->favor_num or 0 }}" role="button">
                        @if(Auth::check())
                            @if($i->item->pivot_item_relation->contains('relation_type', 1))
                                <a class="remove-this-favor">
                                    <i class="fa fa-heart text-red"></i>
                                    <span class="num">@if($i->item->favor_num){{ $i->item->favor_num }}@endif</span>
                                </a>
                            @else
                                <a class="add-this-favor">
                                    <i class="fa fa-heart-o"></i>
                                    <span class="num">@if($i->item->favor_num){{ $i->item->favor_num }}@endif</span>
                                </a>
                            @endif
                        @else
                            <a class="add-this-favor">
                                <i class="fa fa-heart-o"></i>
                                <span class="num">@if($i->item->favor_num){{ $i->item->favor_num }}@endif</span>
                            </a>
                        @endif
                    </small>

                    {{--分享--}}
                    <a class="tool-button _none" role="button">
                        <i class="fa fa-share"></i> @if($i->item->share_num) {{ $i->item->share_num }} @endif
                    </a>

                    {{--评论--}}
                    <a class="tool-button comment-toggle" href="{{ url('/item/'.$i->item->id) }}" role="button">
                        <span>
                            <i class="fa fa-commenting-o"></i> @if($i->item->comment_num) {{ $i->item->comment_num }} @endif
                        </span>
                    </a>

                </div>

            </div>


            <div class="text-box with-border-top text-center clearfix _none">
                <a target="_self" href="{{ url('/item/'.$i->item->id) }}">
                    <button class="btn btn-default btn-flat btn-3d btn-clicker" data-hover="点击查看" style="border-radius:0;">
                        <strong>查看详情</strong>
                    </button>
                </a>
            </div>




        </figure>

    </div>


    <!-- BEGIN PORTLET-->
    <div class="boxe panel-default- box-default item-entity-container _none">

        <div class="box-body item-row item-title-row">
            <span>
                <a href="{{ url('/item/'.$i->item->id) }}" ><b>{{ $i->item->title or '' }}</b></a>
            </span>
        </div>

        <div class="box-body item-row item-info-row">
            @if($i->item->item_type == 88)
                <span class="info-tags text-danger">广告</span>
            @endif
            @if($i->item->item_type == 11 || $i->item->time_type == 1)
                <span class="info-tags text-default">活动</span>
            @endif
            <span><a href="{{ url('/user/'.$i->item->owner->id) }}">{{ $i->item->owner->username or '' }}</a></span>
            <span class="pull-right"><a class="show-menu" role="button"></a></span>
            <span class=" text-muted disabled"> • {{ time_show($i->item->updated_at->timestamp) }}</span>
            {{--<span class=" text-muted disabled"> • {{ $i->item->updated_at->format('Y-m-d H:i') }}</span>--}}
            <span class=" text-muted disabled"> • 浏览 <span class="text-blue">{{ $i->item->visit_num }}</span> 次</span>
        </div>

        @if($i->item->time_type == 1)
            <div class="box-body item-row item-time-row text-muted">
                <div class="colo-md-12">
                    @if(!empty($i->item->start_time))
                    <span class="label label-success start-time-inn"><b>{{ time_show($i->item->start_time) }}</b> (开始)</span>
                    @endif
                    @if(!empty($i->item->end_time))
                    <span style="font-size:12px;">&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                    <span class="label label-danger end-time-inn"><b>{{ time_show($i->item->end_time) }} (结束)</b></span>
                    @endif
                </div>
            </div>
        @endif

        @if(!empty($i->item->description))
            <div class="box-body item-row item-description-row text-muted">
                <div class="colo-md-12"> {{ $i->item->description or '' }} </div>
            </div>
        @endif

        @if(!empty($i->item->content))
            <div class="box-body item-row item-content-row _none">
                <article class="colo-md-12"> {!! $i->item->content or '' !!} </article>
            </div>
        @endif


        {{--tools--}}
        <div class="box-body item-row item-tools-row item-tools-container">

            {{--点赞&$收藏--}}
            <span class="tool-button operate-btn favor-btn" data-num="{{ $i->item->favor_num or 0 }}" role="button">
                @if(Auth::check())
                    @if($i->item->pivot_item_relation->contains('relation_type', 1))
                        <a class="remove-this-favor" role="button">
                            <i class="fa fa-heart text-red"></i>
                            <span class="num">@if($i->item->favor_num){{ $i->item->favor_num }}@endif</span>
                        </a>
                    @else
                        <a class="add-this-favor" role="button">
                            <i class="fa fa-heart-o"></i>
                            <span class="num">@if($i->item->favor_num){{ $i->item->favor_num }}@endif</span>
                        </a>
                    @endif
                @else
                    <a class="add-this-favor" role="button">
                        <i class="fa fa-heart-o"></i>
                        <span class="num">@if($i->item->favor_num){{ $i->item->favor_num }}@endif</span>
                    </a>
                @endif
            </span>

            {{--分享--}}
            <a class="tool-button _none" role="button"><i class="fa fa-share"></i> @if($i->item->share_num) {{$i->item->share_num}} @endif</a>

            {{--评论--}}
            <a class="tool-button comment-toggle" role="button">
                <i class="fa fa-commenting-o"></i> @if($i->item->comment_num) {{$i->item->comment_num}} @endif
            </a>

        </div>


        {{--添加评论--}}
        <div class="box-body item-row comment-container"  style="display:none;">

            <div class="box-body comment-input-container">
            <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                {{csrf_field()}}
                <input type="hidden" name="item_id" value="{{ $i->item->id }}" readonly>
                <input type="hidden" name="type" value="1" readonly>

                <div class="form-group">
                    <div class="col-md-12">
                        <div><textarea class="form-control" name="content" rows="2" placeholder="请输入你的评论"></textarea></div>
                    </div>
                </div>

                @if($i->item->type == 2)
                <div class="form-group form-type">
                    <div class="col-md-12">
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
                </div>
                @endif

                <div class="form-group form-type _none">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="is_anonymous"> 匿名
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12 ">
                        <button type="button" class="btn btn-block btn-flat btn-primary comment-submit">提交</button>
                    </div>
                </div>

            </form>
            </div>

            @if($i->item->type == 2)
            <div class="box-body comment-choice-container">
                <div class="form-group form-type">
                    <div class="btn-group">
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="comments-get-{{encode($i->item->id)}}" checked="checked"
                                           class="comments-get comments-get-default" data-getSort="all"> 全部评论
                                </label>
                            </div>
                        </button>
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="comments-get-{{encode($i->item->id)}}" class="comments-get" data-getSort="positive">
                                    <b class="text-primary">只看【正方 <i class="fa fa-thumbs-o-up"></i>】</b>
                                </label>
                            </div>
                        </button>
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="comments-get-{{encode($i->item->id)}}" class="comments-get" data-getSort="negative">
                                    <b class="text-danger">只看【反方 <i class="fa fa-thumbs-o-up"></i>】</b>
                                </label>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
            @else
                <input type="hidden" class="comments-get comments-get-default" data-type="all">
            @endif

            {{--评论列表--}}
            <div class="box-body comment-entity-container">

                {{--@include('frontend.component.commentEntity.items')--}}
                <div class="comment-list-container">
                    {{--@if($data->type == 1)--}}
                    {{--@foreach($data->communications as $comment)--}}
                    {{--@include('frontend.component.comment')--}}
                    {{--@endforeach--}}
                    {{--@endif--}}
                </div>

                <div class="col-md-12" style="margin-top:16px;padding:0;">
                    <a href="{{ url('/item/'.$i->item->id) }}">
                        <button type="button" class="btn btn-block btn-flat btn-more" data-getType="all">更多</button>
                    </a>
                </div>

                {{--@include('frontend.component.commentEntity.topic')--}}

            </div>

        </div>

    </div>
    <!-- END PORTLET-->
</div>
@else
    <div class="item-row forward-item-container" role="button" style="line-height:40px;text-align:center;">
        内容被作者删除或取消分享。
    </div>
@endif
@endforeach

