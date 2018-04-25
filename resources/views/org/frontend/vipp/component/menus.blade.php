{{--自定义目录栏位--}}
{{--3栏/4栏--}}
@if( count($org->menus) != 0 )
    @foreach($org->menus as $menu)
        {{--@if( count($menu->items) != 0 )--}}
        {{--block-in-3--}}
        <div class="row full wrapper-module-container">
            <div class="col-md-14">
                <div class="row full block-in">
                    <div class="module-header-container">
                        <span class="menu-title"><b>{{ $menu->title }}</b></span>
                    </div>
                    <div class="module-block-container">
                        <div class="row full block-4-column">
                            @foreach($menu->items as $v)
                                <a href="{{url(config('common.org.front.prefix').'/item/'.encode($v->id))}}">
                                    <li class="item-block" role="button">
                                        <div class="item-block-top">
                                            <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                        </div>
                                        <div class="item-block-bottom">
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

                    @if( count($menu->items) == 0 )
                        <span class="view-more visible-xs">暂无</span>
                    @else
                        <div>
                        </div>
                    @endif
                    @if( count($menu->items) > 0 )
                        <div class="module-footer-container">
                            <a href="{{ url(config('common.org.front.prefix').'/menu/'.encode($menu->id)) }}" class="view-more visible-xs- btn-md btn-more">更多</a>
                        </div>
                    @else
                        <a class="view-more visible-xs- btn-md btn-more">暂无</a>
                    @endif

                </div>
            </div>
        </div>
        {{--@endif--}}
    @endforeach
@endif