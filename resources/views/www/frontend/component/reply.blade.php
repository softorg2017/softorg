<div class="box-body reply-piece reply-option" data-id="{{ $reply->id }}">

    {{--回复头部--}}
    <div class="box-body reply-title-container">

        @if($reply->is_anonymous == 1)
            <a href="javascript:void(0)">
                {{ $reply->user->anonymous_name }} (匿名)
                @if(Auth::check())
                    @if($reply->user->id == Auth::user()->id)
                    @endif
                @endif
            </a>
        @else
            <a target="_blank" href="{{ url('/user/'.$reply->user->id) }}" class="user">{{ $reply->user->username }}</a>
        @endif

        @if($reply->reply_id != $reply->dialog_id)
        @if($reply->reply)
            <small class="text-muted">回复</small>
            @if($reply->reply->is_anonymous == 1)
                <a href="javascript:void(0)">
                    {{ $reply->reply->user->anonymous_name}} (匿名)
                    @if(Auth::check())
                        @if($reply->reply->user->id == Auth::user()->id)
                        @endif
                    @endif
                </a>
            @else
                <a target="_blank" href="{{ url('/user/'.$reply->reply->user->id) }}" class="user">{{ $reply->reply->user->username }}</a>
            @endif
        @endif
        @endif
        <span class="text-muted">:</span>
        {{ $reply->content }} <br>

    </div>


    {{--回复工具--}}
    <div class="box-body reply-tools-container">

        <span class="pull-left text-muted disabled"><small>{{ time_show($reply->updated_at->timestamp) }}</small></span>

        <span class="pull-right comment-btn comment-favor-btn" data-num="{{ $reply->favor_num or 0 }}">
            @if(Auth::check())
                @if(count($reply->favors))
                    <span class="pull-right text-muted disabled comment-favor-this-cancel" data-parent=".reply-option" role="button">
                        <i class="fa fa-thumbs-up text-red"></i>
                        @if($reply->favor_num)<span>{{ $reply->favor_num }}</span>@endif
                    </span>
                @else
                    <span class="pull-right text-muted disabled comment-favor-this" data-parent=".reply-option" role="button">
                        <i class="fa fa-thumbs-o-up"></i>
                        @if($reply->favor_num)<span>{{ $reply->favor_num }}</span>@endif
                    </span>
                @endif
            @else
                <span class="pull-right text-muted disabled comment-favor-this" data-parent=".reply-option" role="button">
                    <i class="fa fa-thumbs-o-up"></i>
                    @if($reply->favor_num)<span>{{ $reply->favor_num }}</span>@endif
                </span>
            @endif
        </span>

        <span class="separator pull-right">|</span>
        <span class="pull-right text-muted disabled comment-btn reply-toggle" role="button" data-num="{{ $reply->comment_num }}">
            <small>回复</small> @if($reply->comment_num){{ $reply->comment_num }}@endif
        </span>

    </div>


    {{--回复输入框--}}
    <div class="box-body reply-input-container">

        <div class="input-group margin">
            <input type="text" class="form-control reply-content">

            <span class="input-group-addon _none">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="is_anonymous" class="reply-anonymous"><small>匿名</small>
                    </label>
                </div>
            </span>

            <span class="input-group-btn">
                  <button type="button" class="btn btn-primary btn-flat reply-submit">回复</button>
            </span>
        </div>

    </div>

</div>

