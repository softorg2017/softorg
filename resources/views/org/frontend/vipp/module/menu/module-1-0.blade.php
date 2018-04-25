<div class="row full wrapper-module-container wrapper-menu-container">
    <div class="col-md-14">
        <div class="row full block-in">

            <div class="module-header-container">
                <span class="menu-title"><b>{{ $data->title }}</b></span>
            </div>

            <div class="module-block-container">
                <div class="row full block-3-column">

                    <div class="block-list">

                    @foreach($items as $v)

                        <div class="media" role="button">
                            <div class="media-left">
                                <a href="{{url(config('common.org.front.prefix').'/item/'.encode($v->id))}}">
                                    @if(!empty($v->cover_pic))
                                        <img class="media-object" src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                    @else
                                        <img class="media-object" src="{{ $v->img_tags[2][0] or '' }}">
                                    @endif
                                </a>
                            </div>
                            <div class="media-body">
                                <div class="media-title-row multi-ellipsis-2">
                                    <a href="{{url(config('common.org.front.prefix').'/item/'.encode($v->id))}}">
                                        <b> {{ $v->title or '' }} </b>
                                    </a>
                                </div>
                                <div class="media-description-row multi-ellipsis-1">{{ $v->description or '' }}</div>
                            </div>
                        </div>

                    @endforeach

                    </div>

                </div>
            </div>

            {{ $items->links() }}

        </div>
    </div>
</div>
