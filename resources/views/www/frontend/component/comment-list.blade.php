@foreach($comment_list as $comment)
    @include(env('TEMPLATE_DEFAULT').'frontend.component.comment')
@endforeach

