<div class="box-body comment-piece comment-option" data-id="{{ $comment->id or 0 }}">

    <div class="box-body comment-title-container">
        @if($comment->is_anonymous == 1)
            <a href="javascript:void(0)">
                {{ $comment->user->anonymous_name }} (匿名)
                @if(Auth::check())
                    @if($comment->user->id == Auth::user()->id)
                    @endif
                @endif
            </a>
        @else
            <a href="{{ url('/user/'.$comment->user->id) }}" class="user">{{ $comment->user->username }}</a>
        @endif

        {{--@if($comment->reply_id != $comment->dialog_id)--}}
            @if($comment->reply)
                <small class="text-muted">回复</small>
                @if($comment->reply->is_anonymous == 1)
                    <a href="javascript:void(0)">
                        {{ $reply->reply->user->anonymous_name}} (匿名)
                        @if(Auth::check())
                            @if($comment->reply->user->id == Auth::user()->id)
                            @endif
                        @endif
                    </a>
                @else
                    <a target="_blank" href="{{ url('/user/'.$comment->reply->user->id) }}" class="user">{{ $comment->reply->user->username }}</a>
                @endif
            @endif
        {{--@endif--}}
        <span class="text-muted">:</span>
        {{ $comment->content }} <br>
    </div>

    <div class="box-body comment-content-container _none">
        {{ $comment->content }} <br>
    </div>

    <div class="box-body comment-tools-container">

        @if($comment->support == 1) <b class="text-primary">【正方 <i class="fa fa-thumbs-o-up"></i>】</b>
        @elseif($comment->support == 2) <b class="text-danger">【反方 <i class="fa fa-thumbs-o-up"></i>】</b>
        @endif

        <span class="pull-right comment-favor-btn" data-num="{{ $comment->favor_num or 0 }}">
            @if(Auth::check())
                @if(count($comment->favors))
                    <span class="comment-btn pull-right text-muted disabled comment-favor-this-cancel" data-parent=".comment-option" role="button">
                        <i class="fa fa-thumbs-up text-red"></i>
                        @if($comment->favor_num)<span>{{ $comment->favor_num }}</span>@endif
                    </span>
                @else
                    <span class="comment-btn pull-right text-muted disabled comment-favor-this" data-parent=".comment-option" role="button">
                        <i class="fa fa-thumbs-o-up"></i>
                        @if($comment->favor_num)<span>{{ $comment->favor_num }}</span>@endif
                    </span>
                @endif
            @else
                <span class="comment-btn pull-right text-muted disabled comment-favor-this" data-parent=".comment-option" role="button">
                    <i class="fa fa-thumbs-o-up"></i>
                    @if($comment->favor_num)<span>{{ $comment->favor_num }}</span>@endif
                </span>
            @endif
        </span>

        <span class="separator pull-right">|</span>
        <span class="comment-btn pull-right text-muted disabled comment-reply-toggle" role="button" data-num="{{ $comment->comment_num or 0 }}">
            <small>回复</small> @if($comment->comment_num){{ $comment->comment_num }}@endif
        </span>

        <span class="separator pull-left _none">•</span>
        <span class="pull-left text-muted disabled"><small>{{ time_show($comment->updated_at->timestamp) }}</small></span>

    </div>

    <div class="box-body comment-reply-input-container">

        <div class="input-group margin">
            <input type="text" class="form-control comment-reply-content">

            <span class="input-group-addon _none">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="is_anonymous" class="comment-reply-anonymous">匿名
                    </label>
                </div>
            </span>

            <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-flat comment-reply-submit">回复</button>
            </span>
        </div>

    </div>

    <div class="box-body reply-container">

        <div class="reply-list-container"></div>

        @if($comment->dialogs_count)
            <div class="item-row more-box">
                <button type="button" class="btn btn-block btn-flat- btn-more replies-more"
                        data-more="{{ $comment->dialog_more}}"
                        data-maxId="{{ $comment->dialog_max_id}}"
                        data-minId="{{ $comment->dialog_min_id}}"
                >{!! $comment->dialog_more_text !!}</button>
            </div>
        @endif

        {{--<div class="reply-list-container">--}}
        {{--@if(count($comment->dialogs))--}}
        {{--@foreach($comment->dialogs as $reply)--}}
        {{--@include('frontend.component.reply')--}}
        {{--@endforeach--}}
        {{--@endif--}}
        {{--</div>--}}

        {{--@if(count($comment->dialogs))--}}
        {{--<div class="col-md-12 more-box" style="margin-top:4px;">--}}
        {{--<button type="button" class="btn btn-block btn-flat btn-default replies-more">更多</button>--}}
        {{--</div>--}}
        {{--@endif--}}

    </div>

</div>

