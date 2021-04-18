@foreach($communication_list as $reply)
    @include(env('TEMPLATE_DEFAULT').'frontend.component.reply')
@endforeach
