<div class="row full wrapper-module-container">
    <div class="col-md-14">
        <div class="row full block-in">

            <div class="module-header-container">
                <span class="menu-title"><b>{{ $data->menu->title or '' }}</b></span>
            </div>


            <div class="module-block-container">
                <div class="row full block-{{$data->column}}-column">

                    <div class="icon-box icon-type-0">
                        <ul>
                            @foreach($data->menu->items as $v)

                                <li>
                                    <a title="高端定制网站" href="#">

                                        <i class="">
                                            <img src="{{ config('common.host.'.env('APP_ENV').'.cdn').'/'.$v->cover_pic }}" alt="">
                                        </i>

                                        <h3 class="block-title multi-ellipsis-1 z-index-9">{{$v->title or ''}}</h3>
                                        @if(!empty($v->description))
                                            <p class="list-description description line-ellipsis-1">{{$v->description or ''}}</p>
                                        @endif
                                    </a>
                                </li>

                            @endforeach
                        </ul>
                    </div>

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
