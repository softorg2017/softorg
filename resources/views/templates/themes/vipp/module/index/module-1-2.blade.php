<div class="row full wrapper-module-container">
    <div class="col-md-14">
        <div class="row full block-in">

            <div class="module-header-container">
                <span class="menu-title"><b>{{ $data->menu->title or '' }}</b></span>
            </div>


            <div class="module-block-container">
                <div class="row full block-{{$data->column}}-column">

                    @foreach($data->menu->items as $v)

                        <li class="item-block item-block-1-1 case-bin">
                            <a href="{{url(config('common.org.front.prefix').'/item/'.encode($v->id))}}" title="{{$v->description or ''}}">
                                <font class="item-block-row item-block-top">
                                    <b></b>
                                    <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                </font>
                                <span class="item-block-row item-block-bottom">
                                    <h3 class="block-title multi-ellipsis-1 z-index-9">{{$v->title or ''}}</h3>
                                    @if(!empty($v->description))
                                        <p class="list-description description line-ellipsis-1">{{$v->description or ''}}</p>
                                    @endif
                                </span>
                            </a>
                        </li>

                    @endforeach

                </div>
            </div>


            <div class="module-footer-container">
                @if( count($data->menu->items) > 0 )
                    <a href="{{ url(config('common.org.front.prefix').'/menu/'.encode($data->menu->id)) }}" class="view-more visible-xs- btn-md btn-more">更多</a>
                @else
                    <a class="view-more visible-xs- btn-md btn-more">暂无</a>
                @endif
            </div>

        </div>
    </div>
</div>
