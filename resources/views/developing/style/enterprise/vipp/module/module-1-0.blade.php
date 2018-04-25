<div class="row full wrapper-module-container">
    <div class="col-md-14">
        <div class="row full block-in">
            <div class="module-header-container">
                <span class="menu-title"><b>{{ $data->menu->title }}</b></span>
            </div>
            <div class="module-block-container">
                <div class="row full block-{{$data->column}}-column">

                    @foreach($data->menu->items as $v)
                        <a href="{{url(config('common.org.front.prefix').'/item/'.encode($v->id))}}">
                            <li class="item-block item-block-1-1" role="button">
                                <div class="item-block-row item-block-top">
                                    <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                </div>
                                <div class="item-block-row item-block-bottom">
                                    <span class="block-title multi-ellipsis-1 z-index-9">{{$v->title or ''}}</span>
                                    @if(!empty($v->description))
                                        <p class="list-description description line-ellipsis-1">{{$v->description or ''}}</p>
                                    @endif
                                </div>
                            </li>
                        </a>
                    @endforeach

                </div>
            </div>

            @if( count($data->menu->items) == 0 )
                <span class="view-more visible-xs">暂无</span>
            @else
                <div>
                </div>
            @endif

            @if( count($data->menu->items) > 0 )
                <div class="module-footer-container">
                    <a href="{{ url(config('common.org.front.prefix').'/menu/'.encode($data->menu->id)) }}" class="view-more visible-xs- btn-md btn-more">更多</a>
                </div>
            @else
                <a class="view-more visible-xs- btn-md btn-more">暂无</a>
            @endif

        </div>
    </div>
</div>
