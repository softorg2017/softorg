<div class="item-option item-style-for-item-detail"
     data-item="{{ $item->id or 0 }}"
     data-id="{{ $item->id or 0 }}"
     data-item-id="{{ $item->id or 0 }}"
     data-page="page-item-detail"
>

    {{--文本部分--}}
    <div class="item-entity-section item-entity-container">


        {{--tile--}}
        <div class="item-row item-title-row margin-bottom-8px">
            <div class="text-row font-18px">
                <b>{{ $item->title or '' }}</b>
            </div>
        </div>

        {{--info--}}
        <div class="item-row item-info-row margin-bottom-2px">
            <div class="text-row">
                <span class="info-tags text-default">tags</span>
                @if($item->item_type == 88)
                    <span class="info-tags text-danger">贴片广告</span>
                @endif
                @if($item->time_type == 11)
                    <span class="info-tags text-default">活动</span>
                @endif
                <span><a href="{{ url('/user/'.$item->owner->id) }}">{{ $item->owner->username or '' }}</a></span>
                <span class="pull-right"><a class="show-menu" role="button"></a></span>
                <span class="text-muted disabled"> • {{ time_show($item->updated_at->timestamp) }}</span>
                <span class=" text-muted disabled"> • 浏览 <span class="text-blue">{{ $item->visit_num }}</span> 次</span>
                {{--<span class=" text-muted disabled"> • {{ $item->updated_at->format('Y-m-d H:i') }}</span>--}}
                <span class="pull-right"><a class="show-menu" role="button"></a></span>
            </div>
        </div>

        {{--time 时间--}}
        {{--@if($item->time_type == 1)--}}
        <div class="item-row item-time-row margin-bottom-8px">
            <div class="text-row text-muted">

                <span class="info-tags label label-success start-time-inn">今天 12：00 (开始)</span>
                <span style="font-size:12px;margin:0 4px;">至</span>
                <span class="info-tags label label-danger end-time-inn"><b>后天 12：00 (结束)</b></span>

                @if(!empty($item->start_time))
                    <span class="label label-success start-time-inn"><b>{{ time_show($item->start_time) }}</b> (开始)</span>

                @endif
                @if(!empty($item->end_time))
                    <span style="font-size:12px;margin:0 4px;">至</span>
                    <span class="label label-danger end-time-inn"><b>{{ time_show($item->end_time) }} (结束)</b></span>
                @endif
            </div>
        </div>
        {{--@endif--}}

        {{--address 地址--}}
        {{--@if(!empty($item->address))--}}
        <div class="item-row item-info-row margin-bottom-8px">
            <div class="text-row text-muted">
                <i class="icon ion-location text-blue pull-left"></i>
                <span class="">{{ $item->address or '' }} 浙江省 嘉兴市 南湖区 秋江花苑</span>
            </div>
        </div>
        {{--@endif--}}

        {{--description 描述--}}
        @if(!empty($item->description))
        <div class="item-row item-description-row with-background margin-bottom-2px">
            <div class="text-row text-description-row text-muted">
                {{ $item->description or '' }}
            </div>
        </div>
        @endif

        {{--content 图文详情--}}
        {{--@if(!empty($item->content))--}}
        <div class="item-row item-content-row margin-top-8px margin-bottom-8px">
            <article class="text-row text-content-row">
                {!! $item->content or '' !!}
            </article>
        </div>
        {{--@endif--}}




        {{--@if($item->category == 11)--}}
        <div class="" data-item="{{ $item->id }}">

            <div class="item-row navigation-box">
                <div class="item-row prev-content"><span class="label">上一篇:</span> <span class="a-box"></span></div>
                <div class="item-row next-content"><span class="label">下一篇:</span> <span class="a-box"></span></div>
            </div>

        </div>
        {{--@endif--}}




        {{--tools--}}
        <div class="item-row item-tools-row margin-top-8px margin-bottom-8px">
            <div class="text-tool-row">

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
                <a class="tool-button" role="button">
                    <i class="fa fa-share"></i> @if($item->share_num) {{ $item->share_num }} @endif
                </a>

                {{--评论--}}
                <a class="tool-button" role="button">
                    <i class="fa fa-commenting-o"></i> @if($item->comment_num) {{ $item->comment_num }} @endif
                </a>

            </div>
        </div>


    </div>






    {{--评论部分--}}
    <div class="item-comment-section">


        {{--添加评论--}}
        <div class="item-comment-block item-comment-input-section comment-container">

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

        </div>


        {{--评论列表--}}
        <div class="item-comment-block item-comment-list-section comment-entity-container">

            {{--@include('frontend.component.commentEntity.item')--}}
            <div class="comment-list-container">
                {{--@foreach($communications as $comment)--}}
                {{--@include('frontend.component.comment-list')--}}
                {{--@endforeach--}}


                <div class="box-footer box-comments">
                    <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="/AdminLTE/dist/img/user3-128x128.jpg" alt="User Image">

                        <div class="comment-text">
                      <span class="username">
                        Maria Gonzales
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                            It is a long established fact that a reader will be distracted
                            by the readable content of a page when looking at its layout.
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    <!-- /.box-comment -->
                    <div class="box-comment">
                        <!-- User image -->
                        <img class="img-circle img-sm" src="/AdminLTE/dist/img/user5-128x128.jpg" alt="User Image">

                        <div class="comment-text">
                      <span class="username">
                        Nora Havisham
                        <span class="text-muted pull-right">8:03 PM Today</span>
                      </span><!-- /.username -->
                            The point of using Lorem Ipsum is that it has a more-or-less
                            normal distribution of letters, as opposed to using
                            'Content here, content here', making it look like readable English.
                        </div>
                        <!-- /.comment-text -->
                    </div>
                    <!-- /.box-comment -->
                </div>


            </div>

            <div class="col-md-12" style="margin-top:16px;padding:0;">
                <button type="button" class="btn btn-block btn-flat btn-more comments-more">更多</button>
            </div>

            {{--@include('frontend.component.commentEntity.topic')--}}

        </div>

    </div>



</div>

