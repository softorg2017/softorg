
<div class="comment-list-container">
    {{--@if($data->type == 1)--}}
        {{--@foreach($data->communications as $comment)--}}
            {{--@include('frontend.component.comment')--}}
        {{--@endforeach--}}
    {{--@endif--}}
</div>

<div class="col-md-12" style="margin-top:16px;padding:0;">
    <a href="{{url('/topic/'.encode($item->id))}}" target="_blank">
        <button type="button" class="btn btn-block btn-flat btn-more" data-getType="all">更多</button>
    </a>
</div>


