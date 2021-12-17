<div class="main-side-block main-side-block-padding side-menu main-side-container pull-left padding-8px bg-white">

    <a href="javascript:void(0);" class="visible-xs visible-sm header-hide-side side-hidden" role="button"><i class="fa fa-remove"></i></a>


    <div class="col-md-12 recursion-row" data-level="0">
        <div class="recursion-menu">
            <span class="recursion-icon">
                <i class="fa fa-bookmark text-orange"></i>
            </span>

            <span class="recursion-text @if($parent_item->id == $item->id) active @endif">
                <a class="row-ellipsis" href="{{ url('/item/'.$parent_item->id) }}">
                    <b>{{ $parent_item->title or '' }}</b>
                </a>
            </span>
        </div>
    </div>


    @foreach($time_points as $num => $val)
    <div class="col-md-12 recursion-row" data-level="{{ $val->level or 0 }}" data-id="{{ $val->id or 0 }}"
         style="">
        {{--style="">--}}
        <div class="recursion-menu">
            <span class="recursion-icon">
                    <i class="fa fa-circle-o"></i>
            </span>
            <span class="recursion-text @if($val->id == $item->id) active @endif font-sm">
                <a class="row-ellipsis" href="{{ url('/item/'.$val->id) }}">
                    {{ $val->time_point or '' }}
                </a>
            </span>
            <span class="recursion-text @if($val->id == $item->id) active @endif font-sm">
                <a class="row-ellipsis" href="{{ url('/item/'.$val->id) }}">
                    {{ $val->title or '' }}
                </a>
            </span>
        </div>
    </div>
    @endforeach




    <div class="col-md-12 _none">

        <div>
            <h2><a href="{{ url('/item/'.$parent_item->id) }}"><b class="font-lg">{{ $parent_item->title or '' }}</b></a></h2>
        </div>

        <ul class="cbp_tmtimeline">
            @foreach($time_points as $num => $val)
                <li @if($val->id == $item->id) class="active" @endif>
                    <div class="cbp_tmicon"></div>
                    <time class="cbp_tmtime" datetime="">
                        <a href="{{ url('/item/'.$val->id) }}"><span class="font-sm" role="button">{{ $val->time_point or '' }}</span></a>
                    </time>
                    <div class="cbp_tmlabel">
                        <h2><a href="{{ url('/item/'.$val->id) }}"><b>{{ $val->title or '' }}</b></a></h2>
                        <div class="media _none">
                            <div class="media-left">
                                @if(!empty($val->cover_pic))
                                    <a href="{{ url('/item/'.$val->id) }}">
                                        <img class="media-object" src="{{ url(env('DOMAIN_CDN').'/'.$item->cover_pic )}}">
                                    </a>
                                @else
                                    <a href="{{ url('/item/'.$val->id) }}">
                                        <img class="media-object" src="{{ $val->img_tags[2][0] or '' }}">
                                    </a>
                                @endif
                            </div>
                            <div class="media-body">
                                <div class="clearfix">
                                    @if(!empty($item->description))
                                        <article class="colo-md-12">{{{ $val->description or '' }}}</article>
                                    @else
                                        <article class="colo-md-12">{!! $val->content_show or '' !!}</article>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>



    </div>


</div>