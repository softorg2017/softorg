<div class="box-body right-menu main-side-block main-side-block-padding side-menu main-side-container pull-left padding-8px bg-white">


    {{--<a href="javascript:void(0);" class="visible-xs visible-sm header-hide-side side-hidden _none" role="button"><i class="fa fa-remove"></i></a>--}}

    <div class="col-md-12 _none">
        <span class="recursion-icon">
            <i class="fa fa-search text-orange"></i>
        </span>
        <span class="recursion-text">
            <a href="javascript:void(0)">总浏览 <b class="text-blue font-xs">{{ $parent_item->visit_total or 0 }}</b> 次</a>
        </span>
    </div>

    <div class="col-md-12 _none">
        <span class="recursion-icon" >
            <i class="fa fa-comment text-orange"></i>
        </span>
        <span class="recursion-text">
            <a href="javascript:void(0)">总评论 <b class="text-blue font-xs" >{{ $parent_item->comments_total or 0 }}</b> 个</a>
        </span>
    </div>


    {{--封页--}}
    <div class="col-md-12 recursion-row" data-level="0">
        <div class="recursion-menu @if($parent_item->id == $item->id) active @endif">
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


    {{----}}
    <div class="col-md-12 main-side-menu-header" role="button">
        <div class="col-xs-6 col-sm-6 col-md-6 fold-button fold-down" role="button" style="text-align:left;">
            <i class="fa fa-plus-square"></i> 全部展开
        </div>
        <div class="col-xs-6 col-sm-6 col-md-6 fold-button fold-up" role="button" style="text-align:right;">
            <i class="fa fa-minus-square"></i> 全部折叠
        </div>
    </div>


    {{----}}
    @foreach( $contents_recursion as $key => $recursion )
        <div class="col-md-12 recursion-row"
             data-level="{{ $recursion->level or 0 }}"
             data-id="{{ $recursion->id or 0 }}"
             style="display:@if($recursion->level != 0) none @else block @endif">
             {{--style="">--}}
            <div class="recursion-menu @if($recursion->id == $item->id) active @endif" style="margin-left:{{ $recursion->level*16 }}px">
                <span class="recursion-icon">
                    {{--@if($recursion->type == 1)--}}
                        @if($recursion->has_child == 1)
                            <i class="fa fa-plus-square recursion-fold"></i>
                        @else
                            <small><i class="fa fa-file-text"></i></small>
                        @endif
                    {{--@else--}}
                        {{--<i class="fa fa-file-text"></i>--}}
                    {{--@endif--}}
                </span>
                <span class="recursion-text font-sm @if($recursion->id == $item->id) active @endif">
                    <a class="row-ellipsis" href="{{ url('/item/'.$recursion->id) }}">
                        {{ $recursion->title or '' }}
                    </a>
                </span>
            </div>
        </div>
    @endforeach


</div>