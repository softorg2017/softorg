<div class="item-piece item-option {{ $getTypes or 'items' }}"
     data-item="{{ $item->id or 0}}"
     data-id="{{ $item->id or 0}}"
     data-item-id="{{ $item->id or 0}}"
     data-getType="{{ $getType or 'item' }}"
     style="border-radius:0;"
>

    <div class="item-container">


        <figure class="text-container clearfix">

            <div class="text-box">

                <div class="text-row text-title-row margin-bottom-8px font-18px">
                    {{ $item->title or '' }}
                </div>

                <div class="text-row text-info-row margin-bottom-8px">
                    <span><a href="{{ url('/user/'.$item->owner->id) }}">{{ $item->owner->username or '' }}</a></span>
                    <span class="pull-right"><a class="show-menu" role="button"></a></span>
                    <span class="text-muted disabled"> • {{ date_show($item->updated_at->timestamp) }}</span>
                    <span class="text-muted disabled"> • {{ $item->visit_num }}次浏览</span>
                    {{--<span class=" text-muted disabled"> • {{ $item->updated_at->format('Y-m-d H:i') }}</span>--}}
                </div>

                @if($item->time_type == 1)
                    <div class="text-row item-time-row margin-bottom-8px text-muted">
                        <div class="colo-md-12">
                            @if(!empty($item->start_time))
                                <span class="label label-success start-time-inn"><b>{{ time_show($item->start_time) }}</b> (开始)</span>
                            @endif
                            @if(!empty($item->end_time))
                                <span style="font-size:12px;">&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                                <span class="label label-danger end-time-inn"><b>{{ time_show($item->end_time) }} (结束)</b></span>
                            @endif
                        </div>
                    </div>
                @endif

                @if(!empty($item->address))
                    <div class="text-row text-info-row text-muted margin-bottom-8px">
                        <i class="icon ion-location text-blue" style="width:16px;text-align:center;"></i>
                        <span class="">{{ $item->address or '' }}</span>
                    </div>
                @endif

                @if(!empty($item->description))
                    <div class="text-row text-description-row text-muted margin-bottom-8px">
                        {{ $item->description or '' }}
                    </div>
                @endif

                @if(!empty($item->content))
                    <div class="text-row text-content-row margin-top-8px margin-bottom-8px">
                        <article class="colo-md-12"> {!! $item->content or '' !!} </article>
                    </div>
                @endif

            </div>

        </figure>


        <figure class="text-container clearfix">

            <div class="text-box with-border-top clearfix">

                <div class="text-tool-row">

                    {{--点赞&$收藏--}}
                    <small class="tool-button operate-btn favor-btn" data-num="{{ $item->favor_num or 0 }}" role="button">
                        @if(Auth::check())
                            @if($item->pivot_item_relation->contains('relation_type', 1))
                                <a class="remove-this-favor">
                                    <i class="fa fa-heart text-red"></i>
                                    <span class="num">@if($item->favor_num){{ $item->favor_num }}@endif</span>
                                </a>
                            @else
                                <a class="add-this-favor">
                                    <i class="fa fa-heart-o"></i>
                                    <span class="num">@if($item->favor_num){{ $item->favor_num }}@endif</span>
                                </a>
                            @endif
                        @else
                            <a class="add-this-favor">
                                <i class="fa fa-heart-o"></i>
                                <span class="num">@if($item->favor_num){{ $item->favor_num }}@endif</span>
                            </a>
                        @endif
                    </small>

                    {{--分享--}}
                    <a class="tool-button _none" role="button">
                        <i class="fa fa-share"></i> @if($item->share_num) {{ $item->share_num }} @endif
                    </a>

                    {{--评论--}}
                    <a class="tool-button comment-toggle" role="button">
                        <span>
                            <i class="fa fa-commenting-o"></i> @if($item->comment_num) {{ $item->comment_num }} @endif
                        </span>
                    </a>

                </div>

            </div>

        </figure>


    </div>



    <!-- BEGIN PORTLET-->
    <div class="boxe panel-default- box-default item-entity-container">

        <div class="box-body item-row item-title-row _none">
            <span>
                <a href="{{ url('/item/'.$item->id) }}" ><b>{{ $item->title or '' }}</b></a>
            </span>
        </div>

        <div class="box-body item-row item-info-row _none">
            @if($item->item_type == 88)
                <span class="info-tags text-danger">贴片广告</span>
            @endif
            @if($item->time_type == 11)
                <span class="info-tags text-default">活动</span>
            @endif
            <span><a href="{{ url('/user/'.$item->owner->id) }}">{{ $item->owner->username or '' }}</a></span>
            <span class="pull-right"><a class="show-menu" role="button"></a></span>
            <span class=" text-muted disabled"> • {{ date_show($item->updated_at->timestamp) }}</span>
            {{--<span class=" text-muted disabled"> • {{ $item->updated_at->format('Y-m-d H:i') }}</span>--}}
            <span class=" text-muted disabled"> • 浏览 <span class="text-blue">{{ $item->visit_num }}</span> 次</span>
        </div>

        @if($item->time_type == 1)
            <div class="box-body item-row item-time-row text-muted _none">
                <div class="colo-md-12">
                    @if(!empty($item->start_time))
                    <span class="label label-success start-time-inn"><b>{{ time_show($item->start_time) }}</b> (开始)</span>
                    @endif
                    @if(!empty($item->end_time))
                    <span style="font-size:12px;">&nbsp;&nbsp;至&nbsp;&nbsp;</span>
                    <span class="label label-danger end-time-inn"><b>{{ time_show($item->end_time) }} (结束)</b></span>
                    @endif
                </div>
            </div>
        @endif

        @if(!empty($item->description))
            <div class="box-body item-row item-description-row text-muted _none">
                <div class="colo-md-12"> {{ $item->description or '' }} </div>
            </div>
        @endif

        @if(!empty($item->content))
            <div class="box-body item-row item-content-row _none">
                <article class="colo-md-12"> {!! $item->content or '' !!} </article>
            </div>
        @endif


        {{--tools--}}
        <div class="box-body item-row item-tools-row item-tools-container _none">

            {{--点赞&$收藏--}}
            <span class="tool-button operate-btn favor-btn" data-num="{{ $item->favor_num or 0 }}" role="button">
                @if(Auth::check())
                    @if($item->pivot_item_relation->contains('relation_type', 1))
                        <a class="remove-this-favor">
                            <i class="fa fa-heart text-red"></i>
                            <span class="num">@if($item->favor_num){{ $item->favor_num }}@endif</span>
                        </a>
                    @else
                        <a class="add-this-favor">
                            <i class="fa fa-heart-o"></i>
                            <span class="num">@if($item->favor_num){{ $item->favor_num }}@endif</span>
                        </a>
                    @endif
                @else
                    <a class="add-this-favor">
                        <i class="fa fa-heart-o"></i>
                        <span class="num">@if($item->favor_num){{ $item->favor_num }}@endif</span>
                    </a>
                @endif
            </span>

            {{--分享--}}
            <a class="tool-button _none" role="button"><i class="fa fa-share"></i> @if($item->share_num) {{$item->share_num}} @endif</a>

            {{--评论--}}
            <a class="tool-button" role="button">
                <i class="fa fa-commenting-o"></i> @if($item->comment_num) {{$item->comment_num}} @endif
            </a>

        </div>


        {{--添加评论--}}
        <div class="box-body item-row comment-container">

            <div class="box-body comment-input-container">
            <form action="" method="post" class="form-horizontal form-bordered item-comment-form">

                {{csrf_field()}}
                <input type="hidden" name="item_id" value="{{ $item->id }}" readonly>
                <input type="hidden" name="type" value="1" readonly>

                <div class="form-group">
                    <div class="col-md-12">
                        <div><textarea class="form-control" name="content" rows="2" placeholder="请输入你的评论"></textarea></div>
                    </div>
                </div>

                @if($item->type == 2)
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
                                <input type="checkbox" name="is_anonymous">匿名
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

            @if($item->type == 2)
            <div class="box-body comment-choice-container">
                <div class="form-group form-type">
                    <div class="btn-group">
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="comments-get-{{encode($item->id)}}" checked="checked"
                                           class="comments-get comments-get-default" data-getSort="all"> 全部评论
                                </label>
                            </div>
                        </button>
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="comments-get-{{encode($item->id)}}" class="comments-get" data-getSort="positive">
                                    <b class="text-primary">只看【正方 <i class="fa fa-thumbs-o-up"></i>】</b>
                                </label>
                            </div>
                        </button>
                        <button type="button" class="btn">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="comments-get-{{encode($item->id)}}" class="comments-get" data-getSort="negative">
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

                {{--@include('frontend.component.commentEntity.item')--}}
                <div class="comment-list-container">
                    {{--@foreach($communications as $comment)--}}
                    {{--@include('frontend.component.comment')--}}
                    {{--@endforeach--}}
                </div>

                <div class="col-md-12" style="margin-top:16px;padding:0;">
                    <button type="button" class="btn btn-block btn-flat btn-more comments-more">更多</button>
                </div>

                {{--@include('frontend.component.commentEntity.topic')--}}

            </div>

        </div>

    </div>
    <!-- END PORTLET-->
</div>

